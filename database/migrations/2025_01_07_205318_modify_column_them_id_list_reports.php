<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('list_reports', function (Blueprint $table) {
            $table->dropForeign(['theme_id']);
        });
        Schema::table('list_reports', function (Blueprint $table) {
            $table->string('theme_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('list_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('theme_id')->nullable();
        });
    }
};
