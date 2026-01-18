<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // Check if user is verified
        if ($request->user()->hasVerifiedEmail()) {
            // Redirect based on user role
            if ($request->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                // Default to job seeker dashboard
                return redirect()->route('job-seeker.dashboard');
            }
        }

        return view('auth.verify-email');
    }
}