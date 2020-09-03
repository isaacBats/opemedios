<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewslettersSendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletters_send', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('newsletter_id');
            $table->smallInteger('status');
            $table->text('news_ids')->nullable();
            $table->smallInteger('num_notes')->nullable();
            $table->smallInteger('num_email')->nullable();

            $table->foreign('newsletter_id')
                ->references('id')->on('newsletters')
                ->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletters_send');
    }
}
