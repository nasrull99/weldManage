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
            $table->string('customer_name'); // Column for customer name
            $table->string('material'); // Column for material name
            $table->decimal('price', 10, 2); // Column for price
            $table->integer('quantity'); // Column for quantity
            $table->decimal('amount', 10, 2); // Column for amount
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotations');
    }
}
