<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThemeMeansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theme_means', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            
            $table->unsignedBigInteger('theme_id')->nullable();
            $table->unsignedBigInteger('mean_id')->nullable();

            $table->foreign('theme_id')
                ->references('id')
                ->on('themes')
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
        Schema::table('theme_means', function (Blueprint $table) {
            Schema::dropIfExists('theme_means');
        });
    }
}
