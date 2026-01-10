// database/migrations/2024_01_01_000002_create_job_seeker_profiles_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_seeker_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('summary')->nullable();
            $table->json('skills')->nullable();
            $table->string('experience_level')->nullable();
            $table->string('education')->nullable();
            $table->string('resume_file')->nullable();
            $table->json('work_experience')->nullable();
            $table->json('education_history')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_seeker_profiles');
    }
};