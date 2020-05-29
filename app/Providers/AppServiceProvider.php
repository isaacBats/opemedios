<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        // Carbon::setUTF8(true);
        // setlocale(LC_TIME, 'es_ES');
        setlocale(LC_TIME, 'es_MX.utf8');
        setlocale(LC_MONETARY, 'es_MX.utf8');

        ini_set("memory_limit", "150M");
        @ini_set("post_max_size", "100M");
        ini_set("upload_max_filesize", "100M");
        ini_set("max_execution_time", "350");

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
