<!-- Desktop sidebar -->
<div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0">
    <div class="flex flex-col flex-grow bg-gradient-to-b from-gray-700 to-gray-800 pt-5 pb-4 overflow-y-auto">
        <!-- Logo -->
        <div class="flex items-center flex-shrink-0 px-6 mb-8">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                <div>
                    <span class="text-xl mx-auto p-5 font-bold text-white">Admin Panel</span>
                </div>
            </a>
        </div>
        
        <!-- Navigation -->
        <div class="mt-2 flex-1 flex flex-col">
            <nav class="flex-1 px-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="{{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                    @if(request()->routeIs('admin.dashboard'))
                    <span class="ml-auto w-2 h-2 bg-white rounded-full"></span>
                    @endif
                </a>

                <!-- Super Admin Section (Only visible to super admins) -->
                @if(auth()->user()->isSuperAdmin())
                <div class="pt-4 pb-2 px-2">
                    <div class="flex items-center space-x-2">
                        <span class="text-xs font-semibold text-blue-300 uppercase tracking-wider">Super Admin</span>
                        <div class="flex-grow h-px bg-gray-600"></div>                        
                        <div class="flex-grow h-px bg-gray-600"></div>
                    </div>
                </div>

                <!-- Admin Management -->
                <a href="{{ route('admin.admins.index') }}" 
                   class="{{ request()->routeIs('admin.admins.*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->routeIs('admin.admins.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>

                    Manage Admins
                    @if(request()->routeIs('admin.admins.*'))
                    <span class="ml-auto w-2 h-2 bg-white rounded-full"></span>
                    @endif
                </a>

                <!-- System Logs -->
                <!-- <a href="{{ route('admin.logs.index') }}" 
                   class="{{ request()->routeIs('admin.logs.*') ? 'bg-gradient-to-r from-yellow-500 to-orange-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->routeIs('admin.logs.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    System Logs
                    @if(request()->routeIs('admin.logs.*'))
                    <span class="ml-auto w-2 h-2 bg-white rounded-full"></span>
                    @endif
                </a> -->

                <div class="pt-2 pb-4 px-2">
                    <div class="flex-grow h-px bg-gray-600"></div>
                </div>
                @endif
                <!-- End Super Admin Section -->

                <!-- Categories -->
                <a href="{{ route('admin.categories.index') }}" 
                   class="{{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg
                        class="{{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} mr-3 h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 6a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2h-3a2 2 0 01-2-2V6z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 15a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2H6a2 2 0 01-2-2v-3z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 15a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2h-3a2 2 0 01-2-2v-3z"/>
                    </svg>

                    Categories
                    @if(request()->routeIs('admin.categories.*'))
                    <span class="ml-auto w-2 h-2 bg-white rounded-full"></span>
                    @endif
                </a>
                
                <!-- Jobs -->
                <a href="{{ route('admin.jobs.index') }}" 
                   class="{{ request()->routeIs('admin.jobs.*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->routeIs('admin.jobs.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Jobs Management
                    @if(request()->routeIs('admin.jobs.*'))
                    <span class="ml-auto w-2 h-2 bg-white rounded-full"></span>
                    @endif
                </a>
                
                <!-- Applications -->
                <a href="{{ route('admin.applications.index') }}" 
                   class="{{ request()->routeIs('admin.applications.*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->routeIs('admin.applications.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Applications
                    @if(request()->routeIs('admin.applications.*'))
                    <span class="ml-auto w-2 h-2 bg-white rounded-full"></span>
                    @endif
                </a>
                
                <!-- Users -->
                <a href="{{ route('admin.users.index') }}" 
                    class="{{ request()->routeIs('admin.users.*') 
                        ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' 
                        : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} 
                        group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="{{ request()->routeIs('admin.users.*') 
                            ? 'text-white' 
                            : 'text-gray-400 group-hover:text-white' }} 
                            mr-3 h-5 w-5"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372
                                9.337 9.337 0 0 0 4.121-.952
                                4.125 4.125 0 0 0-7.533-2.493
                                M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07
                                M15 19.128v.106A12.318 12.318 0 0 1 8.624 21
                                c-2.331 0-4.512-.645-6.374-1.766l-.001-.109
                                a6.375 6.375 0 0 1 11.964-3.07
                                M12 6.375a3.375 3.375 0 1 1-6.75 0
                                3.375 3.375 0 0 1 6.75 0
                                M20.25 8.625a2.625 2.625 0 1 1-5.25 0
                                2.625 2.625 0 0 1 5.25 0" />
                    </svg>

                    Users

                    @if(request()->routeIs('admin.users.*'))
                        <span class="ml-auto w-2 h-2 bg-white rounded-full"></span>
                    @endif
                </a>

                
                <!-- Companies -->
                <!-- <a href="{{ route('admin.companies.index') }}" 
                   class="{{ request()->routeIs('admin.companies.*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->routeIs('admin.companies.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Companies
                    @if(request()->routeIs('admin.companies.*'))
                    <span class="ml-auto w-2 h-2 bg-white rounded-full"></span>
                    @endif
                </a> -->
                
                <!-- Contact Messages -->
                <a href="{{ route('admin.contact.messages') }}" 
                    class="{{ request()->routeIs('admin.contact.*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->routeIs('admin.contact.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    Contact Messages
                    
                    <!-- Unread Count Badge -->
                    @php
                        $unreadCount = \App\Models\ContactMessage::unread()->count();
                    @endphp
                    @if($unreadCount > 0)
                    <span class="ml-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
                        {{ $unreadCount }}
                    </span>
                    @endif
                    
                    @if(request()->routeIs('admin.contact.*'))
                    <span class="ml-auto w-2 h-2 bg-white rounded-full"></span>
                    @endif
                </a>

                <!-- Blogs -->
                <a href="{{ route('admin.blogs.index') }}" 
                    class="{{ request()->routeIs('admin.blogs.*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->routeIs('admin.blogs.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    Blog Management
                    @if(request()->routeIs('admin.blogs.*'))
                    <span class="ml-auto w-2 h-2 bg-white rounded-full"></span>
                    @endif
                </a>
                
                <!-- Settings -->
                <a href="{{ route('admin.settings.index') }}" 
                   class="{{ request()->routeIs('admin.settings*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <svg class="{{ request()->routeIs('admin.settings*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                    @if(request()->routeIs('admin.settings*'))
                    <span class="ml-auto w-2 h-2 bg-white rounded-full"></span>
                    @endif
                </a>
            </nav>
        </div>
        
        <!-- User Profile with Role Badge -->
        <!-- <div class="flex-shrink-0 p-4 border-t border-gray-700 mt-auto">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-md">
                        <span class="text-white font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </div>
                </div>
                <div class="ml-3 flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <div class="flex items-center space-x-2">
                        <p class="text-xs text-gray-300 truncate">{{ auth()->user()->email }}</p>
                        @if(auth()->user()->isSuperAdmin())
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500 text-white">
                            Super
                        </span>
                        @elseif(auth()->user()->isNormalAdmin())
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-blue-500 text-white">
                            Admin
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>

<!-- Mobile sidebar -->
<div x-data="{ sidebarOpen: false }" class="lg:hidden">
    <!-- Mobile menu button -->
    <div class="fixed top-0 left-0 z-40 pt-4 pl-4">
        <button @click="sidebarOpen = true" 
                class="h-10 w-10 rounded-md flex items-center justify-center bg-gray-900 text-gray-300 hover:text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 shadow-lg">
            <span class="sr-only">Open sidebar</span>
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
            </svg>
        </button>
    </div>

    <!-- Mobile sidebar -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-0 flex z-40"
         style="display: none;">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" 
             @click="sidebarOpen = false"></div>
        <div class="relative flex-1 flex flex-col max-w-xs w-full bg-gradient-to-b from-gray-900 to-gray-800">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button @click="sidebarOpen = false" 
                        class="ml-1 flex items-center justify-center h-10 w-10 rounded-full bg-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                <!-- Mobile Logo -->
                <div class="flex-shrink-0 flex items-center px-6 mb-8">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xl font-bold text-white">JobPortal</span>
                            <span class="block text-xs text-blue-300 font-medium">Admin Panel</span>
                        </div>
                    </div>
                </div>
                <!-- Mobile Navigation -->
                <nav class="mt-8 px-3 space-y-1">
                    @php
                        $mobileRoutes = [
                            'admin.dashboard' => ['route' => 'admin.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'text' => 'Dashboard'],
                            'admin.categories.*' => ['route' => 'admin.categories.index', 'icon' => 'M4 6a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2H6a2 2 0 01-2-2V6z M14 6a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2h-3a2 2 0 01-2-2V6z M4 15a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2H6a2 2 0 01-2-2v-3z M14 15a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2h-3a2 2 0 01-2-2v-3z', 'text' => 'Categories'],
                            'admin.jobs.*' => ['route' => 'admin.jobs.index', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'text' => 'Jobs Management'],
                            'admin.applications.*' => ['route' => 'admin.applications.index', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'text' => 'Applications'],
                            'admin.users.*' => ['route' => 'admin.users.index', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.667.916-1.583 1.5-2.6 1.5h-1.3c-1.02 0-1.9-.592-2.6-1.5', 'text' => 'Users'],
                            'admin.companies.*' => ['route' => 'admin.companies.index', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'text' => 'Companies'],
                            'admin.contact.*' => ['route' => 'admin.contact.messages', 'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z', 'text' => 'Contact Messages'],
                            'admin.settings*' => ['route' => 'admin.settings.index', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'text' => 'Settings'],
                        ];

                        // Add Super Admin routes if user is super admin
                        if (auth()->user()->isSuperAdmin()) {
                            $mobileRoutes = array_merge([
                                'admin.admins.*' => [
                                    'route' => 'admin.admins.index',
                                    'icon'  => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.667.916-1.583 1.5-2.6 1.5h-1.3c-1.02 0-1.9-.592-2.6-1.5',
                                    'text'  => 'Manage Admins'
                                ],

                                // 'admin.logs.*' => [
                                //     'route' => 'admin.logs.index',
                                //     'icon'  => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                                //     'text'  => 'System Logs'
                                // ],

                            ], $mobileRoutes);
                        }

                    @endphp

                    @foreach($mobileRoutes as $routePattern => $item)
                    <a href="{{ route($item['route']) }}" 
                       class="{{ request()->routeIs($routePattern) ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} group flex items-center px-4 py-3 text-base font-medium rounded-xl">
                        <svg class="{{ request()->routeIs($routePattern) ? 'text-white' : 'text-gray-400 group-hover:text-white' }} mr-4 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                        </svg>
                        {{ $item['text'] }}
                        @if(request()->routeIs($routePattern))
                        <span class="ml-auto w-2 h-2 bg-white rounded-full"></span>
                        @endif
                    </a>
                    @endforeach
                </nav>
            </div>
            <!-- Mobile User Profile with Role Badge -->
            <!-- <div class="flex-shrink-0 p-4 border-t border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                            <span class="text-white font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-base font-medium text-white">{{ auth()->user()->name }}</p>
                        <div class="flex items-center space-x-2">
                            <p class="text-sm text-gray-300">{{ auth()->user()->email }}</p>
                            @if(auth()->user()->isSuperAdmin())
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500 text-white">
                                Super
                            </span>
                            @elseif(auth()->user()->isNormalAdmin())
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-blue-500 text-white">
                                Admin
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="flex-shrink-0 w-14"></div>
    </div>
</div>