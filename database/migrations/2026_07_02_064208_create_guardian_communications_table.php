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
        Schema::create('guardian_communications', function (Blueprint $table) {

    $table->id();

    $table->string('title');

    $table->string('subject');

    $table->longText('message');

    $table->enum('type',[
        'announcement',
        'memo',
        'newsletter',
        'alert',
        'individual'
    ]);

    $table->enum('recipient_type',[
        'all',
        'class',
        'selected',
        'individual'
    ]);

    $table->foreignId('classroom_id')->nullable()->constrained();

    $table->foreignId('created_by')->constrained('users');

    $table->timestamp('sent_at')->nullable();

    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardian_communications');
    }
};
