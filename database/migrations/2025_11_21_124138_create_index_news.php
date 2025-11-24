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
        Schema::table('news', function (Blueprint $table) {
            // 1. Índice CRÍTICO para el filtro de fechas en los reportes
            $table->index('created_at');
            
            // 2. Índice para la agrupación por tendencia (trend)
            $table->index('trend');

            // 3. Índice para la agrupación por medio (mean_id)
            $table->index('mean_id');

            // 4. Índice para el uso de Soft Deletes
            $table->index('deleted_at');
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
            $table->dropIndex(['created_at']);
            $table->dropIndex(['trend']);
            $table->dropIndex(['mean_id']);
            $table->dropIndex(['deleted_at']);
        });
    }
};
