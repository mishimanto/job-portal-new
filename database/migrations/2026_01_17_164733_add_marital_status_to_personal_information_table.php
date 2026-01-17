<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('personal_information', function (Blueprint $table) {
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed', 'separated', 'other'])
                  ->nullable()
                  ->after('gender');
        });
    }

    public function down()
    {
        Schema::table('personal_information', function (Blueprint $table) {
            $table->dropColumn('marital_status');
        });
    }
};