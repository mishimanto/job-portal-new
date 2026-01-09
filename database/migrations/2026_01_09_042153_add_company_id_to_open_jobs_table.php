<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('open_jobs', function (Blueprint $table) {
            // Add company_id column
            $table->foreignId('company_id')->nullable()->after('user_id')
                  ->constrained('companies')->onDelete('set null');
            
            // Keep company_name for backward compatibility
            // Optionally make company_name nullable since we'll get it from company table
            $table->string('company_name')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('open_jobs', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
            $table->string('company_name')->nullable(false)->change();
        });
    }
};