<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Personal Information Table
        Schema::create('personal_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
        });

        // Education Table
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('institution');
            $table->string('degree');
            $table->string('field_of_study')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->text('description')->nullable();
            $table->string('grade')->nullable();
            $table->json('activities')->nullable();
            $table->timestamps();
        });

        // Skills Table
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('level')->nullable(); // beginner, intermediate, advanced, expert
            $table->integer('years_of_experience')->nullable();
            $table->string('category')->nullable(); // technical, soft, language, etc.
            $table->timestamps();
        });

        // Experience Table
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('job_title');
            $table->string('company_name');
            $table->string('employment_type')->nullable(); // full-time, part-time, contract, etc.
            $table->string('location')->nullable();
            $table->boolean('is_current')->default(false);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->json('responsibilities')->nullable();
            $table->string('industry')->nullable();
            $table->timestamps();
        });

        // Projects Table
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('role')->nullable();
            $table->json('technologies_used')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_ongoing')->default(false);
            $table->string('project_url')->nullable();
            $table->json('images')->nullable();
            $table->timestamps();
        });

        // Certifications Table
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('issuing_organization');
            $table->date('issue_date');
            $table->date('expiration_date')->nullable();
            $table->string('credential_id')->nullable();
            $table->string('credential_url')->nullable();
            $table->json('skills')->nullable();
            $table->timestamps();
        });

        // Social Links Table
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('platform'); // linkedin, github, twitter, etc.
            $table->string('url');
            $table->string('username')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });

        // Profile Visibility Settings
        Schema::create('profile_visibility_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('make_profile_public')->default(true);
            $table->boolean('show_education')->default(true);
            $table->boolean('show_experience')->default(true);
            $table->boolean('show_projects')->default(true);
            $table->boolean('show_certifications')->default(true);
            $table->boolean('show_skills')->default(true);
            $table->boolean('show_social_links')->default(true);
            $table->boolean('show_contact_info')->default(false);
            $table->timestamps();
        });

        // Profile Views Statistics
        Schema::create('profile_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->foreignId('viewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('viewed_at')->useCurrent();
            $table->timestamps();
        });

        // Update existing job_seeker_profiles table to reference personal_information
        Schema::table('job_seeker_profiles', function (Blueprint $table) {
            $table->foreignId('personal_info_id')->nullable()->constrained('personal_information')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('job_seeker_profiles', function (Blueprint $table) {
            $table->dropForeign(['personal_info_id']);
            $table->dropColumn('personal_info_id');
        });

        Schema::dropIfExists('profile_views');
        Schema::dropIfExists('profile_visibility_settings');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('certifications');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('educations');
        Schema::dropIfExists('personal_information');
    }
};