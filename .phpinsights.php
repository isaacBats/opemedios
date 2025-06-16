<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Preset
    |--------------------------------------------------------------------------
    |
    | Puedes usar:
    | - default
    | - laravel
    | - symfony
    | - lumi
    |
    */
    'preset' => 'laravel',

    /*
    |--------------------------------------------------------------------------
    | Excluir rutas
    |--------------------------------------------------------------------------
    */
    'exclude' => [
        'storage',
        'vendor',
        'node_modules',
        'tests/fixtures',
    ],

    /*
    |--------------------------------------------------------------------------
    | Remover insights específicos
    |--------------------------------------------------------------------------
    */
    'remove' => [
        // Complejidad ciclomática
        NunoMaduro\PhpInsights\Domain\Insights\CyclomaticComplexityIsHigh::class,
        // Métodos con demasiadas líneas
        NunoMaduro\PhpInsights\Domain\Insights\Files\TooManyPublicMethods::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Ajustes personalizados
    |--------------------------------------------------------------------------
    */
    'config' => [
        'maxLineLength'   => 120,
        'minQuality'      => 80,
        'minComplexity'   => 10,
        'minArchitecture' => 75,
        'minStyle'        => 80,
    ],

];
