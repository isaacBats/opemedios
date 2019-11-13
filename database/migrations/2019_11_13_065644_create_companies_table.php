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
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('name');
            $table->string('address');
            $table->softDeletes();
        });

        Schema::create('sectors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('name');
            $table->string('description');
        });

        Schema::create('company_has_users', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->unsignedBigInteger('company_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('company_id')
                ->references('id')
                ->on('companies');

            $table->primary(['user_id', 'company_id'], 'company_has_users_user_id_company_id_primary');
        });

        Schema::create('company_has_sectors', function (Blueprint $table) {
            $table->unsignedBigInteger('sector_id');
            $table->unsignedBigInteger('company_id');

            $table->foreign('sector_id')
                ->references('id')
                ->on('sectors')
                ->onDelete('cascade');

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');

            $table->primary(['sector_id', 'company_id'], 'company_has_sectors_sector_id_company_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
        Schema::dropIfExists('sectors');
        Schema::dropIfExists('company_has_users');
        Schema::dropIfExists('company_has_sectors');
    }
}
