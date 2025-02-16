<!-- resources/views/schools/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            School Details
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800">{{ $school->name }}</h1>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('schools.edit', $school) }}"
                       class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors duration-200">
                        Edit School
                    </a>
                    <a href="{{ route('schools.index') }}"
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        Back to Schools
                    </a>
                </div>
            </div>
            <p class="text-gray-600 mt-2">Code: {{ $school->code }}</p>
        </div>

        <!-- School Information -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">School Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold text-gray-600">Description</h3>
                    <p class="mt-1">{{ $school->description ?: 'No description available' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-600">Statistics</h3>
                    <ul class="mt-1 space-y-2">
                        <li>Total Departments: {{ $school->departments_count }}</li>
                        <li>Total Lecturers: {{ $school->lecturers_count }}</li>
                        <li>Created: {{ $school->created_at->format('M d, Y') }}</li>
                        <li>Last Updated: {{ $school->updated_at->format('M d, Y') }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Departments List -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Departments</h2>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('departments.create', ['school_id' => $school->id]) }}"
                       class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition-colors duration-200">
                        Add Department
                    </a>
                @endif
            </div>

            @if($school->departments->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($school->departments as $department)
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">{{ $department->name }}</h3>
                            <p class="text-gray-600 text-sm mb-2">Code: {{ $department->code }}</p>
                            <p class="text-gray-600 text-sm">Lecturers: {{ $department->users_count }}</p>
                            <div class="mt-3">
                                <a href="{{ route('departments.show', $department) }}"
                                   class="text-emerald-600 hover:text-emerald-800 text-sm">
                                    View Details &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">No departments have been added to this school yet.</p>
            @endif

            @if($school->departments->count() > 0)
                <div class="mt-4 border-t pt-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Quick Stats</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-2xl font-bold text-emerald-600">{{ $school->departments_count }}</div>
                            <div class="text-gray-600">Total Departments</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-2xl font-bold text-emerald-600">{{ $school->lecturers_count }}</div>
                            <div class="text-gray-600">Total Lecturers</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-2xl font-bold text-emerald-600">
                                {{ $school->departments->sum('lectures_count') }}
                            </div>
                            <div class="text-gray-600">Total Lectures</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
