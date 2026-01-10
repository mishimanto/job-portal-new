<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('open_jobs', function (Blueprint $table) {
            // First check if column already exists
            if (!Schema::hasColumn('open_jobs', 'category_id')) {
                $table->foreignId('category_id')->nullable()
                      ->constrained('categories')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('open_jobs', function (Blueprint $table) {
            if (Schema::hasColumn('open_jobs', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
        });
    }
};