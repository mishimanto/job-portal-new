@extends('layouts.admin')

@section('title', 'View Message - Admin Panel')

@section('page-title', 'Messages')
@section('page-subtitle', 'Show Messages')

@section('content')
<div class="container-fluid px-4">
    <div class="flex justify-between items-center mb-4">
        <div>
            <!-- <h1 class="text-2xl font-bold text-gray-800">Message Details</h1> -->
            <p class="text-gray-700 text-xl">From: <span class="font-bold">{{ $message->name }}</span></p>
        </div>

        <div>
            <a href="{{ route('admin.contact.messages') }}" 
            class="flex items-center text-gray-600 hover:text-gray-900 bg-white px-4 py-2 rounded-lg border border-gray-300 hover:border-gray-400 transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Messages
            </a>
        </div>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Message Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Message Card -->
            <div class="bg-white rounded-lg shadow border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $message->subject }}</h2>
                            <div class="flex flex-wrap items-center mt-2 gap-3">
                                <!-- <span class="inline-flex items-center text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $message->name }}
                                </span> -->
                                <span class="inline-flex items-center text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $message->email }}
                                </span>
                                <span class="inline-flex items-center text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $message->formatted_created_at }}
                                </span>
                            </div>
                        </div>
                        <div>
                            @php
                                $statusColors = [
                                    'unread' => 'bg-red-100 text-red-800 border border-red-200',
                                    'read' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                    'replied' => 'bg-green-100 text-green-800 border border-green-200',
                                    'closed' => 'bg-gray-100 text-gray-800 border border-gray-200',
                                ];
                            @endphp
                            <span class="px-4 py-2 inline-flex items-center text-sm font-semibold rounded-full {{ $statusColors[$message->status] }}">
                                <span class="w-2 h-2 rounded-full mr-2 
                                    @if($message->status == 'unread') bg-red-500
                                    @elseif($message->status == 'read') bg-blue-500
                                    @elseif($message->status == 'replied') bg-green-500
                                    @else bg-gray-500 @endif"></span>
                                {{ ucfirst($message->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-700">Message Content:</h3>
                    </div>
                    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                        <p class="text-gray-800 whitespace-pre-line leading-relaxed">{{ $message->message }}</p>
                    </div>
                    
                    <!-- Technical Details -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h4 class="text-sm font-medium text-gray-500">Technical Information:</h4>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-3 rounded border border-gray-200">
                                <p class="text-xs font-medium text-gray-500 mb-1">IP Address</p>
                                <p class="font-mono text-sm text-gray-800">{{ $message->ip_address ?? 'N/A' }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded border border-gray-200">
                                <p class="text-xs font-medium text-gray-500 mb-1">Message ID</p>
                                <p class="font-mono text-sm text-gray-800">#{{ str_pad($message->id, 6, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                        <div class="mt-3 bg-gray-50 p-3 rounded border border-gray-200">
                            <p class="text-xs font-medium text-gray-500 mb-1">User Agent</p>
                            <p class="text-xs font-mono text-gray-800 break-words">{{ $message->user_agent ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Reply Section -->
            <div id="reply" class="bg-white rounded-lg shadow border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-700 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800">
                            @if($message->hasReply())
                                Update Reply
                            @else
                                Send Reply
                            @endif
                        </h3>
                    </div>
                    <p class="text-sm text-gray-600 mt-1 ml-7">
                        Send an email response to <span class="font-medium text-blue-600">{{ $message->email }}</span>
                    </p>
                </div>
                
                <div class="p-6">
                    @if($message->hasReply())
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-green-800 font-medium">Reply sent on {{ $message->formatted_replied_at }}</p>
                                <p class="text-green-700 text-sm mt-1">Your reply was sent via email.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center mb-2">
                            <svg class="w-4 h-4 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h4 class="font-medium text-gray-700">Previous Reply:</h4>
                        </div>
                        <p class="text-gray-800 whitespace-pre-line bg-white p-3 rounded border border-gray-200">{{ $message->admin_reply }}</p>
                    </div>
                    @endif

                    <!-- Reply Form -->
                    <form id="replyForm"
                        action="{{ route('admin.contact.reply', $message->id) }}"
                        method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="reply_message" class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Reply Message <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>

                            <textarea id="reply_message"
                                    name="reply_message"
                                    rows="6"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    placeholder="Type your reply here...">{{ old('reply_message', $message->admin_reply) }}</textarea>

                            @error('reply_message')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <!-- Button aligned with textarea -->
                            <div class="mt-4 flex justify-end">
                                <button type="submit"
                                        class="flex items-center bg-blue-600 text-white font-semibold py-2.5 px-6 rounded-lg hover:bg-blue-700 transition duration-200 shadow-sm hover:shadow">
                                    @if($message->hasReply())
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        Update Reply
                                    @else
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                        Send Reply
                                    @endif
                                </button>
                            </div>
                        </div>
                    </form>                   

                    <!-- Status Update Form -->
                    <!-- <form id="statusForm"
                        action="{{ route('admin.contact.update', $message->id) }}"
                        method="POST"
                        class="mt-4 inline-block">
                        @csrf
                        @method('PUT')

                        <select name="status"
                                onchange="this.form.submit()"
                                class="border rounded-lg px-4 py-2">
                            <option value="unread" {{ $message->status == 'unread' ? 'selected' : '' }}>Unread</option>
                            <option value="read" {{ $message->status == 'read' ? 'selected' : '' }}>Read</option>
                            <option value="replied" {{ $message->status == 'replied' ? 'selected' : '' }}>Replied</option>
                            <option value="closed" {{ $message->status == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </form> -->

                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Admin Notes -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 text-gray-700 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">Admin Notes</h3>
                </div>
                <form action="{{ route('admin.contact.update', $message->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <textarea name="admin_notes" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                  placeholder="Add internal notes here...">{{ old('admin_notes', $message->admin_notes) }}</textarea>
                    </div>
                    <button type="submit" 
                            class="w-full flex items-center justify-center bg-gray-600 text-white font-semibold py-2.5 px-4 rounded-lg hover:bg-gray-700 transition duration-200 shadow-sm hover:shadow">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Notes
                    </button>
                </form>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 text-gray-700 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
                </div>
                <div class="space-y-2">
                    <form action="{{ route('admin.contact.delete', $message->id) }}" method="POST"
                          onsubmit="return confirmMessage(event)"
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full text-left flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition duration-200 border border-transparent hover:border-red-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span class="font-medium">Delete Message</span>
                        </button>
                    </form>
                    
                    <a href="mailto:{{ $message->email }}" 
                       class="block px-4 py-3 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 border border-transparent hover:border-blue-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="font-medium">Send Email Directly</span>
                        </div>
                    </a>
                    
                    <!-- <button onclick="printMessage()" 
                            class="w-full text-left flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition duration-200 border border-transparent hover:border-gray-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        <span class="font-medium">Print Details</span>
                    </button> -->

                    <a href="{{ route('admin.contact.messages') }}" 
                       class="block px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition duration-200 border border-transparent hover:border-gray-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            <span class="font-medium">Back to All Messages</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Message Info -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 text-gray-700 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">Message Information</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                        <p class="text-sm text-gray-500">Reference ID</p>
                        <p class="font-mono text-sm font-medium bg-gray-100 px-2 py-1 rounded">#{{ str_pad($message->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$message->status] }}">
                            {{ ucfirst($message->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                        <p class="text-sm text-gray-500">Created</p>
                        <p class="text-sm font-medium">{{ $message->formatted_created_at }}</p>
                    </div>
                    @if($message->replied_at)
                    <div class="flex justify-between items-center">
                        <p class="text-sm text-gray-500">Replied</p>
                        <p class="text-sm font-medium">{{ $message->formatted_replied_at }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 text-gray-700 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">Contact Information</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <div>
                            <p class="text-xs text-gray-500">Name</p>
                            <p class="text-sm font-medium">{{ $message->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="text-sm font-medium break-all">{{ $message->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        
        body {
            font-size: 12pt;
        }
        
        .container-fluid {
            max-width: 100% !important;
            padding: 0 !important;
        }
        
        .shadow, .border {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-expand textarea based on content
    function autoExpand(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('reply_message');
        if (textarea) {
            textarea.addEventListener('input', function() {
                autoExpand(this);
            });
            autoExpand(textarea); // Initial call
        }
    });

    // SweetAlert for delete confirmation
    function confirmMessage(event) {
        event.preventDefault();
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
        
        return false;
    }

    // SweetAlert for print confirmation
    function printMessage() {
        Swal.fire({
            title: 'Print Message Details?',
            text: "Are you sure you want to print this message?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, print it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.print();
            }
        });
    }
</script>
@endpush