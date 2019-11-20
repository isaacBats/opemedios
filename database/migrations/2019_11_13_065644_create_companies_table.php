<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();

            $table->string('name');
            $table->text('description')->nullable();
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();

            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('address')->nullable();
            $table->text('logo')->nullable();
            $table->unsignedBigInteger('turn_id');

            $table->foreign('turn_id')
                ->references('id')
                ->on('turns')
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
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('companies_turn_id_foreign');
        });
        Schema::dropIfExists('turns');
        Schema::dropIfExists('companies');
    }
}
