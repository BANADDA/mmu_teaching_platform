@extends('layouts.app')

@section('header')
  <h2 class="font-semibold text-xl text-gray-800 leading-tight">
    Lectures
  </h2>
@endsection

@section('content')
<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-6 bg-white border-b border-gray-200">
        <div class="mb-4">
          <a href="{{ route('lectures.create') }}"
             class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded">
            Create Lecture
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Name
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Code
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Department
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @forelse ($lectures as $lecture)
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap">
                    {{ $lecture->name }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    {{ $lecture->code }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    {{ $lecture->department->name ?? 'N/A' }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <a href="{{ route('lectures.show', $lecture) }}" class="text-emerald-600 hover:text-emerald-900">
                      View
                    </a>
                    <a href="{{ route('lectures.edit', $lecture) }}" class="ml-4 text-indigo-600 hover:text-indigo-900">
                      Edit
                    </a>
                    <form action="{{ route('lectures.destroy', $lecture) }}" method="POST" class="inline-block ml-4">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this lecture?')">
                        Delete
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                    No lectures found.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
