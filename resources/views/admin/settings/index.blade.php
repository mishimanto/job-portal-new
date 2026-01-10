@extends('layouts.admin')

@section('title', 'Settings - Admin Panel')
@section('page-title', 'Site Settings')
@section('page-subtitle', 'Manage site configuration')

@section('content')
<div class="space-y-6">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                General Settings
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Update your site settings and information.
            </p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('POST')
                
                <div class="space-y-6">
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700">
                            Site Name
                        </label>
                        <input type="text" name="site_name" id="site_name" 
                               value="{{ $settings['site_name'] ?? '' }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700">
                            Contact Email
                        </label>
                        <input type="email" name="contact_email" id="contact_email" 
                               value="{{ $settings['contact_email'] ?? '' }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700">
                            Contact Phone
                        </label>
                        <input type="text" name="contact_phone" id="contact_phone" 
                               value="{{ $settings['contact_phone'] ?? '' }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="contact_address" class="block text-sm font-medium text-gray-700">
                            Contact Address
                        </label>
                        <textarea name="contact_address" id="contact_address" rows="3"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings['contact_address'] ?? '' }}</textarea>
                    </div>
                    
                    <div>
                        <label for="about_us" class="block text-sm font-medium text-gray-700">
                            About Us
                        </label>
                        <textarea name="about_us" id="about_us" rows="5"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings['about_us'] ?? '' }}</textarea>
                    </div>
                    
                    <div class="pt-5">
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Settings
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection