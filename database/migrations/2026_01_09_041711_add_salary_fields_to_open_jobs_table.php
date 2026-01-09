<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('open_jobs', function (Blueprint $table) {
            // Change salary column from decimal to string
            $table->string('salary')->nullable()->change();
            
            // Add new salary fields
            $table->decimal('salary_min', 10, 2)->nullable()->after('salary');
            $table->decimal('salary_max', 10, 2)->nullable()->after('salary_min');
            $table->string('salary_type')->nullable()->after('salary_max'); // fixed, range, negotiable
            $table->string('salary_currency')->default('USD')->after('salary_type');
        });
    }

    public function down(): void
    {
        Schema::table('open_jobs', function (Blueprint $table) {
            // Revert salary column
            $table->decimal('salary', 10, 2)->nullable()->change();
            
            // Remove new fields
            $table->dropColumn(['salary_min', 'salary_max', 'salary_type', 'salary_currency']);
        });
    }
};