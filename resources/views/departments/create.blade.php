<!-- resources/views/departments/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New Department
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Create New Department</h1>
                <a href="{{ route('departments.index') }}"
                   class="text-emerald-600 hover:text-emerald-900 hover:underline">
                    Back to Departments
                </a>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                        <input type="text"
                               name="name"
                               id="name"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('name') border-red-500 @enderror"
                               value="{{ old('name') }}"
                               required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Code</label>
                        <input type="text"
                               name="code"
                               id="code"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('code') border-red-500 @enderror"
                               value="{{ old('code') }}"
                               required>
                        @error('code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="school_id" class="block text-gray-700 text-sm font-bold mb-2">School</label>
                        <select name="school_id"
                                id="school_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('school_id') border-red-500 @enderror"
                                required>
                            <option value="">Select a School</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                    {{ $school->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('school_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description"
                                  id="description"
                                  rows="4"
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Assign Lecturers</label>
                        <div class="mt-2 max-h-48 overflow-y-auto border rounded-lg p-2">
                            @foreach($lecturers as $lecturer)
                                <div class="flex items-center mb-2">
                                    <input type="checkbox"
                                           name="lecturer_ids[]"
                                           value="{{ $lecturer->id }}"
                                           id="lecturer_{{ $lecturer->id }}"
                                           class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                           {{ in_array($lecturer->id, old('lecturer_ids', [])) ? 'checked' : '' }}>
                                    <label for="lecturer_{{ $lecturer->id }}" class="ml-2 text-gray-700">
                                        {{ $lecturer->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('lecturer_ids')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit"
                                class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition-colors duration-200">
                            Create Department
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
