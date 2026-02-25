<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom jika belum ada
            if (!Schema::hasColumn('users', 'staff_code')) {
                $table->string('staff_code')->unique()->nullable()->after('id');
            }
            if (!Schema::hasColumn('users', 'position')) {
                $table->string('position')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'staff_status')) {
                $table->enum('staff_status', ['active', 'cuti', 'inactive'])->default('active')->after('position');
            }
            if (!Schema::hasColumn('users', 'join_date')) {
                $table->date('join_date')->nullable()->after('staff_status');
            }
            if (!Schema::hasColumn('users', 'notes')) {
                $table->text('notes')->nullable()->after('join_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['staff_code', 'position', 'staff_status', 'join_date', 'notes']);
        });
    }
};