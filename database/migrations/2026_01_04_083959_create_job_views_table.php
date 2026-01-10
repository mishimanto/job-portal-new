<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('open_jobs')->onDelete('cascade');
            $table->string('ip_address');
            $table->timestamp('viewed_at')->useCurrent();
            
            // Optional: Add index for better performance
            $table->index(['job_id', 'ip_address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_views');
    }
};