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
        Schema::create('book_loans', function (Blueprint $table) {
            $table->id();
            $table->string('loan_code', 50)->nullable();
            $table->foreignId('book_id')
                ->constrained('books')
                ->cascadeOnDelete();
            $table->string('borrower_name');
            $table->string('borrower_department')->nullable();
            $table->string('borrower_phone', 50)->nullable();
            $table->date('loan_date');
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('status', 30)->default('Dipinjam'); // Dipinjam, Dikembalikan, Terlambat
            $table->text('notes')->nullable();
            $table->foreignId('handled_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_loans');
    }
};
