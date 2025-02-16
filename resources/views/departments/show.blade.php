<!-- resources/views/departments/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Department Details
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800">{{ $department->name }}</h1>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('departments.edit', $department) }}"
                       class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors duration-200">
                        Edit Department
                    </a>
                    <a href="{{ route('departments.index') }}"
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        Back to Departments
                    </a>
                </div>
            </div>
            <div class="text-gray-600 mt-2">
                <span class="mr-4">Code: {{ $department->code }}</span>
                <span>School: {{ $department->school->name }}</span>
            </div>
        </div>

        <!-- Department Information -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Department Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold text-gray-600">Description</h3>
                    <p class="mt-1">{{ $department->description ?: 'No description available' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-600">Statistics</h3>
                    <ul class="mt-1 space-y-2">
                        <li>Total Lecturers: {{ $department->users->count() }}</li>
                        <li>Total Lectures: {{ $department->lectures->count() }}</li>
                        <li>Created: {{ $department->created_at->format('M d, Y') }}</li>
                        <li>Last Updated: {{ $department->updated_at->format('M d, Y') }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Lecturers List -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Assigned Lecturers</h2>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('departments.edit', $department) }}"
                       class="text-emerald-600 hover:text-emerald-700 hover:underline">
                        Manage Lecturers
                    </a>
                @endif
            </div>

            @if($department->users->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($department->users as $lecturer)
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                            <h3 class="font-semibold text-lg text-gray-800">{{ $lecturer->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $lecturer->email }}</p>
                            @if($lecturer->lectures->count() > 0)
                                <p class="text-gray-600 text-sm mt-2">
                                    Lectures: {{ $lecturer->lectures->count() }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">No lecturers have been assigned to this department yet.</p>
            @endif
        </div>

        <!-- Lectures List -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Department Lectures</h2>
                @if(auth()->user()->isAdmin() || auth()->user()->isLecturer())
                    <a href="{{ route('lectures.create', ['department_id' => $department->id]) }}"
                       class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition-colors duration-200">
                        Add New Lecture
                    </a>
                @endif
            </div>

            @if($department->lectures->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lecturer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materials</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($department->lectures as $lecture)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $lecture->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $lecture->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $lecture->materials_count ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('lectures.show', $lecture) }}"
                                           class="text-emerald-600 hover:text-emerald-900 hover:underline mr-3">
                                            View
                                        </a>
                                        @if(auth()->user()->isAdmin() || auth()->id() === $lecture->user_id)
                                            <a href="{{ route('lectures.edit', $lecture) }}"
                                               class="text-yellow-600 hover:text-yellow-900 hover:underline">
                                                Edit
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600">No lectures have been added to this department yet.</p>
            @endif
        </div>
    </div>
</x-app-layout>
