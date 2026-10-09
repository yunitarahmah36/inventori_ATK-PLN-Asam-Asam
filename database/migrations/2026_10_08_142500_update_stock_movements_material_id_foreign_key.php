<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            // Tambahkan kolom snapshot material_name dan material_number jika belum ada
            if (!Schema::hasColumn('stock_movements', 'material_name')) {
                $table->string('material_name', 255)->nullable()->after('material_id');
            }
            if (!Schema::hasColumn('stock_movements', 'material_number')) {
                $table->string('material_number', 50)->nullable()->after('material_name');
            }
        });

        // Isi data (backfill) material_name dan material_number dari tabel materials
        if (DB::getDriverName() === 'mysql') {
            DB::statement("
                UPDATE stock_movements sm
                JOIN materials m ON sm.material_id = m.id
                SET sm.material_name = m.name,
                    sm.material_number = m.material_number
                WHERE sm.material_id IS NOT NULL
            ");
        } else {
            DB::table('stock_movements')
                ->join('materials', 'stock_movements.material_id', '=', 'materials.id')
                ->whereNotNull('stock_movements.material_id')
                ->select('stock_movements.id', 'materials.name', 'materials.material_number')
                ->get()
                ->each(function ($row) {
                    DB::table('stock_movements')
                        ->where('id', $row->id)
                        ->update([
                            'material_name'   => $row->name,
                            'material_number' => $row->material_number,
                        ]);
                });
        }

        // Ubah foreign key constraint dari cascadeOnDelete menjadi nullOnDelete
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->dropForeign(['material_id']);
        });

        Schema::table('stock_movements', function (Blueprint $table) {
            $table->unsignedBigInteger('material_id')->nullable()->change();
            $table->foreign('material_id')
                ->references('id')
                ->on('materials')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->dropForeign(['material_id']);
        });

        Schema::table('stock_movements', function (Blueprint $table) {
            $table->unsignedBigInteger('material_id')->nullable(false)->change();
            $table->foreign('material_id')
                ->references('id')
                ->on('materials')
                ->cascadeOnDelete();

            $table->dropColumn(['material_name', 'material_number']);
        });
    }
};
