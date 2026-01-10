@extends('layouts.admin')

@section('title', 'Users - Admin Panel')
@section('page-title', 'User Management')
@section('page-subtitle', 'Manage all system users')

@section('content')
<div x-data="userManagement()" x-init="init()" class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 12a5 5 0 100-10 5 5 0 000 10zm7 9v-1a7 7 0 00-14 0v1" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $totalUsers }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Admins</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $adminsCount }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Job Seekers</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $jobSeekersCount }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Active Today</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $activeTodayCount }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users List -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        All Users
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Total {{ $users->total() }} users found
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" 
                               x-model="searchQuery" 
                               @input.debounce.500ms="searchUsers"
                               placeholder="Search users..." 
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500 w-64">
                        <div class="absolute left-3 top-2.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Filters -->
                    <select x-model="selectedRole" 
                            @change="filterByRole"
                            class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Roles</option>
                        <option value="admin">Admins</option>
                        <option value="job_seeker">Job Seekers</option>
                    </select>
                    
                    <select x-model="selectedStatus" 
                            @change="filterByStatus"
                            class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    
                    <!-- Add User Button -->
                    <button @click="showCreateModal = true"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add User
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Loading State -->
        <div x-show="loading" class="p-8 text-center">
            <div class="inline-flex items-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-600">Loading users...</span>
            </div>
        </div>

        <!-- Users Table -->
        <div x-show="!loading" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email Verification
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Joined
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="user in users" :key="user.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <template x-if="user.profile_photo">
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 :src="`/storage/${user.profile_photo}`" 
                                                 :alt="user.name">
                                        </template>
                                        <template x-if="!user.profile_photo">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm" x-text="user.name.charAt(0)"></span>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900" x-text="user.name"></div>
                                        <div class="text-sm text-gray-500" x-text="user.email"></div>
                                        <div x-show="user.phone" class="text-sm text-gray-500" x-text="user.phone"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="{
                                    'bg-purple-100 text-purple-800': user.role === 'admin',
                                    'bg-blue-100 text-blue-800': user.role === 'job_seeker'
                                }" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium">
                                    <svg class="mr-1.5 h-2 w-2" :class="{
                                        'text-purple-400': user.role === 'admin',
                                        'text-blue-400': user.role === 'job_seeker'
                                    }" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"/>
                                    </svg>
                                    <span x-text="user.role === 'admin' ? 'Admin' : 'Job Seeker'"></span>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="{
                                    'bg-green-100 text-green-800': user.is_active,
                                    'bg-gray-100 text-gray-800': !user.is_active
                                }" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium">
                                    <svg class="mr-1.5 h-2 w-2" :class="{
                                        'text-green-400': user.is_active,
                                        'text-gray-400': !user.is_active
                                    }" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"/>
                                    </svg>
                                    <span x-text="user.is_active ? 'Active' : 'Inactive'"></span>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="{
                                    'bg-green-100 text-green-800': user.email_verified_at,
                                    'bg-yellow-100 text-yellow-800': !user.email_verified_at
                                }" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium">
                                    <svg class="mr-1.5 h-4 w-4" :class="{
                                        'text-green-400': user.email_verified_at,
                                        'text-yellow-400': !user.email_verified_at
                                    }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path x-show="user.email_verified_at" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        <path x-show="!user.email_verified_at" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <span x-text="user.email_verified_at ? 'Verified' : 'Unverified'"></span>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span x-text="formatDate(user.created_at)"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <!-- View Button -->
                                    <a :href="`/admin/users/${user.id}`" 
                                       class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200"
                                       title="View Details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    
                                    <!-- Edit Button -->
                                    <a :href="`/admin/users/${user.id}/edit`" 
                                       class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                       title="Edit User">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    
                                    <!-- Toggle Status Button -->
                                    <button @click="toggleUserStatus(user)"
                                            :class="{
                                                'text-yellow-600 hover:text-yellow-900': user.is_active,
                                                'text-green-600 hover:text-green-900': !user.is_active
                                            }"
                                            class="transition-colors duration-200"
                                            :title="user.is_active ? 'Deactivate' : 'Activate'">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                    </button>
                                    
                                    <!-- Delete Button (Only for non-admins) -->
                                    <template x-if="user.role !== 'admin'">
                                        <button @click="deleteUser(user)"
                                                class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                title="Delete User">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                            </td>
                        </tr>
                    </template>
                    
                    <!-- Empty State -->
                    <tr x-show="users.length === 0 && !loading">
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 0h-6m0 0V8a3 3 0 00-6 0v4m6 0a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
                            <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div x-show="users.length > 0 && !loading" class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing <span x-text="from"></span> to <span x-text="to"></span> of <span x-text="total"></span> results
                </div>
                <div class="flex space-x-2">
                    <button @click="previousPage" 
                            :disabled="currentPage === 1"
                            :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                            class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white">
                        Previous
                    </button>
                    
                    <template x-for="page in pages" :key="page">
                        <button @click="goToPage(page)"
                                :class="currentPage === page ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'"
                                class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium">
                            <span x-text="page"></span>
                        </button>
                    </template>
                    
                    <button @click="nextPage" 
                            :disabled="currentPage === lastPage"
                            :class="currentPage === lastPage ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                            class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div x-show="showCreateModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto" 
     x-cloak>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" 
             @click="showCreateModal = false"></div>
        
        <!-- Modal -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <!-- Modal Header -->
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Create New User</h3>
                    <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <form @submit.prevent="submitCreateForm" class="px-4 pb-4">
                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                        <input type="text" 
                               x-model="createForm.name"
                               id="name"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                        <input type="email" 
                               x-model="createForm.email"
                               id="email"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role *</label>
                        <select x-model="createForm.role"
                                id="role"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="job_seeker">Job Seeker</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                    
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                        <input type="password" 
                               x-model="createForm.password"
                               id="password"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                    </div>
                    
                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password *</label>
                        <input type="password" 
                               x-model="createForm.password_confirmation"
                               id="password_confirmation"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" 
                            @click="showCreateModal = false"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            :disabled="creatingUser"
                            :class="creatingUser ? 'opacity-75 cursor-not-allowed' : 'hover:bg-indigo-700'"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                        <template x-if="!creatingUser">
                            <span>Create User</span>
                        </template>
                        <template x-if="creatingUser">
                            <span class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Creating...
                            </span>
                        </template>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function userManagement() {
    return {
        loading: false,
        creatingUser: false,
        users: @json($users->items()),
        currentPage: {{ $users->currentPage() }},
        lastPage: {{ $users->lastPage() }},
        perPage: {{ $users->perPage() }},
        total: {{ $users->total() }},
        from: {{ $users->firstItem() ?? 0 }},
        to: {{ $users->lastItem() ?? 0 }},
        searchQuery: '',
        selectedRole: '',
        selectedStatus: '',
        showCreateModal: false,
        createForm: {
            name: '',
            email: '',
            role: 'job_seeker',
            password: '',
            password_confirmation: ''
        },
        
        init() {
            console.log('User Management Initialized');
            // Format users data to ensure email_verified_at is safe
            this.users = this.users.map(user => ({
                ...user,
                email_verified_at: user.email_verified_at || null,
                phone: user.phone || '',
                profile_photo: user.profile_photo || ''
            }));
        },
        
        get pages() {
            const pages = [];
            const totalPages = this.lastPage;
            let startPage = Math.max(1, this.currentPage - 2);
            let endPage = Math.min(totalPages, this.currentPage + 2);
            
            if (this.currentPage <= 3) {
                endPage = Math.min(5, totalPages);
            }
            if (this.currentPage >= totalPages - 2) {
                startPage = Math.max(totalPages - 4, 1);
            }
            
            for (let i = startPage; i <= endPage; i++) {
                pages.push(i);
            }
            return pages;
        },
        
        formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        },
        
        async searchUsers() {
            if (this.searchQuery.length === 0 || this.searchQuery.length >= 3) {
                await this.fetchUsers();
            }
        },
        
        async filterByRole() {
            await this.fetchUsers();
        },
        
        async filterByStatus() {
            await this.fetchUsers();
        },
        
        async fetchUsers() {
            this.loading = true;
            
            try {
                const params = new URLSearchParams();
                if (this.searchQuery) params.append('search', this.searchQuery);
                if (this.selectedRole) params.append('role', this.selectedRole);
                if (this.selectedStatus) params.append('status', this.selectedStatus);
                if (this.currentPage > 1) params.append('page', this.currentPage);
                
                const response = await fetch(`/admin/users?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.users) {
                    // Format users data to handle null values
                    this.users = data.users.data.map(user => ({
                        ...user,
                        email_verified_at: user.email_verified_at || null,
                        phone: user.phone || '',
                        profile_photo: user.profile_photo || ''
                    }));
                    this.currentPage = data.users.current_page;
                    this.lastPage = data.users.last_page;
                    this.total = data.users.total;
                    this.from = data.users.from;
                    this.to = data.users.to;
                }
            } catch (error) {
                console.error('Error fetching users:', error);
                this.showAlert('Error', 'Failed to load users', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        async previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                await this.fetchUsers();
            }
        },
        
        async nextPage() {
            if (this.currentPage < this.lastPage) {
                this.currentPage++;
                await this.fetchUsers();
            }
        },
        
        async goToPage(page) {
            this.currentPage = page;
            await this.fetchUsers();
        },
        
        async toggleUserStatus(user) {
            if (await this.confirmAction(
                user.is_active ? 'Deactivate User?' : 'Activate User?',
                user.is_active 
                    ? 'User will not be able to login until activated.'
                    : 'User will be able to login and use the system.',
                user.is_active ? 'warning' : 'info'
            )) {
                try {
                    const response = await fetch(`/admin/users/${user.id}/toggle-status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    
                    if (response.ok) {
                        user.is_active = !user.is_active;
                        this.showAlert(
                            'Success',
                            `User ${user.is_active ? 'activated' : 'deactivated'} successfully`,
                            'success'
                        );
                    } else {
                        throw new Error('Failed to update user status');
                    }
                } catch (error) {
                    this.showAlert('Error', 'Failed to update user status', 'error');
                }
            }
        },
        
        async deleteUser(user) {
            if (await this.confirmAction(
                'Delete User?',
                `Are you sure you want to delete ${user.name}? This action cannot be undone.`,
                'error',
                'Yes, delete it!',
                '#d33'
            )) {
                try {
                    const response = await fetch(`/admin/users/${user.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest', // এই header টি add করো
                            'Accept': 'application/json' // JSON response expect করছে
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        // Remove user from the list
                        this.users = this.users.filter(u => u.id !== user.id);
                        this.total--;
                        this.showAlert('Success', 'User deleted successfully', 'success');
                    } else {
                        throw new Error(data.message || 'Failed to delete user');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showAlert('Error', error.message || 'Failed to delete user', 'error');
                }
            }
        },
        
        async submitCreateForm() {
            // Basic validation
            if (this.createForm.password !== this.createForm.password_confirmation) {
                this.showAlert('Error', 'Passwords do not match', 'error');
                return;
            }
            
            if (this.createForm.password.length < 8) {
                this.showAlert('Error', 'Password must be at least 8 characters long', 'error');
                return;
            }
            
            this.creatingUser = true;
            
            try {
                const response = await fetch('/admin/users', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.createForm)
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    this.showCreateModal = false;
                    
                    // Reset form
                    this.createForm = {
                        name: '',
                        email: '',
                        role: 'job_seeker',
                        password: '',
                        password_confirmation: ''
                    };
                    
                    this.showAlert('Success', 'User created successfully', 'success');
                    
                    // Refresh the user list
                    await this.fetchUsers();
                } else {
                    let errorMessage = 'Failed to create user';
                    if (data.errors) {
                        errorMessage = Object.values(data.errors).flat().join(', ');
                    } else if (data.message) {
                        errorMessage = data.message;
                    }
                    throw new Error(errorMessage);
                }
            } catch (error) {
                this.showAlert('Error', error.message || 'Failed to create user', 'error');
            } finally {
                this.creatingUser = false;
            }
        },
        
        async confirmAction(title, text, icon, confirmText = 'Yes, proceed!', confirmColor = '#3085d6') {
            return await Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: 'Cancel',
                confirmButtonColor: confirmColor,
                cancelButtonColor: 'gray',
                reverseButtons: true
            }).then((result) => result.isConfirmed);
        },
        
        showAlert(title, text, icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timerProgressBar: true
            });
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
</style>
@endpush