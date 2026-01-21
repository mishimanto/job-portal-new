<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomApplicationEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public $application;
    public $customMessage;
    public $interviewTime;
    public $joiningDate;
    public $subject;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        JobApplication $application, 
        string $customMessage, 
        $interviewTime = null, 
        $joiningDate = null,
        $subject = null
    ) {
        $this->application = $application;
        $this->customMessage = $customMessage;
        $this->interviewTime = $interviewTime;
        $this->joiningDate = $joiningDate;
        $this->subject = $subject ?? 'Update on Your Job Application';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject($this->subject)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->customMessage);
        
        // Add job details
        $mailMessage->line('**Job Details:**')
            ->line('Position: ' . $this->application->job->title)
            ->line('Company: ' . $this->application->job->company_name);
        
        // Add interview time if provided
        if ($this->interviewTime) {
            $mailMessage->line('**Interview Scheduled:**')
                ->line('Date & Time: ' . \Carbon\Carbon::parse($this->interviewTime)->format('F j, Y \a\t h:i A'));
        }
        
        // Add joining date if provided
        if ($this->joiningDate) {
            $mailMessage->line('**Joining Date:**')
                ->line('Date: ' . \Carbon\Carbon::parse($this->joiningDate)->format('F j, Y'));
        }
        
        // Add closing
        $mailMessage->line('Thank you for your application!')
            ->line('If you have any questions, feel free to reply to this email.')
            ->action('View Application Status', route('job-seeker.applications'))
            ->salutation('Best regards,<br>' . config('app.name') . ' Team');
        
        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'job_title' => $this->application->job->title,
            'custom_message' => $this->customMessage,
            'interview_time' => $this->interviewTime,
            'joining_date' => $this->joiningDate,
        ];
    }
}