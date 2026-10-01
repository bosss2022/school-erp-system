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
       Schema::create('meetings', function (Blueprint $table) {

    $table->id();

    $table->string('title');

    $table->date('meeting_date');

    $table->time('meeting_time');

    $table->string('venue');

    $table->enum('target_type', [
        'all',
        'class',
        'individual'
    ]);

    $table->foreignId('classroom_id')
          ->nullable()
          ->constrained()
          ->nullOnDelete();

    $table->text('agenda')->nullable();

    $table->foreignId('created_by')
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
        Schema::dropIfExists('meetings');
    }
};
