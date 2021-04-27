<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLabelOnNewslettersSendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('newsletters_send', function (Blueprint $table) {
            $table->string('label')->default('Default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('newsletters_send', function (Blueprint $table) {
            $table->dropColumn('label');
        });
    }
}
