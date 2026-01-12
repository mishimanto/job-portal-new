<?php

namespace App\Notifications;

use App\Models\JobApplication;
use App\Models\SiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class ApplicationStatusUpdated extends Notification
{
    public $application;
    public $interviewTime;
    public $joiningDate;
    public $siteSettings;

    public function __construct(JobApplication $application, $interviewTime = null, $joiningDate = null)
    {
        $this->application = $application;
        $this->interviewTime = $interviewTime;
        $this->joiningDate = $joiningDate;
        $this->siteSettings = SiteSetting::all();
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $jobTitle   = $this->application->job->title;
        $company    = $this->application->job->company_name ?? 'HR Team';
        $candidate  = $this->application->user->name;
        $location   = $this->siteSettings->where('key', 'contact_address')->first()->value ?? 'Our Office';
        $phone     = $this->siteSettings->where('key', 'contact_phone')->first()->value ?? 'N/A';

        $mail = (new MailMessage)
            ->greeting("Dear {$candidate},");

        if ($this->application->isShortlisted()) {

            $mail->subject("Congratulations! You've been shortlisted for {$jobTitle}")
                ->line("Thank you for your interest in the **{$jobTitle}** position.")
                ->line("We are pleased to inform you that your application has been **shortlisted**.");

            if ($this->interviewTime) {
                // Format interview time to readable format
                try {
                    $interviewDate = Carbon::parse($this->interviewTime);
                    $formattedDate = $interviewDate->format('l, F j, Y');
                    $formattedTime = $interviewDate->format('g:i A');
                    
                    $mail->line("## 📅 Interview Details")
                        ->line("**Date:** {$formattedDate}")
                        ->line("**Time:** {$formattedTime}")
                        ->line("")
                        ->line("📍 **Location:** {$location}")
                        ->line("📞 **Call:** {$phone}")
                        ->line("")
                        ->line("**Please bring:**")
                        ->line("- Printed copy of your resume")
                        ->line("- Original and photocopy of academic certificates")
                        ->line("- NID/Passport copy")
                        ->line("- 2 recent passport size photographs");
                        
                } catch (\Exception $e) {
                    // Fallback if parsing fails
                    $mail->line("**Interview Date & Time:** {$this->interviewTime}");
                }
            } else {
                $mail->line("Our recruitment team will contact you shortly with the next steps in the interview process.");
            }

            $mail->line("")
                ->line("If you have any questions, contact our HR department.");

        } elseif ($this->application->isHired()) {

            $mail->subject("🎉 Offer Letter: {$jobTitle} at {$company}")
                ->line("We are delighted to inform you that you have been **selected** for the **{$jobTitle}** position at **{$company}**.")
                ->line("")
                ->line("Welcome to the team! We are excited to have you on board.");

            if ($this->joiningDate) {
                // Format joining date to readable format
                try {
                    $joiningDate = Carbon::parse($this->joiningDate);
                    $formattedDate = $joiningDate->format('l, F j, Y');
                    
                    $mail->line("## 📋 Joining Information")
                        ->line("**Joining Date:** {$formattedDate}")
                        ->line("**Reporting Time:** 9:00 AM")
                        ->line("**Department:** Will be assigned on first day")
                        ->line("")
                        ->line("## 📝 Required Documents")
                        ->line("Please bring the following documents on your joining day:")
                        ->line("1. All original academic certificates")
                        ->line("2. Photocopies of all certificates (attested)")
                        ->line("3. NID/Passport (original + 2 photocopies)")
                        ->line("4. 4 recent passport size photographs")
                        ->line("5. Experience certificates (if any)")
                        ->line("6. Bank account details for salary processing");
                        
                } catch (\Exception $e) {
                    // Fallback if parsing fails
                    $mail->line("**Joining Date:** {$this->joiningDate}");
                }
            } else {
                $mail->line("Our HR team will reach out to you shortly with your joining details and documentation.");
            }

            $mail->line("")
                ->line("Further onboarding details will be shared prior to your start date.")
                ->line("")
                ->line("We look forward to a successful journey together.");
        }

        $mail->salutation("Best regards,\n**{$company} HR Team**");

        return $mail;
    }
}