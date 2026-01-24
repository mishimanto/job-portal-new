@extends('layouts.app')

@section('title', 'Contact Us - ' . config('app.name'))

@section('content')
<div class="py-12 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Get in Touch</h1>
            <!-- <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Have questions? We're here to help. Contact our team for job postings, partnerships, 
                or any other inquiries. We typically respond within 24 hours.
            </p> -->
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-green-800">{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-red-800">{{ session('error') }}</span>
                    </div>
                </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               required
                               value="{{ old('name') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Enter your full name">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               value="{{ old('email') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Enter your email address">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            Subject <span class="text-red-500">*</span>
                        </label>
                        <select id="subject" 
                                name="subject" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="" disabled selected>Select a subject</option>
                            <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                            <option value="Job Posting" {{ old('subject') == 'Job Posting' ? 'selected' : '' }}>Job Posting</option>
                            <option value="Partnership" {{ old('subject') == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                            <option value="Technical Support" {{ old('subject') == 'Technical Support' ? 'selected' : '' }}>Technical Support</option>
                            <option value="Feedback/Suggestion" {{ old('subject') == 'Feedback/Suggestion' ? 'selected' : '' }}>Feedback/Suggestion</option>
                            <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('subject')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="6"
                                  required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                  placeholder="Tell us how we can help you...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 px-6 rounded-lg hover:from-blue-700 hover:to-blue-800 transition duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Send Message
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <!-- Contact Details -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Contact Information</h2>
                    
                    <div class="space-y-6">
                        <!-- Email -->
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-xl mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-700 mb-1">Email Address</h3>
                                <a href="mailto:{{ $contact['email'] }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $contact['email'] }}
                                </a>
                                <p class="text-sm text-gray-500 mt-1">We'll respond within 24 hours</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start">
                            <div class="bg-green-100 p-3 rounded-xl mr-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-700 mb-1">Phone Number</h3>
                                <a href="tel:{{ $contact['phone'] }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $contact['phone'] }}
                                </a>
                                <p class="text-sm text-gray-500 mt-1">From 9am to 6pm</p>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="flex items-start">
                            <div class="bg-purple-100 p-3 rounded-xl mr-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-700 mb-1">Office Address</h3>
                                <p class="text-gray-600">{{ $contact['address'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">Visit our office anytime</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Office Hours -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Office Hours</h3>
                    <div class="space-y-4">
                        @php
                            $hours = [
                                ['day' => 'Saturday - Friday', 'time' => '9:00 AM - 6:00 PM', 'status' => 'open'],                                
                            ];
                        @endphp
                        
                        @foreach($hours as $hour)
                        <div class="flex justify-between items-center p-3 rounded-lg {{ $hour['status'] == 'closed' ? 'bg-red-50' : 'bg-gray-50' }}">
                            <span class="text-gray-700 font-medium">{{ $hour['day'] }}</span>
                            <span class="ml-2 font-semibold {{ $hour['status'] == 'closed' ? 'text-red-600' : 'text-green-600' }}">
                                {{ $hour['time'] }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- FAQ Preview -->
                <!-- <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-xl p-8 text-white">
                    <h3 class="text-xl font-bold mb-4">Quick Help</h3>
                    <p class="mb-4 opacity-90">Find quick answers to common questions</p>
                    
                       class="inline-flex items-center bg-white text-blue-600 font-semibold py-2 px-4 rounded-lg hover:bg-gray-100 transition duration-200">
                        Visit FAQ
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div> -->
            </div>
        </div>

        <!-- FAQ Section -->
        <!-- FAQ Section -->
<div class="mt-12">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">
            Frequently Asked Questions
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $faqs = [
                [
                    'question' => 'How do I apply for a job?',
                    'answer' => 'Register as an applicant, complete your company profile, and apply for jobs from your dashboard.'
                ],
                [
                    'question' => 'Is there a fee for job seekers?',
                    'answer' => 'No, our platform is completely free for job seekers to apply and search for jobs.'
                ],
                [
                    'question' => 'How do I update my profile?',
                    'answer' => 'Log in, go to "My Profile" and edit your information anytime.'
                ],
                [
                    'question' => 'Can I delete my account?',
                    'answer' => 'Yes, you can delete your account from account settings anytime.'
                ],
                [
                    'question' => 'How long do job postings stay active?',
                    'answer' => 'Job postings typically stay active for 30 days or until filled.'
                ],
                [
                    'question' => 'Is my personal information safe?',
                    'answer' => 'Yes, we use encryption and follow strict privacy policies to protect your data.'
                ],
            ];
        @endphp
        
        @foreach($faqs as $faq)
        <div 
            x-data="{ open:false }"
            class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition duration-300"
        >
            <!-- Question -->
            <button 
                @click="open = !open"
                class="w-full flex justify-between items-center text-left"
            >
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ $faq['question'] }}
                </h3>

                <!-- Arrow Icon -->
                <svg class="w-5 h-5 text-gray-500 transition-transform duration-300"
                     :class="open && 'rotate-180'"
                     fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Answer -->
            <div 
                x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 max-h-0"
                x-transition:enter-end="opacity-100 max-h-40"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 max-h-40"
                x-transition:leave-end="opacity-0 max-h-0"
                class="overflow-hidden"
            >
                <p class="text-gray-600 mt-4">
                    {{ $faq['answer'] }}
                </p>
            </div>
        </div>
        @endforeach
    </div>
</div>

    </div>
</div>
@endsection

@push('styles')
<style>
    .contact-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    select option {
        padding: 12px;
    }
    
    select option:disabled {
        color: #9ca3af;
    }
</style>
@endpush

@push('scripts')
<script>
    // Form validation feedback
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <span class="flex items-center justify-center">
                            <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Sending...
                        </span>
                    `;
                }
            });
        }
    });
</script>
@endpush