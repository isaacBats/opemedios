<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnForNewslettersSendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('newsletter_themes_news', function (Blueprint $table) {
            $table->unsignedBigInteger('newsletter_send_id');
            $table->foreign('newsletter_send_id')->references('id')->on('newsletters_send');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('newsletter_themes_news', function (Blueprint $table) {
            $table->dropForeing('newsletter_themes_news_newsletter_send_id_foreing');
            $table->dropColumn('newsletter_send_id');
        });
    }
}
