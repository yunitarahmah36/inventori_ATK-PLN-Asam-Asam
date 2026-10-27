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
        if (Schema::hasTable('book_loans') && Schema::hasColumn('book_loans', 'loan_code')) {
            if (DB::getDriverName() === 'mysql') {
                try {
                    Schema::table('book_loans', function (Blueprint $table) {
                        $table->dropUnique(['loan_code']);
                    });
                } catch (\Throwable $e) {
                    // Ignore if unique index does not exist
                }
                DB::statement("ALTER TABLE `book_loans` MODIFY `loan_code` VARCHAR(50) NULL");
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('book_loans') && Schema::hasColumn('book_loans', 'loan_code')) {
            if (DB::getDriverName() === 'mysql') {
                DB::statement("ALTER TABLE `book_loans` MODIFY `loan_code` VARCHAR(50) NOT NULL");
            }
        }
    }
};
