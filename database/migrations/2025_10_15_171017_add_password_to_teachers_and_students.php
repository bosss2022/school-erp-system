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
    Schema::table('teachers', function ($table) {
        $table->string('password')->nullable();
    });
    Schema::table('students', function ($table) {
        $table->string('password')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers_and_students', function (Blueprint $table) {
            //
        });
    }
};
