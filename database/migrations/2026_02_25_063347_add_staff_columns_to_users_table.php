<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom khusus untuk petugas/staff
            $table->string('staff_code')->unique()->nullable()->after('id');
            $table->string('position')->nullable()->after('role'); // Jabatan (Petugas Gudang, Verifikasi, dll)
            $table->enum('staff_status', ['active', 'cuti', 'inactive'])->default('active')->after('position');
            $table->date('join_date')->nullable()->after('staff_status');
            $table->text('notes')->nullable()->after('join_date');
            
            // Index untuk pencarian
            $table->index('staff_code');
            $table->index('position');
            $table->index('staff_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['staff_code']);
            $table->dropIndex(['position']);
            $table->dropIndex(['staff_status']);
            $table->dropColumn(['staff_code', 'position', 'staff_status', 'join_date', 'notes']);
        });
    }
};