<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
      </h2>
    </x-slot>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
          <!-- ADMIN DASHBOARD -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Stats Column -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- Schools Stat -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center">
                  <div class="p-3 rounded-full bg-emerald-500 bg-opacity-75">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4v13a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                    </svg>
                  </div>
                  <div class="ml-5">
                    <h3 class="text-lg font-semibold text-gray-900">Schools</h3>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $schoolsCount ?? 0 }}</div>
                  </div>
                </div>
              </div>

              <!-- Departments Stat -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center">
                  <div class="p-3 rounded-full bg-blue-500 bg-opacity-75">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11a4 4 0 100-8 4 4 0 000 8z" />
                    </svg>
                  </div>
                  <div class="ml-5">
                    <h3 class="text-lg font-semibold text-gray-900">Departments</h3>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $departmentsCount ?? 0 }}</div>
                  </div>
                </div>
              </div>

              <!-- Lectures Stat -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center">
                  <div class="p-3 rounded-full bg-purple-500 bg-opacity-75">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m0-12l4 4m-4-4l-4 4" />
                    </svg>
                  </div>
                  <div class="ml-5">
                    <h3 class="text-lg font-semibold text-gray-900">Lectures</h3>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $lecturesCount ?? 0 }}</div>
                  </div>
                </div>
              </div>

              <!-- Materials Stat -->
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center">
                  <div class="p-3 rounded-full bg-indigo-500 bg-opacity-75">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                    </svg>
                  </div>
                  <div class="ml-5">
                    <h3 class="text-lg font-semibold text-gray-900">Materials</h3>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $materialsCount ?? 0 }}</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Calendar Column (All Schedules) -->
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Calendar (All Schedules)</h3>
              <div id="calendar"></div>
            </div>
          </div>

          <!-- Quick Actions Section for Admin -->
          <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
              <div class="space-y-3">
                <a href="{{ route('lectures.create') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                  <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                  Create New Lecture
                </a>
                <a href="{{ route('materials.create') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                  <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                  Upload Course Material
                </a>
                <a href="{{ route('schedules.create') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                  <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                  Schedule New Session
                </a>
              </div>
            </div>

            <div class="bg-white shadow-xl sm:rounded-lg p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
              <div class="border rounded-lg divide-y">
                <div class="p-4 text-gray-500 text-center">
                  No recent activity
                </div>
              </div>
            </div>
          </div>

        @elseif(auth()->user()->isLecturer())
          <!-- LECTURER DASHBOARD -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Stats Column -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- My Lectures Stat -->
              <div class="bg-white shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center">
                  <div class="p-3 rounded-full bg-emerald-500 bg-opacity-75">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m0-12l4 4m-4-4l-4 4" />
                    </svg>
                  </div>
                  <div class="ml-5">
                    <h3 class="text-lg font-semibold text-gray-900">My Lectures</h3>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $myLecturesCount ?? 0 }}</div>
                  </div>
                </div>
              </div>

              <!-- Materials Stat -->
              <div class="bg-white shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center">
                  <div class="p-3 rounded-full bg-blue-500 bg-opacity-75">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                    </svg>
                  </div>
                  <div class="ml-5">
                    <h3 class="text-lg font-semibold text-gray-900">Materials</h3>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $materialsCount ?? 0 }}</div>
                  </div>
                </div>
              </div>

              <!-- Upcoming Sessions Stat -->
              <div class="bg-white shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center">
                  <div class="p-3 rounded-full bg-purple-500 bg-opacity-75">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10" />
                    </svg>
                  </div>
                  <div class="ml-5">
                    <h3 class="text-lg font-semibold text-gray-900">Upcoming Sessions</h3>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $upcomingCount ?? 0 }}</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Calendar Column (My Schedules) -->
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">My Schedule Calendar</h3>
              <div id="calendar"></div>
            </div>
          </div>

          <!-- Quick Actions for Lecturer -->
          <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
              <div class="space-y-3">
                <a href="{{ route('my-lectures.create') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                  <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                  Create New Lecture
                </a>
                <a href="{{ route('materials.create') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                  <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                  Upload Course Material
                </a>
                <a href="{{ route('schedules.create') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                  <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                  Schedule New Session
                </a>
              </div>
            </div>

            <div class="bg-white shadow-xl sm:rounded-lg p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
              <div class="border rounded-lg divide-y">
                <div class="p-4 text-gray-500 text-center">
                  No recent activity
                </div>
              </div>
            </div>
          </div>
        @endif

        <!-- Common Notifications Section -->
        <div class="mt-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Notifications</h3>
          <div class="bg-white shadow-xl sm:rounded-lg p-6">
            <div class="text-gray-500 text-center">
              No notifications
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Include FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        if(calendarEl) {
          var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: {!! $calendarEvents ?? '[]' !!}
          });
          calendar.render();
        }
      });
    </script>

    @stack('modals')
    @livewireScripts
  </x-app-layout>
