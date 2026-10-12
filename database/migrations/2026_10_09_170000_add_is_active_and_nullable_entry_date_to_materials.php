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
        if (Schema::hasTable('materials')) {
            Schema::table('materials', function (Blueprint $table) {
                if (!Schema::hasColumn('materials', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('unit');
                }
                if (Schema::hasColumn('materials', 'entry_date')) {
                    $table->date('entry_date')->nullable()->change();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('materials')) {
            Schema::table('materials', function (Blueprint $table) {
                if (Schema::hasColumn('materials', 'is_active')) {
                    $table->dropColumn('is_active');
                }
                if (Schema::hasColumn('materials', 'entry_date')) {
                    $table->date('entry_date')->nullable(false)->change();
                }
            });
        }
    }
};
