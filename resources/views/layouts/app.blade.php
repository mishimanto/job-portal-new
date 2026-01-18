<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ mobileMenuOpen: false, userMenuOpen: false }" x-cloak>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'JobPortal')) - Job Portal</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom CSS -->
    <style>
        [x-cloak] { display: none !important; }
        
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .preloader-circle {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #4f46e5;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Custom styles for testimonials */
        .testimonial-slider .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: #c7d2fe;
            opacity: 1;
        }
        
        .testimonial-slider .swiper-pagination-bullet-active {
            background: #4f46e5;
        }
        
        /* Hero section overlay */
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(79, 70, 229, 0.3), rgba(79, 70, 229, 0.1));
        }
    </style>

    @stack('styles')
</head>

<body class="antialiased bg-gray-50">
    <!-- Preloader -->
    <div id="preloader" class="preloader">
        <div class="preloader-inner">
            <div class="preloader-circle"></div>
        </div>
    </div>

    <!-- Navigation -->
    @include('partials.navigation')

    <!-- Page Content -->
    <main class="min-h-screen">
        <div class="">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div 
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 5000)"
                    x-show="show"
                    x-transition
                    class="bg-green-50 border-l-4 border-green-500 p-4 mt-6 rounded-r mx-auto max-w-7xl"
                >
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div 
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 5000)"
                    x-show="show"
                    x-transition
                    class="bg-red-50 border-l-4 border-red-500 p-4 mt-6 rounded-r mx-auto max-w-7xl"
                >
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div 
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 5000)"
                    x-show="show"
                    x-transition
                    class="bg-red-50 border-l-4 border-red-500 p-4 mt-6 rounded-r mx-auto max-w-7xl"
                >
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <ul class="text-red-600 list-disc list-inside text-sm">
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

    <!-- Footer -->
    @include('partials.footer')

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <!-- Main Script -->
    <script>
        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                setTimeout(() => {
                    preloader.style.opacity = '0';
                    preloader.style.visibility = 'hidden';
                    setTimeout(() => {
                        preloader.style.display = 'none';
                    }, 500);
                }, 500);
            }
        });

        // Initialize Swiper for testimonials
        // document.addEventListener('DOMContentLoaded', function() {
        //     // Testimonial Slider
        //     const testimonialSwiper = new Swiper('.testimonial-slider', {
        //         loop: true,
        //         autoplay: {
        //             delay: 5000,
        //             disableOnInteraction: false,
        //         },
        //         pagination: {
        //             el: '.swiper-pagination',
        //             clickable: true,
        //         },
        //         spaceBetween: 30,
        //         slidesPerView: 1,
        //         effect: 'fade',
        //         fadeEffect: {
        //             crossFade: true
        //         },
        //     });
        // });
    </script>

    @stack('scripts')
</body>
</html>