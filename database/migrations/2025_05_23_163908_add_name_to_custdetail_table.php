<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('custdetail', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->string('name')->after('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('custdetail', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->dropColumn('name');
        });
    }
};
