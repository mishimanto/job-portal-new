<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\SiteSetting;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PageController extends Controller
{
    public function home()
    {
        // Get current date
        $today = Carbon::today()->toDateString();
        
        // ✅ Fix: Load required relationships and ensure slug is selected
        $featuredJobs = Job::select('*') // Ensure all fields including slug
            ->with(['company', 'category'])
            ->where('is_active', 1)
            ->where('status', 'approved')
            ->where(function($query) use ($today) {
                $query->whereNull('application_deadline')
                    ->orWhere('application_deadline', '>=', $today);
            })
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get()
            ->map(function ($job) {
                // ✅ Ensure slug exists
                if (empty($job->slug)) {
                    $job->slug = $job->generateSlug();
                    $job->save();
                }
                return $job;
            });
            
        // ✅ Same fix for recentJobs
        $recentJobs = Job::select('*')
            ->with(['company', 'category'])
            ->where('is_active', 1)
            ->where('status', 'approved')
            ->where(function($query) use ($today) {
                $query->whereNull('application_deadline')
                    ->orWhere('application_deadline', '>=', $today);
            })
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get()
            ->map(function ($job) {
                if (empty($job->slug)) {
                    $job->slug = $job->generateSlug();
                    $job->save();
                }
                return $job;
            });
        
        // Get featured blogs
        $featuredBlogs = \App\Models\Blog::published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
        
        // Get recent blogs if less than 3 featured
        if ($featuredBlogs->count() < 3) {
            $additionalBlogs = \App\Models\Blog::published()
                ->whereNotIn('id', $featuredBlogs->pluck('id'))
                ->orderBy('published_at', 'desc')
                ->take(3 - $featuredBlogs->count())
                ->get();
            
            $featuredBlogs = $featuredBlogs->merge($additionalBlogs);
        }
        
        return view('home', compact('featuredJobs', 'recentJobs', 'featuredBlogs'));
    }

    public function about()
    {
        $about = SiteSetting::getValue('about_us', '');
        return view('pages.about', compact('about'));
    }

    public function contact()
    {
        $contact = [
            'email' => SiteSetting::getValue('contact_email', 'contact@jobportal.com'),
            'phone' => SiteSetting::getValue('contact_phone', '+880 1900-000000'),
            'address' => SiteSetting::getValue('contact_address', '123 Street, City, Country'),
        ];
        
        return view('pages.contact', compact('contact'));
    }

    public function submitContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Save to database
            $contactMessage = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ]);

            // Send email notification
            // $adminEmail = SiteSetting::getValue('contact_email', 'admin@jobportal.com');
            // if ($adminEmail) {
            //     Mail::to($adminEmail)->send(new ContactFormMail($contactMessage));
            // }

            // Send auto-reply to user
            // if ($request->email) {
            //     Mail::to($request->email)->send(new \App\Mail\ContactAutoReplyMail($contactMessage));
            // }

            return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');

        } catch (\Exception $e) {
            \Log::error('Contact form submission error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again later.')
                ->withInput();
        }
    }

    // Admin contact messages management
public function contactMessages(Request $request)
{
    if (!auth()->user() || auth()->user()->role !== 'admin') {
        abort(403);
    }

    $query = ContactMessage::query();
    
    // Status filter
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }
    
    // Date range filter
    if ($request->has('date_from') && $request->date_from != '') {
        $query->whereDate('created_at', '>=', $request->date_from);
    }
    
    if ($request->has('date_to') && $request->date_to != '') {
        $query->whereDate('created_at', '<=', $request->date_to);
    }
    
    // Search filter
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('subject', 'like', "%{$search}%")
              ->orWhere('message', 'like', "%{$search}%");
        });
    }
    
    $messages = $query->orderBy('created_at', 'desc')->paginate(20);
    $unreadCount = ContactMessage::where('status', 'unread')->count();

    // Check if it's an AJAX request
    if ($request->ajax()) {
        // AJAX এর জন্য শুধু HTML return করব
        return response()->json([
            'table_html' => view('admin.contact-messages.partials.messages-table', compact('messages'))->render(),
            'pagination_html' => $messages->hasPages() ? $messages->links()->toHtml() : '',
            'total' => $messages->total(),
            'unreadCount' => $unreadCount
        ]);
    }

    return view('admin.contact-messages.index', compact('messages', 'unreadCount'));
}

    public function showContactMessage($id)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        $message = ContactMessage::findOrFail($id);
        $message->markAsRead();

        return view('admin.contact-messages.show', compact('message'));
    }

    public function replyContactMessage(Request $request, $id)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        $message = ContactMessage::findOrFail($id);

        $request->validate([
            'reply_message' => 'required|string|min:10|max:2000',
        ]);

        try {
            // Save reply to database
            $message->markAsReplied($request->reply_message);

            // Send email reply to user using SMTP
            Mail::to($message->email)->send(new \App\Mail\ContactReplyMail($message, $request->reply_message));

            return redirect()->route('admin.contact.messages')
                ->with('success', 'Reply sent successfully to ' . $message->email);

        } catch (\Exception $e) {
            \Log::error('Contact reply error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to send reply. Please check your SMTP configuration.')
                ->withInput();
        }
    }

    public function updateContactMessage(Request $request, $id)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        $message = ContactMessage::findOrFail($id);

        $request->validate([
            'status' => 'required|in:unread,read,replied,closed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $message->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Message updated successfully.');
    }

    public function deleteContactMessage($id)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.contact.messages')
            ->with('success', 'Message deleted successfully.');
    }
}