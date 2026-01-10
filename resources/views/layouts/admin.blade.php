<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'JobPortal Admin')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Mobile sidebar backdrop -->
        <div x-data="{ sidebarOpen: false }">
            <!-- Mobile sidebar overlay -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-40 lg:hidden"
                 style="display: none;">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75" 
                     @click="sidebarOpen = false"></div>
            </div>
        </div>

        <!-- Include Sidebar -->
        @include('layouts.admin.sidebar')
        
        <div class="flex-1 flex flex-col lg:pl-64">
            <!-- Include Header -->
            @include('layouts.admin.header')
            
            <!-- Main Content -->
            <main class="flex-1">
                <!-- Page Content -->
                <div class="mx-auto p-4">
                    @if(session('success'))
                    <div 
                        x-data="{ show: true }"
                        x-init="setTimeout(() => show = false, 5000)"
                        x-show="show"
                        x-transition
                        class="mb-6 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-4 shadow-sm"
                    >
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100">
                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>

                        <div>
                            <p class="mt-1 text-md text-green-700">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                    @endif


                    @if(session('error'))
                    <div 
                        x-data="{ show: true }"
                        x-init="setTimeout(() => show = false, 5000)"
                        x-show="show"
                        x-transition
                        class="mb-6 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 p-4 shadow-sm"
                    >
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100">
                            <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>

                        <div>
        
                            <p class="mt-1 text-md text-red-700">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                    @endif


                    @if($errors->any())
                    <div 
                        x-data="{ show: true }"
                        x-init="setTimeout(() => show = false, 5000)"
                        x-show="show"
                        x-transition
                        class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 shadow-sm"
                    >
                        <div class="flex items-start gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100">
                                <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16z" clip-rule="evenodd"/>
                                </svg>
                            </div>

                            <div>   
                                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif


                    @yield('content')
                </div>
            </main>
            
            <!-- Include Footer -->
            @include('layouts.admin.footer')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>
</html>