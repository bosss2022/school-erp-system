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
       Schema::create('guardian_communication_recipients', function (Blueprint $table) {

    $table->id();

    $table->unsignedBigInteger('guardian_communication_id');

    $table->unsignedBigInteger('guardian_id');

    $table->string('email');

    $table->enum('status', [
        'Pending',
        'Sent',
        'Failed'
    ])->default('Pending');

    $table->timestamp('sent_at')->nullable();

    $table->timestamps();

    $table->foreign('guardian_communication_id', 'gcr_comm_fk')
          ->references('id')
          ->on('guardian_communications')
          ->cascadeOnDelete();

    $table->foreign('guardian_id', 'gcr_guardian_fk')
          ->references('id')
          ->on('guardians')
          ->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardian_communication_recipients');
    }
};
