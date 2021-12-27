<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autos', function (Blueprint $table) {
            $table->id();
            $table->string('owner_name');
            $table->string('state_number');
            $table->string('color');
            $table->string('vin_code');
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->timestamps();
        });
        Schema::table('autos', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();  
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autos');
    }
}
