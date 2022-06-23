<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();

            $table->string('name');
            $table->string('company')->nullable();
            $table->text('comment')->nullable();
            $table->string('logo')->nullable();
            $table->smallInteger('active');
            $table->enum('coverage', ['Local', 'Nacional', 'Internacional']);

            $table->unsignedBigInteger('means_id');

            $table->foreign('means_id')
                ->references('id')
                ->on('means');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sources');
    }
}
