<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFestivalMeansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('festival_means', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->timestamps();
            
            $table->unsignedBigInteger('festival_id')->nullable();
            $table->unsignedBigInteger('mean_id')->nullable();

            $table->foreign('festival_id')
                ->references('id')
                ->on('festivals')
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
        Schema::dropIfExists('festival_means');
    }
}
