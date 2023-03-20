<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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

        ini_set("memory_limit", "500M");
        @ini_set("post_max_size", "450M");
        ini_set("upload_max_filesize", "350M");
        ini_set("max_execution_time", "1000");

        Paginator::useBootstrap();

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
