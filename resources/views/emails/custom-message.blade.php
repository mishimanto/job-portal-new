<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update on Your Job Application</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px 0;
        }
        .message-box {
            background-color: #f8f9fa;
            padding: 20px;
            margin: 20px 0;
        }
        .job-details {
            background-color: #e8f4fd;
            border: 1px solid #d1e7ff;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
        .signature {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- <div class="header">
            <h1>Update on Your Job Application</h1>
        </div> -->
        
        <div class="content">
            
            
            <div class="">
                <p>Hello <strong>{{ $user->name }}</strong>,</p>
                <p>{!! nl2br(e($customMessage)) !!}</p>
            </div>
            
            <!-- <div class="job-details">
                <h3 style="margin-top: 0; color: #667eea;">Job Application Details:</h3>
                <p><strong>Position:</strong> {{ $job->title }}</p>
                <p><strong>Company:</strong> {{ $job->company_name }}</p>
                <p><strong>Application ID:</strong> #{{ $application->id }}</p>
                <p><strong>Status:</strong> <span style="color: #667eea; font-weight: bold;">{{ ucfirst($application->status) }}</span></p>
            </div> -->
            
            <!-- <p>You can view your application status anytime by logging into your account.</p>
            
            <a href="{{ url('/login') }}" class="btn">View Application Status</a> -->
        </div>
        
        <div class="signature">
            <p>Best regards,</p>
            <p><strong>{{ $adminName }}</strong></p>
            <p>{{ config('app.name') }} Team</p>
        </div>
        
        <div class="footer">
            <!-- <p>This is an automated message from {{ config('app.name') }}.</p> -->
            <p>Contact us at {{ config('mail.from.address') }}</p>
        </div>
    </div>
</body>
</html>