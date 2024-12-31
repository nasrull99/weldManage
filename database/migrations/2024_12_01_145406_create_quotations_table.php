<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->decimal('totalamount', 10, 2);
            $table->timestamps();
        
            $table->foreign('customer_id')->references('id')->on('custdetail')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotations');
    }
}
