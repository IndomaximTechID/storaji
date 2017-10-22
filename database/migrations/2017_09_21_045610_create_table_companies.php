<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_types', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();

            $table->primary('id');
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->uuid('type_id')->index();
            $table->foreign('type_id')->references('id')->on('company_types');
            $table->uuid('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('companies');
        Schema::dropIfExists('company_types');
    }
}
