<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('customer_id')->index();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->uuid('company_id')->index();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();

            $table->primary('id');
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('order_id')->index();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->uuid('product_id')->index();
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('amount');
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('orders');
    }
}
