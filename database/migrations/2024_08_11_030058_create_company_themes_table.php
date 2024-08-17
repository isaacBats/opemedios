<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
    
        Schema::create('companies_themes', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->timestamps();
            
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('theme_id')->nullable();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
                
            $table->foreign('theme_id')
                ->references('id')
                ->on('themes')
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
        Schema::dropIfExists('companies_themes');
    }
}
