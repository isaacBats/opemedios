<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnForDateSendOnNewslettersSendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('newsletters_send', function (Blueprint $table) {
            $table->date('date_sending')
            //->default(\DB::raw('CURRENT_DATE'))
            ->useCurrent()
            ->description('Date of sending a newsletter');
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
            $table->dropColumn('date_sending');
        });
    }
}
