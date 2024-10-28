@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6">Companies List</h1>

        <div class="overflow-x-auto">
            <table class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 uppercase text-sm leading-normal">
                    <th class="px-6 py-3 text-left font-semibold">Company Name</th>
                    <th class="px-6 py-3 text-left font-semibold">Owner</th>
                    <th class="px-6 py-3 text-left font-semibold">Assigned Users</th>
                    <th class="px-6 py-3 text-left font-semibold">Active</th>
                    <th class="px-6 py-3 text-left font-semibold">Actions</th>
                </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-300 text-sm font-light">
                @foreach($companies as $company)
                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
                        <!-- Company Name -->
                        <td class="px-6 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $company->name }}</td>

                        <!-- Company Owner -->
                        <td class="px-6 py-3">{{ $company->owner->username }}</td>

                        <!-- Assigned Users (excluding owner) -->
                        <td class="px-6 py-3">
                            @foreach($company->employers() as $user)
                                <span class="inline-block bg-gray-200 dark:bg-gray-600 text-xs px-2 py-1 rounded-lg text-gray-900 dark:text-gray-100">{{ $user->username }}</span>
                            @endforeach
                        </td>

                        <!-- Active Status -->
                        <td class="px-6 py-3">
                            @if($company->is_active)
                                <span class="text-green-600 font-bold">Active</span>
                            @else
                                <span class="text-red-500 font-bold">Inactive</span>
                            @endif
                        </td>

                        <!-- Actions (Edit, View, Delete) -->
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.company.edit', $company->id) }}" class="text-blue-500 hover:underline">Assign User</a> |
                            <a href="{{ route('admin.company.edit', $company->id) }}" class="text-blue-500 hover:underline">Edit</a> |
                            <a href="{{ route('admin.company.show', $company->slug) }}" class="text-blue-500 hover:underline">View</a> |
                            <form action="{{ route('admin.company.destroy', $company->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
