<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('name_file', 150);
            $table->string('start_date', 150)->nullable();
            $table->string('end_date', 150)->nullable();
            $table->string('company', 150)->nullable();
            $table->string('theme_id', 150)->nullable();
            $table->string('sector', 150)->nullable();
            $table->string('genre', 150)->nullable();
            $table->string('mean', 150)->nullable();
            $table->string('source_id', 150)->nullable();
            $table->string('word', 150)->nullable();
            $table->integer('user_id');
            $table->tinyInteger('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_reports');
    }
}
