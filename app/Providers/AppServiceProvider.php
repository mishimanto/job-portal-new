<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $siteLogo = DB::table('site_settings')
        ->where('key', 'site_logo')
        ->value('value');

        view()->share('siteLogo', $siteLogo);
    }
}
