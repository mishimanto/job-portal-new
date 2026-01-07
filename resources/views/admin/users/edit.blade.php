@extends('layouts.admin')

@section('title', 'Edit User - Admin Panel')
@section('page-title', 'Edit User')
@section('page-subtitle', 'Update user information')

@section('content')
<div x-data="editUser()" class="space-y-6">
    <!-- User Info Header -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- User Avatar -->
                    <div class="flex-shrink-0">
                        @if($user->profile_photo)
                            <img src="{{ Storage::url($user->profile_photo) }}" 
                                 alt="{{ $user->name }}"
                                 class="h-16 w-16 rounded-full object-cover border-2 border-white shadow">
                        @else
                            <div class="h-16 w-16 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center border-2 border-white shadow">
                                <span class="text-white text-xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- User Info -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h2>
                        <div class="flex items-center space-x-3 mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($user->role == 'admin') bg-purple-100 text-purple-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ $user->role == 'admin' ? 'Administrator' : 'Job Seeker' }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($user->is_active) bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($user->email_verified_at) bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $user->email }}</p>
                        @if($user->phone)
                            <p class="text-sm text-gray-600">{{ $user->phone }}</p>
                        @endif
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Users
                    </a>
                    
                    <button @click="showDeleteModal = true"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Edit User Information
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Update user details and permissions
            </p>
        </div>
        
        <form @submit.prevent="submitForm" class="p-6 space-y-6">
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name *
                    </label>
                    <input type="text" 
                           x-model="form.name"
                           id="name"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                    <p class="mt-1 text-xs text-red-500" x-show="errors.name" x-text="errors.name"></p>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address *
                    </label>
                    <input type="email" 
                           x-model="form.email"
                           id="email"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                    <p class="mt-1 text-xs text-red-500" x-show="errors.email" x-text="errors.email"></p>
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number
                    </label>
                    <input type="tel" 
                           x-model="form.phone"
                           id="phone"
                           class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                    <p class="mt-1 text-xs text-red-500" x-show="errors.phone" x-text="errors.phone"></p>
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Role *
                    </label>
                    <select x-model="form.role"
                            id="role"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                        <option value="job_seeker">Job Seeker</option>
                        <option value="admin">Administrator</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">
                        <span x-show="form.role === 'admin'" class="text-yellow-600">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Admins have full system access
                        </span>
                        <span x-show="form.role === 'job_seeker'" class="text-blue-600">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 002 2z"/>
                            </svg>
                            Job seekers can apply for jobs and manage their profile
                        </span>
                    </p>
                </div>
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                    Address
                </label>
                <textarea x-model="form.address"
                          id="address"
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"></textarea>
            </div>

            <!-- Password Section -->
            <div class="pt-6 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Change Password</h3>
                <p class="text-sm text-gray-600 mb-4">Leave blank to keep current password</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            New Password
                        </label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'"
                                   x-model="form.password"
                                   id="password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                            <button type="button" 
                                    @click="showPassword = !showPassword"
                                    class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path x-show="showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    <path x-show="!showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path x-show="!showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-red-500" x-show="errors.password" x-text="errors.password"></p>
                        <div class="mt-2 space-y-1">
                            <p class="text-xs text-gray-500">Password requirements:</p>
                            <ul class="text-xs text-gray-500 space-y-1">
                                <li :class="!form.password || form.password.length >= 8 ? 'text-green-600' : 'text-red-400'">
                                    <svg class="inline w-3 h-3 mr-1" :class="!form.password || form.password.length >= 8 ? 'text-green-500' : 'text-red-500'" fill="currentColor" viewBox="0 0 20 20">
                                        <path :d="!form.password || form.password.length >= 8 ? 'M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z' : 'M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z'"/>
                                    </svg>
                                    Minimum 8 characters
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm Password
                        </label>
                        <div class="relative">
                            <input :type="showConfirmPassword ? 'text' : 'password'"
                                   x-model="form.password_confirmation"
                                   id="password_confirmation"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                            <button type="button" 
                                    @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path x-show="showConfirmPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    <path x-show="!showConfirmPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path x-show="!showConfirmPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-2 text-xs" 
                           :class="!form.password || form.password === form.password_confirmation ? 'text-green-600' : 'text-red-600'">
                            <svg class="inline w-3 h-3 mr-1" :class="!form.password || form.password === form.password_confirmation ? 'text-green-500' : 'text-red-500'" fill="currentColor" viewBox="0 0 20 20">
                                <path :d="!form.password || form.password === form.password_confirmation ? 'M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z' : 'M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z'"/>
                            </svg>
                            Passwords match
                        </p>
                    </div>
                </div>
            </div>

            <!-- Account Settings -->
            <div class="pt-6 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Account Settings</h3>
                
                <div class="space-y-4">
                    <!-- Active Status -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Account Active</h3>
                            <p class="text-sm text-gray-500">Enable or disable user account</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   x-model="form.is_active"
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    </div>

                    <!-- Email Verification -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Email Verified</h3>
                            <p class="text-sm text-gray-500">Mark email as verified</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   x-model="form.email_verified"
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <div class="flex items-center space-x-4">
                    <button type="button" 
                            @click="resetForm"
                            class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors duration-200">
                        Reset Changes
                    </button>
                    <button type="button" 
                            @click="toggleUserStatus"
                            :class="form.is_active ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-green-100 text-green-800 hover:bg-green-200'"
                            class="px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        <span x-text="form.is_active ? 'Deactivate User' : 'Activate User'"></span>
                    </button>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit" 
                            :disabled="loading"
                            :class="loading ? 'opacity-75 cursor-not-allowed' : 'hover:bg-indigo-700'"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-md transition-colors duration-200">
                        <template x-if="!loading">
                            <span>Update User</span>
                        </template>
                        <template x-if="loading">
                            <span class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Updating...
                            </span>
                        </template>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div x-show="showDeleteModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto" 
     x-cloak>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" 
             @click="showDeleteModal = false"></div>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.342 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Delete User
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete <span class="font-semibold">{{ $user->name }}</span>?
                                This action cannot be undone and will permanently delete all user data.
                            </p>
                            <div class="mt-4 p-3 bg-red-50 rounded border border-red-200">
                                <p class="text-sm text-red-600">
                                    <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.342 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                    Warning: This action cannot be reversed.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" 
                        @click="deleteUser"
                        :disabled="deleting"
                        :class="deleting ? 'opacity-75 cursor-not-allowed' : 'hover:bg-red-700'"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    <template x-if="!deleting">
                        Delete User
                    </template>
                    <template x-if="deleting">
                        <span class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Deleting...
                        </span>
                    </template>
                </button>
                <button type="button" 
                        @click="showDeleteModal = false"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function editUser() {
    return {
        loading: false,
        deleting: false,
        showPassword: false,
        showConfirmPassword: false,
        showDeleteModal: false,
        errors: {},
        form: {
            name: '{{ $user->name }}',
            email: '{{ $user->email }}',
            phone: '{{ $user->phone ?? '' }}',
            address: '{{ $user->address ?? '' }}',
            role: '{{ $user->role }}',
            password: '',
            password_confirmation: '',
            is_active: {{ $user->is_active ? 'true' : 'false' }},
            email_verified: {{ $user->email_verified_at ? 'true' : 'false' }}
        },
        
        resetForm() {
            this.form = {
                name: '{{ $user->name }}',
                email: '{{ $user->email }}',
                phone: '{{ $user->phone ?? '' }}',
                address: '{{ $user->address ?? '' }}',
                role: '{{ $user->role }}',
                password: '',
                password_confirmation: '',
                is_active: {{ $user->is_active ? 'true' : 'false' }},
                email_verified: {{ $user->email_verified_at ? 'true' : 'false' }}
            };
            this.errors = {};
            
            Swal.fire({
                title: 'Reset!',
                text: 'Form has been reset to original values',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        },
        
        async toggleUserStatus() {
            const result = await Swal.fire({
                title: this.form.is_active ? 'Deactivate User?' : 'Activate User?',
                text: this.form.is_active 
                    ? 'User will not be able to login until activated.'
                    : 'User will be able to login and use the system.',
                icon: this.form.is_active ? 'warning' : 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes, ' + (this.form.is_active ? 'deactivate' : 'activate'),
                cancelButtonText: 'Cancel',
                reverseButtons: true
            });
            
            if (result.isConfirmed) {
                this.form.is_active = !this.form.is_active;
            }
        },
        
        async submitForm() {
            this.loading = true;
            this.errors = {};
            
            // Validate passwords if provided
            if (this.form.password && this.form.password !== this.form.password_confirmation) {
                this.errors.password = 'Passwords do not match';
                this.loading = false;
                
                Swal.fire({
                    title: 'Error!',
                    text: 'Passwords do not match',
                    icon: 'error',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
                return;
            }
            
            if (this.form.password && this.form.password.length < 8) {
                this.errors.password = 'Password must be at least 8 characters';
                this.loading = false;
                
                Swal.fire({
                    title: 'Error!',
                    text: 'Password must be at least 8 characters',
                    icon: 'error',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
                return;
            }
            
            try {
                const formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('name', this.form.name);
                formData.append('email', this.form.email);
                formData.append('phone', this.form.phone);
                formData.append('address', this.form.address);
                formData.append('role', this.form.role);
                formData.append('is_active', this.form.is_active ? '1' : '0');
                formData.append('email_verified', this.form.email_verified ? '1' : '0');
                
                if (this.form.password) {
                    formData.append('password', this.form.password);
                    formData.append('password_confirmation', this.form.password_confirmation);
                }
                
                const response = await fetch('{{ route('admin.users.update', $user) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                    throw new Error(data.message || 'Failed to update user');
                }
                
                // Success
                await Swal.fire({
                    title: 'Success!',
                    text: 'User updated successfully',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
                
                // Redirect to users list
                window.location.href = '{{ route('admin.users.index') }}';
                
            } catch (error) {
                console.error('Error:', error);
                
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'Failed to update user',
                    icon: 'error',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            } finally {
                this.loading = false;
            }
        },
        
        async deleteUser() {
            this.deleting = true;
            
            try {
                const response = await fetch('{{ route('admin.users.destroy', $user) }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.message || 'Failed to delete user');
                }
                
                // Success
                await Swal.fire({
                    title: 'Deleted!',
                    text: 'User has been deleted successfully.',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Go to Users List',
                    confirmButtonColor: '#3085d6'
                });
                
                // Redirect to users list
                window.location.href = '{{ route('admin.users.index') }}';
                
            } catch (error) {
                console.error('Error:', error);
                
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'Failed to delete user',
                    icon: 'error',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            } finally {
                this.deleting = false;
                this.showDeleteModal = false;
            }
        }
    }
}
</script>
@endpush

@push('styles')
<style>
[x-cloak] {
    display: none !important;
}

/* Password strength indicator */
.password-strength {
    transition: all 0.3s ease;
}
</style>
@endpush