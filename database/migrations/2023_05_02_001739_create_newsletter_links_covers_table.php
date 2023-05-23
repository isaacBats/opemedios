<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterLinksCoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_links_covers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->comment('Name of the cover');
            $table->string('slug')
                ->unique()
                ->comment('Slug of the name');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletter_links_covers');
    }
}
