<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2020
  * @version 1.0.0
  * @package App\
  * Type: Migrate
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesNewsAndNewsletterThemesNewsAndAddColumnsNewsidMainfileInFilesTableAndAddColumnStatusInNewslettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Table for news
        Schema::create('news', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();

            $table->string('title');
            $table->text('synthesis');
            $table->string('author')->default('Anónimo');
            $table->unsignedBigInteger('author_type_id')->default(6);
            $table->unsignedBigInteger('sector_id');
            $table->unsignedBigInteger('genre_id');
            $table->unsignedBigInteger('source_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('mean_id');
            $table->timestamp('news_date')->nullable();
            $table->float('cost', 8, 2);
            $table->smallInteger('trend')->defaulr(2);
            $table->smallInteger('scope')->nullable();
            $table->text('comments')->nullable();
            $table->smallInteger('in_newsletter')->default(0);
            $table->text('metas_news');

            $table->foreign('author_type_id')->references('id')->on('author_types');
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->foreign('genre_id')->references('id')->on('genres');
            $table->foreign('source_id')->references('id')->on('sources');
            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('mean_id')->references('id')->on('means');
        });

        // Table newsletter_themes_news
        Schema::create('newsletter_themes_news', function (BluePrint $table){
            $table->bigIncrements('id');
            $table->timestamps();

            $table->unsignedBigInteger('newsletter_id');
            $table->unsignedBigInteger('newsletter_theme_id');  // the theme id of the company for which the newsletter belongs
            $table->unsignedBigInteger('news_id');

            $table->foreign('newsletter_id')->references('id')->on('newsletters');
            $table->foreign('newsletter_theme_id')->references('id')->on('themes');
            $table->foreign('news_id')->references('id')->on('news');

        });

        // add columns in files table
        Schema::table('files', function (Blueprint $table) {
            $table->unsignedBigInteger('news_id')->nullable();
            $table->smallInteger('main_file')->nullable();
            $table->smallInteger('file_from_news')->nullable();

            $table->foreign('news_id')->references('id')->on('news');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Rollback columns in files table
        Schema::table('files', function (Blueprint $table) {
            $table->dropForeing('files_news_id_foreing');
            $table->dropColumn(['news_id', 'main_file', 'file_from_news']);
        });

        // drop table newsletter_themes_news
        Schema::dropIfExist('newsletter_themes_news');

        // drop table news
        Schema::dropIfExists('news');
    }
}
