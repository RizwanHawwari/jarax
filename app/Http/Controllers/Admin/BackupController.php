<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Super Admin.');
        }

        $this->ensureBackupDirectoryExists();

        $backups = [];
        if (Storage::disk('public')->exists('backups')) {
            $files = Storage::disk('public')->files('backups');
            foreach ($files as $file) {
                $backups[] = [
                    'name' => basename($file),
                    'path' => $file,
                    'size' => $this->formatFileSize(Storage::disk('public')->size($file)),
                    'size_bytes' => Storage::disk('public')->size($file),
                    'created_at' => Carbon::createFromTimestamp(Storage::disk('public')->lastModified($file)),
                ];
            }
        }

        usort($backups, function ($a, $b) {
            return $b['created_at']->timestamp - $a['created_at']->timestamp;
        });

        $totalSize = array_sum(array_column($backups, 'size_bytes'));
        $storageLimit = 1 * 1024 * 1024 * 1024;
        $storagePercentage = ($totalSize / $storageLimit) * 100;
        $totalSizeFormatted = $this->formatFileSize($totalSize);

        $tables = DB::select('SHOW TABLES');

        $dbStats = [
            'tables' => $tables,
            'tables_count' => count($tables),
            'size' => $this->getDatabaseSize(),
        ];

        return view('admin.backup.index', compact(
            'backups',
            'totalSize',
            'totalSizeFormatted',
            'storagePercentage',
            'dbStats'
        ));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        try {
            $this->ensureBackupDirectoryExists();

            $filename = 'backup-' . now()->format('Y-m-d-H-i-s') . '.sql';
            $path = storage_path('app/public/backups/' . $filename);

            $tables = DB::select('SHOW TABLES');
            $dbName = config('database.connections.mysql.database');
            $sql = "-- Database Backup\n";
            $sql .= "-- Database: {$dbName}\n";
            $sql .= "-- Generated: " . now()->format('Y-m-d H:i:s') . "\n\n";

            foreach ($tables as $table) {
                $tableName = array_values((array)$table)[0];

                $createTable = DB::select("SHOW CREATE TABLE {$tableName}");
                $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                $sql .= $createTable[0]->{'Create Table'} . ";\n\n";

                $rows = DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    foreach ($rows as $row) {
                        $values = array_map(function ($value) {
                            return $value === null ? 'NULL' : "'" . addslashes($value) . "'";
                        }, (array)$row);
                        $sql .= "INSERT INTO `{$tableName}` VALUES (" . implode(',', $values) . ");\n";
                    }
                    $sql .= "\n";
                }
            }

            file_put_contents($path, $sql);

            return redirect()->back()->with('success', 'Backup berhasil dibuat! File: ' . $filename);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Backup gagal: ' . $e->getMessage());
        }
    }

    public function download($filename)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $path = storage_path('app/public/backups/' . $filename);

        if (file_exists($path)) {
            return response()->download($path);
        }

        return redirect()->back()->with('error', 'File backup tidak ditemukan.');
    }

    public function destroy($filename)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $path = 'backups/' . $filename;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return redirect()->back()->with('success', 'Backup berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'File backup tidak ditemukan.');
    }

    public function restore(Request $request)
{
    if (!auth()->user()->isAdmin()) {
        abort(403, 'Unauthorized');
    }

    $request->validate([
        'backup_file' => 'required|string',
        'confirmation' => 'required|in:I_UNDERSTAND',
    ]);

    try {
        $filename = $request->backup_file;
        $path = storage_path('app/public/backups/' . $filename);

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'File backup tidak ditemukan.');
        }

        // LANGKAH BARU: Bersihkan database dulu (Drop semua tabel)
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            // Jangan hapus tabel migrations jika ingin aman, tapi untuk full restore kita hapus semua
            DB::statement("DROP TABLE IF EXISTS `$tableName`");
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        // Baca file SQL
        $sql = file_get_contents($path);

        // Pecah berdasarkan titik koma (;) tapi hati-hati dengan komentar
        $statements = array_filter(array_map('trim', explode(';', $sql)));

        DB::beginTransaction();
        foreach ($statements as $statement) {
            // Abaikan baris kosong atau komentar
            if (!empty($statement) && !str_starts_with($statement, '--') && !str_starts_with($statement, '/*')) {
                try {
                    DB::statement($statement);
                } catch (\Exception $e) {
                    // Lanjutkan jika error minor, atau log saja
                    \Log::warning("Skip statement: " . substr($statement, 0, 50));
                }
            }
        }
        DB::commit();

        // Clear cache laravel setelah restore agar config fresh
        Artisan::call('cache:clear');
        Artisan::call('config:clear');

        return redirect()->back()->with('success', 'Restore berhasil! Database telah dikembalikan sepenuhnya. Silakan login ulang.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Restore gagal: ' . $e->getMessage());
    }
}

    public function upload(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'file' => 'required|file|mimes:sql,zip,gz|max:102400',
        ]);

        try {
            $this->ensureBackupDirectoryExists();

            $file = $request->file('file');
            $filename = 'upload-' . now()->format('Y-m-d-H-i-s') . '-' . $file->getClientOriginalName();

            $file->storeAs('backups', $filename, 'public');

            return redirect()->back()->with('success', 'File backup berhasil diupload!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Upload gagal: ' . $e->getMessage());
        }
    }

    private function formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    private function getDatabaseSize()
    {
        $result = DB::select("
            SELECT SUM(data_length + index_length) AS size
            FROM information_schema.TABLES
            WHERE table_schema = '" . config('database.connections.mysql.database') . "'
        ");

        return $this->formatFileSize($result[0]->size ?? 0);
    }

    private function ensureBackupDirectoryExists()
    {
        $path = storage_path('app/public/backups');
        if (!file_exists($path)) {
            mkdir($path, 0775, true);
        }
    }
}
