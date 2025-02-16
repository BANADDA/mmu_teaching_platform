<!-- resources/views/schools/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New School
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Create New School</h1>
                <a href="{{ route('schools.index') }}"
                   class="text-emerald-600 hover:text-emerald-900">Back to Schools</a>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('schools.store') }}" method="POST">
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
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description"
                                  id="description"
                                  rows="4"
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit"
                                class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition-colors duration-200">
                            Create School
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
