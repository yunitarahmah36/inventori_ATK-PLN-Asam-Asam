<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('stock_movements')) {
            if (DB::getDriverName() === 'mysql') {
                // Ubah tipe kolom activity menjadi VARCHAR(50) di MySQL agar mendukung aktivitas 'Keluar'
                DB::statement("ALTER TABLE `stock_movements` MODIFY COLUMN `activity` VARCHAR(50) NOT NULL");
            } else {
                Schema::table('stock_movements', function (Blueprint $table) {
                    $table->string('activity', 50)->change();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('stock_movements')) {
            if (DB::getDriverName() === 'mysql') {
                DB::statement("ALTER TABLE `stock_movements` MODIFY COLUMN `activity` ENUM('Tambah', 'Edit', 'Hapus', 'Import') NOT NULL");
            }
        }
    }
};
