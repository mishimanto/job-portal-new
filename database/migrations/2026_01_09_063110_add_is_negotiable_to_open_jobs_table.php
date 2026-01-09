<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('open_jobs', function (Blueprint $table) {
            $table->boolean('is_negotiable')->default(false)->after('salary');
        });
    }

    public function down(): void
    {
        Schema::table('open_jobs', function (Blueprint $table) {
            $table->dropColumn('is_negotiable');
        });
    }
};