<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use App\Models\ContactMessage;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\Job;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
{
    // Site logo
    try {
        $siteLogo = DB::table('site_settings')
            ->where('key', 'site_logo')
            ->value('value');

        View::share('siteLogo', $siteLogo);
    } catch (\Throwable $e) {
        // table not exists yet
    }

    // Admin Layout - Unread Messages and Notifications
    View::composer('layouts.admin', function ($view) {
        if (auth()->check() && auth()->user()->role === 'admin') {

            $unreadMessagesCount = 0;
            $notificationCount = 0;
            $notifications = collect();

            try {
                $unreadMessagesCount = ContactMessage::unread()->count();
            } catch (\Throwable $e) {}

            try {
                $user = auth()->user();
                $notificationCount = $user->unreadNotifications()->count();
                $notifications = $user->notifications()
                    ->latest()
                    ->take(10)
                    ->get();
            } catch (\Throwable $e) {}

            $view->with(compact(
                'unreadMessagesCount',
                'notifications',
                'notificationCount'
            ));
        }
    });

    // Blade directive
    Blade::directive('removeFilter', function ($expression) {
        return "<?php echo \\App\\Helpers\\FilterHelper::removeFilter($expression); ?>";
    });

    // Footer info
    try {
        $siteSettings = SiteSetting::pluck('value', 'key')->toArray();
        View::share('siteSettings', $siteSettings);
    } catch (\Throwable $e) {}

    // Footer stats
    try {
        View::share('totalJobs',
            Job::where('is_active', 1)
                ->where('status', 'approved')
                ->count()
        );

        View::share('totalCompanies',
            Company::where('is_active', 1)->count()
        );

        View::share('totalApplicants',
            JobApplication::distinct('user_id')->count()
        );
    } catch (\Throwable $e) {}
}

}