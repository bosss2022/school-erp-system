<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('exams', function (Blueprint $table) {

        $table->foreignId('academic_year_id')
              ->nullable()
              ->after('id');

    });

    Schema::table('exams', function (Blueprint $table) {

        $table->foreign('academic_year_id')
              ->references('id')
              ->on('academic_years')
              ->cascadeOnDelete();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            //
        });
    }
};
