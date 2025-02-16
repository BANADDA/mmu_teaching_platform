<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MMU Teaching Platform') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="antialiased" x-data="{ showLoginModal: false }">
    <!-- Top Bar -->
    <div class="bg-emerald-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-2">
                <!-- Contact Information (Left Side) -->
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        <span class="text-sm">Call UG: (256) 775 679505</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        <span class="text-sm">E-mail: samuel.ocen@mmu.ac.ug</span>
                    </div>
                </div>

                <!-- Platform Name (Right Side) -->
                <div class="text-lg font-semibold tracking-wide">
                    MMU Teaching Platform
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="relative min-h-[calc(100vh-40px)]">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('images/graduation.jpg') }}" alt="MMU Campus" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/50"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[calc(100vh-40px)] flex items-center">
            <div class="text-white max-w-3xl">
                <div class="mb-4">
                    <h2 class="text-emerald-400 text-xl font-semibold mb-2">Mountains of the Moon University</h2>
                    <h1 class="text-5xl sm:text-6xl font-bold mb-6">
                        Digital Learning Platform
                    </h1>
                </div>

                <p class="text-xl sm:text-2xl mb-6 leading-relaxed text-gray-200">
                    Empowering education through technology at Mountains of the Moon University
                </p>

                <div class="bg-black/30 backdrop-blur-sm rounded-xl p-6 mb-8">
                    <ul class="text-lg space-y-4">
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400 flex-shrink-0 mt-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Access comprehensive course materials, lecture notes, and resources tailored to MMU's curriculum</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400 flex-shrink-0 mt-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Engage in virtual classrooms with interactive discussions and real-time collaboration tools</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400 flex-shrink-0 mt-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Track assignments, grades, and academic progress with our integrated management system</span>
                        </li>
                    </ul>
                </div>

                <div class="flex gap-4">
                    <button
                        @click="showLoginModal = true"
                        class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-8 py-4 rounded-lg transition-colors text-lg">
                        Staff Login
                    </button>
                    <a href="#learn-more"
                       class="inline-block border-2 border-white hover:bg-white/10 text-white font-semibold px-8 py-4 rounded-lg transition-colors text-lg">
                        Learn More
                    </a>
                </div>
            </div>
        </div>

        <!-- Login Modal -->
        <div x-show="showLoginModal"
             class="fixed inset-0 z-50 overflow-y-auto"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-black/50 transition-opacity" @click="showLoginModal = false"></div>

                <!-- Modal Content -->
                <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6 transform transition-all"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     @click.outside="showLoginModal = false">

                    <div class="absolute right-4 top-4">
                        <button @click="showLoginModal = false" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Login Form -->
                    <form class="space-y-6" action="{{ route('login') }}" method="POST">
                        @csrf

                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-emerald-600">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mb-4 p-4 rounded-md bg-red-50 border border-red-300">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul class="list-disc pl-5 space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="text-center">
                            <h2 class="text-2xl font-bold text-gray-900">Staff Login</h2>
                            <p class="mt-2 text-sm text-gray-600">Access your teaching dashboard</p>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Staff Email</label>
                            <input type="email" name="email" id="email" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" id="remember-me" name="remember"
                                    class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                            </div>

                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-emerald-600 hover:text-emerald-500">
                                    Forgot password?
                                </a>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                Sign in
                            </button>
                        </div>

                        <div class="mt-4 text-center text-sm text-gray-600">
                            <span>Don't have an account?</span>
                            <a href="{{ route('register') }}" class="font-medium text-emerald-600 hover:text-emerald-500">
                                Register as Lecturer
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Learn More Section -->
    <!-- Learn More Section -->
    <div id="learn-more" class="relative bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">About Our Platform</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                    Learn how our digital platform transforms teaching and learning at MMU
                </p>
            </div>

            <!-- Feature Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1: Course Management -->
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Course Management</h3>
                    <p class="text-gray-600">Efficiently organize and manage your course content, materials, and resources in one centralized location.</p>
                </div>

                <!-- Feature 2: Virtual Classrooms -->
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Virtual Classrooms</h3>
                    <p class="text-gray-600">Conduct interactive online classes with real-time discussions, screen sharing, and collaborative tools.</p>
                </div>

                <!-- Feature 3: Progress Tracking -->
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Progress Tracking</h3>
                    <p class="text-gray-600">Monitor student engagement, track assignment submissions, and manage grades efficiently.</p>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="mt-16 bg-emerald-50 rounded-2xl p-8">
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Need Help Getting Started?</h3>
                    <p class="text-gray-600 mb-6">Our support team is here to help you make the most of our platform</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="mailto:support@mmu.ac.ug" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700">
                            Contact Support
                        </a>
                        <a href="#" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-emerald-700 bg-emerald-100 hover:bg-emerald-200">
                            View Documentation
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>(256) 775 679505</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>samuel.ocen@mmu.ac.ug</span>
                        </li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">About MMU</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Academic Programs</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Staff Portal</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Help Center</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Mountains of the Moon University. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
