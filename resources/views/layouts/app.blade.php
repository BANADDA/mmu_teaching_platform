<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'MMU Teaching Platform') }}</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100" x-data="{ sidebarOpen: false }">
  <!-- Main Container -->
  <div class="min-h-screen relative lg:flex">
    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-900/50 lg:hidden z-20"
         @click="sidebarOpen = false">
    </div>

    <!-- Sidebar -->
    <div x-show="true"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         :class="{'translate-x-0': sidebarOpen, '-translate-x-full lg:translate-x-0': !sidebarOpen}"
         class="fixed inset-y-0 left-0 z-30 w-64 bg-emerald-800 h-screen overflow-y-hidden transform transition-transform duration-300 ease-in-out lg:inset-0">
      <!-- Sidebar Flex Container -->
      <div class="flex flex-col h-full">
        <!-- Top Section (Logo & Navigation) -->
        <div>
          <!-- Logo Section -->
          <div class="flex items-center justify-center h-16 bg-emerald-900">
            <span class="text-white text-2xl font-bold">MMU Platform</span>
          </div>
          <!-- Navigation Menu -->
          <nav class="mt-6 px-3 space-y-3">
            <!-- Common Dashboard for All Users -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-4 py-2 text-gray-100 rounded-lg hover:bg-emerald-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-emerald-700' : '' }}">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l4 4m-4-4v10a1 1 0 01-1 1h-3"></path>
              </svg>
              <span>Dashboard</span>
            </a>

            <!-- Admin Section (for Admins and Super Admins) -->
            @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
              <div class="pt-4">
                <span class="px-4 text-xs font-semibold text-gray-300 uppercase tracking-wider">
                  Administration
                </span>
                <div class="mt-3 space-y-3">
                  <a href="{{ route('schools.index') }}"
                     class="flex items-center px-4 py-2 text-gray-100 rounded-lg hover:bg-emerald-700 transition-colors {{ request()->routeIs('schools.*') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5"></path>
                    </svg>
                    <span>Schools</span>
                  </a>

                  <a href="{{ route('departments.index') }}"
                     class="flex items-center px-4 py-2 text-gray-100 rounded-lg hover:bg-emerald-700 transition-colors {{ request()->routeIs('departments.*') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11a4 4 0 100-8 4 4 0 000 8z"></path>
                    </svg>
                    <span>Departments</span>
                  </a>

                  <a href="{{ route('lectures.index') }}"
                     class="flex items-center px-4 py-2 text-gray-100 rounded-lg hover:bg-emerald-700 transition-colors {{ request()->routeIs('lectures.*') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7"></path>
                    </svg>
                    <span>Lecturers</span>
                  </a>

                  <a href="{{ route('materials.index') }}"
                     class="flex items-center px-4 py-2 text-gray-100 rounded-lg hover:bg-emerald-700 transition-colors {{ request()->routeIs('materials.*') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Course Materials</span>
                  </a>

                  <a href="{{ route('schedules.index') }}"
                     class="flex items-center px-4 py-2 text-gray-100 rounded-lg hover:bg-emerald-700 transition-colors {{ request()->routeIs('schedules.*') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Schedules</span>
                  </a>
                </div>
              </div>
            <!-- Teaching Section (for Lecturers) -->
            @elseif(auth()->user()->isLecturer())
              <div class="pt-4">
                <span class="px-4 text-xs font-semibold text-gray-300 uppercase tracking-wider">
                  Teaching
                </span>
                <div class="mt-3 space-y-3">
                  <a href="{{ route('my-departments.index') }}"
                     class="flex items-center px-4 py-2 text-gray-100 rounded-lg hover:bg-emerald-700 transition-colors {{ request()->routeIs('my-departments.*') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11a4 4 0 100-8 4 4 0 000 8z"></path>
                    </svg>
                    <span>My Departments</span>
                  </a>

                  <a href="{{ route('my-lectures.index') }}"
                     class="flex items-center px-4 py-2 text-gray-100 rounded-lg hover:bg-emerald-700 transition-colors {{ request()->routeIs('my-lectures.*') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"></path>
                    </svg>
                    <span>My Lectures</span>
                  </a>

                  <a href="{{ route('materials.index') }}"
                     class="flex items-center px-4 py-2 text-gray-100 rounded-lg hover:bg-emerald-700 transition-colors {{ request()->routeIs('materials.*') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Course Materials</span>
                  </a>

                  <a href="{{ route('schedules.index') }}"
                     class="flex items-center px-4 py-2 text-gray-100 rounded-lg hover:bg-emerald-700 transition-colors {{ request()->routeIs('schedules.*') ? 'bg-emerald-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Schedules</span>
                  </a>
                </div>
              </div>
            @endif
          </nav>
        </div>

        <!-- Bottom Section: Account Actions -->
        <div class="mt-auto border-t border-emerald-700 px-3 py-4">
          <span class="block px-4 text-xs font-semibold text-gray-300 uppercase tracking-wider">
            Account
          </span>
          <div class="mt-3 space-y-3">
            <!-- Profile Link -->
            <a href="{{ route('profile.show') }}"
               class="flex items-center px-4 py-2 text-gray-100 rounded-lg hover:bg-emerald-700 transition-colors {{ request()->routeIs('profile.*') ? 'bg-emerald-700' : '' }}">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              <span>My Profile</span>
            </a>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit"
                      class="w-full flex items-center px-4 py-2 text-gray-100 rounded-lg hover:bg-emerald-700 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Sign Out</span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 overflow-y-auto relative lg:ml-64">
      <!-- Fixed Top Navbar -->
      <div class="fixed top-0 left-0 right-0 lg:left-64 z-10">
        <div class="bg-white shadow-sm">
          <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
            <!-- Mobile Menu Button -->
            <button @click="sidebarOpen = !sidebarOpen"
                    class="text-gray-500 hover:text-gray-600 lg:hidden focus:outline-none focus:ring-2 focus:ring-inset focus:ring-emerald-500">
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>

            <!-- Page Title -->
            @if (isset($header))
              <div class="flex-1 px-4">
                {{ $header }}
              </div>
            @endif

            <!-- User Menu -->
            <div class="flex items-center">
              <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center text-sm text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                  <span class="mr-2">{{ auth()->user()->name }}</span>
                  <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open"
                     @click.away="open = false"
                     class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5"
                     role="menu">
                  <a href="{{ route('profile.show') }}"
                     class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Profile
                  </a>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                      Sign Out
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Scrollable Content (with top padding equal to the navbar height) -->
      <div class="pt-16">
        <main class="p-6">
          <div class="max-w-7xl mx-auto">
            {{ $slot }}
          </div>
        </main>
      </div>
    </div>
  </div>

  <!-- Notifications -->
  <div x-data="{ notifications: [] }"
       class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-50">
    <template x-for="(notification, index) in notifications" :key="index">
      <div x-show="notification.show"
           x-transition:enter="transform ease-out duration-300 transition"
           x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
           x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
           x-transition:leave="transition ease-in duration-100"
           x-transition:leave-start="opacity-100"
           x-transition:leave-end="opacity-0"
           class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
        <div class="p-4">
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <svg x-show="notification.type === 'success'"
                   class="h-6 w-6 text-green-400"
                   fill="none"
                   viewBox="0 0 24 24"
                   stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <svg x-show="notification.type === 'error'"
                   class="h-6 w-6 text-red-400"
                   fill="none"
                   viewBox="0 0 24 24"
                   stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
              <p x-text="notification.message" class="text-sm font-medium text-gray-900"></p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
              <button @click="notification.show = false"
                      class="inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>

  @stack('modals')
  @livewireScripts
</body>
</html>
