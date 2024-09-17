<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookMeansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_means', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->timestamps();
            
            $table->unsignedBigInteger('book_id')->nullable();
            $table->unsignedBigInteger('mean_id')->nullable();

            $table->foreign('book_id')
                ->references('id')
                ->on('books')
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
        Schema::dropIfExists('book_means');
    }
}
