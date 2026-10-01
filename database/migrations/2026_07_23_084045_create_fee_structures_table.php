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
        Schema::create('fee_structures', function (Blueprint $table) {

            $table->id();

            $table->foreignId('classroom_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('academic_year_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->enum('term', [
                'Term 1',
                'Term 2',
                'Term 3'
            ]);

            $table->decimal('amount', 10, 2);

            $table->timestamps();

            // Prevent duplicate fee structures
            $table->unique([
                'classroom_id',
                'academic_year_id',
                'term'
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};