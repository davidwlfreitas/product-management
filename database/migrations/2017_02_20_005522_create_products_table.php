<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table){
            $table->increments('id');
            $table->string('category');
            $table->bigInteger('lm')->unique();
            $table->string('name', 100);
            $table->char('free_shipping', 1);
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->timestampsTz();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("products");
    }
}
