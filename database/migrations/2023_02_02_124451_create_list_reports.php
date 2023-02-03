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
            $table->timestamp('start_date')->useCurrent();
            $table->timestamp('end_date')->useCurrent();
            $table->unsignedBigInteger('company')->nullable();
            $table->unsignedBigInteger('theme_id')->nullable();
            $table->string('sector', 150)->nullable();
            $table->string('genre', 150)->nullable();
            $table->string('mean', 150)->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('word', 150)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('status')->default(0);

            $table->foreign('company')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');

            $table->foreign('theme_id')
                ->references('id')
                ->on('themes')
                ->onDelete('cascade');

            $table->foreign('source_id')
                ->references('id')
                ->on('sources')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('list_reports');
    }
}
