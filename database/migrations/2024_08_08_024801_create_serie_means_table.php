<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerieMeansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serie_means', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->timestamps();
            
            $table->unsignedBigInteger('serie_id')->nullable();
            $table->unsignedBigInteger('mean_id')->nullable();

            $table->foreign('serie_id')
                ->references('id')
                ->on('series')
                ->onDelete('cascade');
                
            $table->foreign('mean_id')
                ->references('id')
                ->on('means')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serie_means');
    }
}
