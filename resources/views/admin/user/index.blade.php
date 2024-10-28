@extends('layouts.base')

@section('content')

    <div class="container mx-auto p-4">
        @include('admin.' . $model . '.component.header', ['page_title' => $page_title, 'isSearched' => $isSearched, 'model' => $model, 'searchableColumns' => $searchableColumns])
        @include('admin.' . $model . '.component.table-header', ['model' => $model, 'totalItems' => $totalItems])

        <!-- Parent Container for Table and Pagination -->
        <div class="flex flex-col"> <!-- Ensure full height with h-screen or a specific height -->
            <!-- Table Container with Independent Scrolling -->
            <div class="flex-grow overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead
                            class="text-xs text-gray-200 dark:text-gray-200 uppercase dark:bg-gray-800 bg-blue-600 whitespace-nowrap">
                    <tr>
                        <th scope="col" class="px-6 py-3">@lang('admin.id')</th>
                        <th scope="col" class="px-6 py-3">@lang('admin.username')</th>
                        <th scope="col" class="px-6 py-3">@lang('admin.role_name')</th>
                        <th scope="col" class="px-6 py-3">@lang('admin.email')</th>
                        <th scope="col" class="px-6 py-3">@lang('admin.referred_by')</th>
                        <th scope="col" class="px-6 py-3">@lang('admin.is_active')</th>
                        <th scope="col" class="px-6 py-3">@lang('admin.created_at')</th>
                        <th scope="col" class="px-6 py-3">@lang('admin.actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datas as $data)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-300">
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ $data->id }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ $data->username }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                {{$data->getRoleNames()->first() ?? "Member (No Role)"}}
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ $data->email }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ $data->referred_by }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('admin.' . $model . '.is_active', ['id' => $data->id]) }}"
                                       class="relative inline-block w-12 h-6 focus:outline-none transition duration-300 ease-in-out rounded-full {{ $data->is_active ? 'bg-green-500' : 'bg-gray-300' }}">
        <span
                class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full shadow transition-transform duration-300 ease-in-out"
                style="transform: translateX({{ $data->is_active ? '1.5rem' : '0' }});"></span>
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ $data->created_at }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">@include('admin.'.$model.'.component.table-button', ['model' => $model, 'data' => $data])</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if(count($datas) < 1)
                @include('admin.' . $model . '.component.nodata')
            @endif
            {{ $datas->links() }}
        </div>

    </div>
@endsection
