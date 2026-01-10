<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('shimanto'),
            'role' => 'admin',
            'phone' => '+1234567890',
            'address' => '123 Admin Street, City',
        ]);

        // Create job seeker users
        $jobSeekers = User::factory()->count(10)->create([
            'role' => 'job_seeker',
        ]);

        // Create jobs
        $jobs = Job::factory()->count(50)->create([
            'user_id' => $admin->id,
            'status' => 'approved',
        ]);

        // Create some pending jobs
        Job::factory()->count(5)->create([
            'user_id' => $admin->id,
            'status' => 'pending',
        ]);

        // Create applications
        // foreach ($jobSeekers as $seeker) {
        //     foreach ($jobs->random(rand(1, 5)) as $job) {
        //         JobApplication::factory()->create([
        //             'job_id' => $job->id,
        //             'user_id' => $seeker->id,
        //         ]);
        //     }
        // }

        // Create site settings
        SiteSetting::create(['key' => 'site_name', 'value' => 'Job Portal']);
        SiteSetting::create(['key' => 'contact_email', 'value' => 'contact@jobportal.com']);
        SiteSetting::create(['key' => 'contact_phone', 'value' => '019XXXXXXXX']);
        SiteSetting::create(['key' => 'contact_address', 'value' => 'XYZ, City, Country']);
        SiteSetting::create(['key' => 'about_us', 'value' => 'We are a leading job portal connecting talented professionals with great opportunities.']);
    }
}