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
        Schema::create('revision_materials', function (Blueprint $table) {

    $table->id();

    $table->string('title');

    $table->text('description')->nullable();

    $table->string('file');

    $table->foreignId('subject_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->foreignId('classroom_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->foreignId('teacher_id')
        ->nullable()
        ->constrained()
        ->nullOnDelete();

    $table->enum('type', [
        'notes',
        'assignment',
        'pastpaper',
        'marking_scheme',
    ]);

    $table->foreignId('uploaded_by')
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
        Schema::dropIfExists('revision_materials');
    }
};
