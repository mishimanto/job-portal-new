<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendApplicationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $application;
    public $job;
    public $emailType;
    public $customMessage;
    public $subject;
    public $adminName;
    public $interviewTime;
    public $joiningDate;

    /**
     * Create a new job instance.
     */
    public function __construct(
        $user,
        $application,
        $job,
        $emailType, // 'status_update' or 'custom_message'
        $customMessage = null,
        $subject = null,
        $adminName = null,
        $interviewTime = null,
        $joiningDate = null
    ) {
        $this->user = $user;
        $this->application = $application;
        $this->job = $job;
        $this->emailType = $emailType;
        $this->customMessage = $customMessage;
        $this->subject = $subject;
        $this->adminName = $adminName;
        $this->interviewTime = $interviewTime;
        $this->joiningDate = $joiningDate;
        
        Log::info("🎯 Job created: {$emailType} for {$user->email}");
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info("🚀 Job processing started for: {$this->user->email}");
            
            $htmlContent = $this->generateEmailContent();
            
            Mail::html($htmlContent, function ($message) {
                $message->to($this->user->email, $this->user->name)
                        ->subject($this->subject)
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            Log::info("✅ Email sent successfully to: {$this->user->email}");
            
        } catch (\Exception $e) {
            Log::error("❌ Job failed for {$this->user->email}: " . $e->getMessage());
            throw $e; // Re-throw for queue retry
        }
    }

    /**
     * Generate email content based on type
     */
    private function generateEmailContent()
    {
        $message = $this->customMessage;
        
        // If status update and no custom message, use default
        if ($this->emailType === 'status_update' && empty($message)) {
            $status = $this->application->status;
            $defaultMessages = [
                'shortlisted' => "Congratulations! Your application has been shortlisted for the position of {$this->job->title} at {$this->job->company_name}.",
                'hired' => "Congratulations! You have been selected for the position of {$this->job->title} at {$this->job->company_name}. Welcome to the team!",
                'rejected' => "Thank you for applying for the position of {$this->job->title} at {$this->job->company_name}. After careful consideration...",
                'reviewed' => "Your application for {$this->job->title} at {$this->job->company_name} has been reviewed by our team.",
                'pending' => "Your application for {$this->job->title} at {$this->job->company_name} has been received and is pending review.",
            ];
            
            $message = $defaultMessages[$status] ?? 
                      "Your application status for {$this->job->title} has been updated to " . ucfirst($status) . ".";
        }
        
        // Sanitize message
        $sanitizedMessage = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));
        
        // Format interview time
        $interviewInfo = '';
        if ($this->interviewTime) {
            try {
                $formattedTime = \Carbon\Carbon::parse($this->interviewTime)->format('F j, Y \a\t h:i A');
                $interviewInfo = "
                <div style='background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 15px 0;'>
                    <h4 style='color: #856404; margin-top: 0;'>📅 Interview Scheduled</h4>
                    <p><strong>Date & Time:</strong> {$formattedTime}</p>
                </div>";
            } catch (\Exception $e) {
                Log::error("Invalid interview time: {$this->interviewTime}");
            }
        }
        
        // Format joining date
        $joiningInfo = '';
        if ($this->joiningDate) {
            try {
                $formattedDate = \Carbon\Carbon::parse($this->joiningDate)->format('F j, Y');
                $joiningInfo = "
                <div style='background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin: 15px 0;'>
                    <h4 style='color: #155724; margin-top: 0;'>🎉 Congratulations!</h4>
                    <p><strong>Joining Date:</strong> {$formattedDate}</p>
                </div>";
            } catch (\Exception $e) {
                Log::error("Invalid joining date: {$this->joiningDate}");
            }
        }
        
        // Status badge color
        $statusColors = [
            'hired' => '#28a745',
            'shortlisted' => '#17a2b8',
            'reviewed' => '#ffc107',
            'pending' => '#6c757d',
            'rejected' => '#dc3545',
        ];
        
        $statusColor = $statusColors[$this->application->status] ?? '#667eea';
        
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$this->subject}</title>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f4f4f4; }
                .email-container { background-color: #ffffff; border-radius: 10px; padding: 30px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 8px; text-align: center; margin-bottom: 30px; }
                .message-box { background-color: #f8f9fa; border-left: 4px solid #667eea; padding: 20px; margin: 20px 0; border-radius: 5px; }
                .job-details { background-color: #e8f4fd; border: 1px solid #d1e7ff; padding: 20px; border-radius: 5px; margin: 25px 0; }
                .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; text-align: center; color: #666; font-size: 14px; }
                .status-badge { display: inline-block; padding: 5px 15px; background-color: {$statusColor}; color: white; border-radius: 20px; font-weight: bold; text-transform: capitalize; }
                .btn { display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 15px; }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <div class='header'>
                    <h1 style='margin: 0; font-size: 24px;'>{$this->subject}</h1>
                </div>
                
                <div style='padding: 20px 0;'>
                    <p>Hello <strong>{$this->user->name}</strong>,</p>
                    
                    <div class='message-box'>
                        {$sanitizedMessage}
                    </div>
                    
                    {$interviewInfo}
                    {$joiningInfo}
                    
                    <div class='job-details'>
                        <h3 style='color: #667eea; margin-top: 0;'>📋 Application Details</h3>
                        <p><strong>Position:</strong> {$this->job->title}</p>
                        <p><strong>Company:</strong> {$this->job->company_name}</p>
                        <p><strong>Application ID:</strong> #{$this->application->id}</p>
                        <p><strong>Status:</strong> <span class='status-badge'>{$this->application->status}</span></p>
                    </div>
                    
                    <p>You can view your application status anytime by logging into your account.</p>
                    
                    <div style='text-align: center;'>
                        <a href='" . url('/login') . "' class='btn'>View Application Status</a>
                    </div>
                </div>
                
                <div class='footer'>
                    <p>Best regards,</p>
                    <p><strong>{$this->adminName}</strong></p>
                    <p>" . config('app.name') . " Team</p>
                    
                    <hr style='margin: 20px 0; border: none; border-top: 1px solid #eee;'>
                    <p style='font-size: 12px; color: #999;'>
                        This is an automated message from " . config('app.name') . ".<br>
                        Please do not reply to this email.
                    </p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
    
    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::error("❌❌❌ JOB FAILED for {$this->user->email}: " . $exception->getMessage());
    }
}