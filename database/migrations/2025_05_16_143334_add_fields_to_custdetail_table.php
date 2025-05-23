<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('custdetail', function (Blueprint $table) {
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custdetail', function (Blueprint $table) {
            $table->dropColumn(['date', 'time', 'description', 'image']);
        });
    }
};
