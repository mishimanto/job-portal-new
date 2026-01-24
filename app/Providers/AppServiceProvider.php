<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

    // Blade directive for profile picture
    Blade::directive('profilePicture', function ($expression) {
        return "<?php echo \\App\\Providers\\AppServiceProvider::getProfilePictureHtml($expression); ?>";
    });

    // Blade directive for removeFilter
    Blade::directive('removeFilter', function ($expression) {
        return "<?php echo \\App\\Helpers\\FilterHelper::removeFilter($expression); ?>";
    });

    // Share profile picture helper with all views
    View::share('profilePictureHelper', new class {
        public function get($user, $size = 8, $name = null)
        {
            return AppServiceProvider::getProfilePictureHtml($user, $size, $name);
        }
        
        public function forMessage($message, $size = 8)
        {
            return AppServiceProvider::getMessageProfilePictureHtml($message, $size);
        }
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

    /**
     * Get profile picture HTML
     */
    public static function getProfilePictureHtml($user, $size = 8, $name = null)
    {
        $name = $name ?? ($user->name ?? '');
        $initial = $name ? strtoupper(substr($name, 0, 1)) : '?';
        
        if ($user && !empty($user->profile_photo)) {
            $photoUrl = Storage::url($user->profile_photo);
            return <<<HTML
                <img class="h-{$size} w-{$size} rounded-full object-cover border border-gray-200" 
                     src="{$photoUrl}" 
                     alt="{$name}"
                     onerror="this.onerror=null; this.src=''; this.outerHTML='<div class=\'h-{$size} w-{$size} bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center border border-gray-200\'><span class=\'text-white font-semibold text-sm\'>{$initial}</span></div>'">
            HTML;
        }
        
        return <<<HTML
            <div class="h-{$size} w-{$size} bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center border border-gray-200">
                <span class="text-white font-semibold text-sm">
                    {$initial}
                </span>
            </div>
        HTML;
    }

    /**
     * Get profile picture for message (without user relation)
     */
    public static function getMessageProfilePictureHtml($message, $size = 8)
    {
        $name = $message->name ?? '';
        $initial = $name ? strtoupper(substr($name, 0, 1)) : '?';
        
        // Check if message has user relation
        if (isset($message->user) && $message->user && !empty($message->user->profile_photo)) {
            $photoUrl = Storage::url($message->user->profile_photo);
            return <<<HTML
                <img class="h-{$size} w-{$size} rounded-full object-cover border border-gray-200" 
                     src="{$photoUrl}" 
                     alt="{$name}"
                     onerror="this.onerror=null; this.src=''; this.outerHTML='<div class=\'h-{$size} w-{$size} bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center border border-gray-200\'><span class=\'text-white font-semibold text-sm\'>{$initial}</span></div>'">
            HTML;
        }
        
        // Fallback to initial
        return <<<HTML
            <div class="h-{$size} w-{$size} bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center border border-gray-200">
                <span class="text-white font-semibold text-sm">
                    {$initial}
                </span>
            </div>
        HTML;
    }
}