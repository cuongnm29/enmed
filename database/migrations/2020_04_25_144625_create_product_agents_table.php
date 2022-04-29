<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_agents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('countriesid');
            $table->integer('citiesid');
            $table->integer('districtid');
            $table->string('name');
            $table->string('summary');
            $table->string('content');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_agents');
    }
}
