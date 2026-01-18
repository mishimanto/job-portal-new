<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
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

        // Footer info
        $siteSettings = SiteSetting::all()->pluck('value', 'key')->toArray();
        View::share('siteSettings', $siteSettings);

        // Footer stats
        $totalJobs = Job::where('is_active', 1)
                           ->where('status', 'approved')
                           ->count();
        
        $totalCompanies = Company::where('is_active', 1)->count();
        
        $totalApplicants = JobApplication::distinct('user_id')->count();
        
        View::share('totalJobs', $totalJobs);
        View::share('totalCompanies', $totalCompanies);
        View::share('totalApplicants', $totalApplicants);
    }
}
