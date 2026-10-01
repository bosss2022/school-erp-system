<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_structure_documents', function (Blueprint $table) {

            $table->id();

            $table->foreignId('academic_year_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('file');

            $table->timestamps();

            $table->unique('academic_year_id');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_structure_documents');
    }
};