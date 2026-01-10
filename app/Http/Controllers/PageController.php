<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\SiteSetting;

class PageController extends Controller
{
    public function home()
    {
        $featuredJobs = Job::active()
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
            
        $recentJobs = Job::active()
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        
        return view('home', compact('featuredJobs', 'recentJobs'));
    }

    public function about()
    {
        $about = SiteSetting::getValue('about_us', '');
        return view('pages.about', compact('about'));
    }

    public function contact()
    {
        $contact = [
            'email' => SiteSetting::getValue('contact_email'),
            'phone' => SiteSetting::getValue('contact_phone'),
            'address' => SiteSetting::getValue('contact_address'),
        ];
        
        return view('pages.contact', compact('contact'));
    }
}