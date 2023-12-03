<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garages', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->string('name');
            $table->integer('numFloors');
            $table->string('location');
            $table->string('lat');
            $table->string('longt');
            $table->double('rate');
            $table->string('img');
            $table->string('desc');
            $table->decimal('price');
            $table->integer("numSpaces");
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
        Schema::dropIfExists('garages');
    }
};
