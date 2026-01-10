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
        });
    }

    public function down(): void
    {
        Schema::table('open_jobs', function (Blueprint $table) {
            // Revert back to decimal if needed
            $table->decimal('salary', 10, 2)->nullable()->change();
        });
    }
};