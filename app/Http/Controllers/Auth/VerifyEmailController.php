<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Redirect based on user role if already verified
            return $this->redirectBasedOnRole($request);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Redirect based on user role after verification
        return $this->redirectBasedOnRole($request, true);
    }

    /**
     * Redirect user based on their role
     */
    private function redirectBasedOnRole($request, $verified = false): RedirectResponse
    {
        $user = $request->user();
        
        // Check user role and redirect accordingly
        if ($user->role === 'admin') {
            $route = 'admin.dashboard';
        } elseif ($user->role === 'job_seeker') {
            $route = 'job-seeker.dashboard';
        } else {
            $route = 'home'; // fallback
        }

        // Add verified parameter if needed
        $url = route($route);
        if ($verified) {
            $url .= '?verified=1';
        }

        return redirect()->intended($url);
    }
}