<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsUserIdAndScopeWithMayorValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // drop column scope
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('scope');
        });

        // add columns scope and user_id
        Schema::table('news', function (Blueprint $table) {
            
            $table->unsignedInteger('scope')->nullable();
            $table->unsignedInteger('user_id')->default(1);

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('scope');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropForeign('news_user_id_foreign');
            $table->dropColumn('user_id');
            $table->smallInteger('scope')->nullable();
        });
    }
}
