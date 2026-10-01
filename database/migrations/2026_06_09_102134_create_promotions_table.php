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
        Schema::create('promotions', function (Blueprint $table) {

    $table->id();

    $table->foreignId('student_id')->constrained()->onDelete('cascade');

    $table->foreignId('from_classroom_id')->constrained('classrooms');

    $table->foreignId('to_classroom_id')->constrained('classrooms');

    $table->string('academic_year');

    $table->date('promotion_date');

    $table->foreignId('promoted_by')->nullable()->constrained('users');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
