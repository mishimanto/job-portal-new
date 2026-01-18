<footer class="bg-gray-900 text-white pt-16 pb-8">
    <div class="container mx-auto px-4">
        <!-- Footer Top -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <!-- About Us -->
            <div>
                <h4 class="text-2xl font-bold mb-6">About Us</h4>
                <p class="text-gray-400">{{ $siteSettings['about_us'] ?? 'Heaven frucvitful doesn\'t cover lesser days appear creeping seasons so behold.' }}</p>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-2xl font-bold mb-6">Contact Info</h4>
                <ul class="space-y-3 text-gray-400">
                    <li>
                        <p>Address: {{ $siteSettings['contact_address'] ?? 'Your address goes here, your demo address.' }}</p>
                    </li>
                    <li>
                        <a href="tel:{{ $siteSettings['contact_phone'] ?? '+888044338899' }}" class="hover:text-white">
                            Phone: {{ $siteSettings['contact_phone'] ?? '+8880 44338899' }}
                        </a>
                    </li>
                    <li>
                        <a href="mailto:{{ $siteSettings['contact_email'] ?? 'info@colorlib.com' }}" class="hover:text-white">
                            Email: {{ $siteSettings['contact_email'] ?? 'info@colorlib.com' }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Important Links -->
            <div>
                <h4 class="text-2xl font-bold mb-6">Important Link</h4>
                <ul class="space-y-3">
                    <li><a href="#" class="text-gray-400 hover:text-white">View Project</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Contact Us</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Testimonial</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Proparties</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Support</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h4 class="text-2xl font-bold mb-6">Newsletter</h4>
                <p class="text-gray-400 mb-6">Heaven fruitful doesn't over lesser in days. Appear creeping.</p>
                <form class="flex">
                    <input type="email" placeholder="Email Address" class="flex-1 px-4 py-3 rounded-l-lg text-gray-900 focus:outline-none">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 px-6 py-3 rounded-r-lg">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer Middle -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 py-8 border-t border-gray-800">
            <!-- Logo -->
            <a href="{{ url('/') }}">
                @if($siteLogo)
                    <div class="flex items-center gap-3">
                        <img 
                            src="{{ asset('storage/' . $siteLogo) }}" 
                            class="h-12 w-auto"
                            alt="Site Logo">
                    </div>
                @else
                    <span class="text-xl font-bold text-blue-600">
                        {{ $siteSettings['site_name'] ?? config('app.name') }}
                    </span>
                @endif
            </a>
            
            <!-- Stats -->
            <div>
                <div class="text-4xl font-bold text-indigo-400 mb-2">{{ $totalJobs }}</div>
                <div class="text-gray-400">Available Jobs</div>
            </div>
            
            <div>
                <div class="text-4xl font-bold text-indigo-400 mb-2">{{ $totalCompanies }}</div>
                <div class="text-gray-400">Registered Companies</div>
            </div>
            
            <div>
                <div class="text-4xl font-bold text-indigo-400 mb-2">{{ $totalApplicants }}</div>
                <div class="text-gray-400">Applicants</div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="border-t border-gray-800 pt-8 mt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 text-center md:text-left mb-4 md:mb-0">
                    <p>Copyright &copy; {{ date('Y') }} All rights reserved | 
                       <a href="{{ route('home') }}" class="text-indigo-400 hover:text-white">
                           {{ $siteSettings['site_name'] ?? config('app.name') }}
                       </a>
                    </p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-indigo-600">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-indigo-600">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-indigo-600">
                        <i class="fas fa-globe"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-indigo-600">
                        <i class="fab fa-behance"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>