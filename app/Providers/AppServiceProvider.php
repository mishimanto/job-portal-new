<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Schema;



class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (Schema::hasTable('site_settings')) {
            $siteLogo = DB::table('site_settings')
                ->where('key', 'site_logo')
                ->value('value');

            view()->share('siteLogo', $siteLogo);
        }

        View::composer('layouts.admin', function ($view) {
            if (auth()->check() && auth()->user()->role === 'admin') {
                $unreadMessagesCount = ContactMessage::unread()->count();
                $view->with('unreadMessagesCount', $unreadMessagesCount);
            }
        });

        // Register blade directives
        Blade::directive('removeFilter', function ($expression) {
            return "<?php echo \App\Helpers\FilterHelper::removeFilter($expression); ?>";
        });
    }
}
