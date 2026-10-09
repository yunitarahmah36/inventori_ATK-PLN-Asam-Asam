<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('stock_movements') && !Schema::hasColumn('stock_movements', 'recipient')) {
            Schema::table('stock_movements', function (Blueprint $table) {
                $table->string('recipient')->nullable()->after('quantity_change');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('stock_movements') && Schema::hasColumn('stock_movements', 'recipient')) {
            Schema::table('stock_movements', function (Blueprint $table) {
                $table->dropColumn('recipient');
            });
        }
    }
};
