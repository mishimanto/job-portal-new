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
        Schema::create('application_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_application_id')->constrained()->onDelete('cascade');
            $table->foreignId('sent_by')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['status_update', 'custom_message', 'interview_schedule', 'offer_letter', 'other']);
            $table->string('subject');
            $table->text('message');
            $table->json('metadata')->nullable(); 
            $table->timestamp('sent_at');
            $table->timestamps();
            
            $table->index('job_application_id');
            $table->index('sent_by');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_emails');
    }
};