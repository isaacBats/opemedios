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
        Schema::table('assigned_news', function (Blueprint $table) {
            // Se recomienda un índice compuesto que agrupe los principales filtros.
            // La combinación de COMPANY_ID y NEWS_ID es clave para la consulta inicial.
            $table->index(['company_id', 'news_id', 'theme_id'], 'assigned_news_composite_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assigned_news', function (Blueprint $table) {
            $table->dropIndex('assigned_news_composite_index');
        });
    }
};
