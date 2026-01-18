<header class="sticky top-0 z-50 bg-white shadow-sm" x-data="{ openUser:false }">
    <nav class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-20">

            <!-- Logo -->
            <a href="{{ url('/') }}">
                @if($siteLogo)
                    <div class="flex items-center gap-3">
                        <img 
                            src="{{ asset('storage/' . $siteLogo) }}" 
                            class="h-10 w-auto"
                            alt="Site Logo">

                        <!-- <span class="text-xl font-bold text-blue-600">
                            {{ config('app.name') }}
                        </span> -->
                    </div>

                @else
                    <span class="text-xl font-bold text-blue-600">
                        {{ config('app.name') }}
                    </span>
                @endif
            </a>


            <!-- Desktop Menu -->
            <ul class="hidden lg:flex items-center gap-10 text-[15px] font-medium text-gray-800">
                <li><a href="{{ url('/') }}" class="hover:text-blue-600 transition">Home</a></li>
                <li><a href="{{ route('jobs.index') }}" class="hover:text-blue-600 transition">Find Jobs</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-blue-600 transition">About</a></li>

                <!-- Dropdown -->
                <!-- <li class="relative group">
                    <button class="flex items-center gap-1 hover:text-blue-600 transition">
                        Pages
                        <svg class="w-4 h-4 mt-[2px]" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <ul class="absolute top-full left-0 mt-4 w-48 bg-white shadow-lg py-2 
                               opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                        <li><a href="#" class="block px-5 py-2 hover:bg-blue-50">Blog</a></li>
                        <li><a href="#" class="block px-5 py-2 hover:bg-blue-50">Job Details</a></li>
                    </ul>
                </li> -->

                <li><a href="{{ route('contact') }}" class="hover:text-blue-600 transition">Contact</a></li>
            </ul>

            <!-- Right Side -->
            <div class="hidden lg:flex items-center gap-4">

                @auth
                <!-- User Dropdown -->
                <div class="relative">
                    <button @click="openUser = !openUser"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg border border-blue-600 text-blue-600 font-medium">
                        
                        @php
                            $user = auth()->user();
                        @endphp

                        @if($user && $user->profile_photo)
                            <img 
                                src="{{ asset('storage/' . $user->profile_photo) }}"
                                alt="{{ $user->name }}"
                                class="w-8 h-8 rounded-full object-cover border border-gray-300">
                        @else
                            <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif


                        <span class="max-w-[150px] truncate inline-block align-middle">
                            {{ auth()->user()->name }}
                        </span>


                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="openUser" @click.outside="openUser=false" x-transition
                         class="absolute right-0 mt-3 w-52 bg-white shadow-lg border border-gray-100">
                        
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                               class="block px-5 py-3 hover:bg-blue-50">
                                Admin Dashboard
                            </a>
                        @else
                            <a href="{{ route('job-seeker.dashboard') }}"
                               class="block px-5 py-3 hover:bg-blue-50">
                                Dashboard
                            </a>
                            <a href="{{ route('job-seeker.professional-profile.edit') }}"
                               class="block px-5 py-3 hover:bg-blue-50">
                                My Profile
                            </a>
                            <a href="{{ route('profile.edit') }}"
                               class="block px-5 py-3 hover:bg-blue-50">
                                Privacy Settings
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class=" text-red-500 w-full text-left px-5 py-3 hover:bg-blue-50">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <!-- Register -->
                <a href="{{ route('register') }}"
                   class="px-8 py-2.5 bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                    Register
                </a>

                <!-- Login Slide Hover -->
                <a href="{{ route('login') }}"
                   class="relative px-8 py-2.5 border-2 border-blue-600 text-blue-600 font-semibold overflow-hidden group">

                    <span class="relative z-10 group-hover:text-white transition">
                        Login
                    </span>

                    <span class="absolute inset-0 bg-blue-600 
                                 translate-x-[-100%] group-hover:translate-x-0
                                 transition-transform duration-300 ease-out">
                    </span>
                </a>
                @endauth
            </div>

            <!-- Mobile Toggle -->
            <button class="lg:hidden">
                <svg class="w-7 h-7 text-gray-800" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </nav>
</header>
