<?php

use Illuminate\Support\Facades\Schema;
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
        Schema::create('product_types', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();

            $table->primary('id');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('sku')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->uuid('type_id')->index();
            $table->foreign('type_id')->references('id')->on('product_types');
            $table->uuid('company_id')->index();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->integer('stock');
            $table->integer('cost');
            $table->integer('selling_price');
            $table->softDeletes();
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_types');
    }
}
