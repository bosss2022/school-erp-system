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
    Schema::create('student_payments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('student_id');
        $table->decimal('amount_paid', 10, 2);
        $table->decimal('total_fee', 10, 2);
        $table->decimal('balance', 10, 2);
        $table->string('term')->nullable(); // e.g. Term 1, Term 2
        $table->date('payment_date');
        $table->unsignedBigInteger('recorded_by')->nullable();
        $table->timestamps();

        $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        $table->foreign('recorded_by')->references('id')->on('users')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_payments');
    }
};
