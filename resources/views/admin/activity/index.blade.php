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
                        <th scope="col" class="px-6 py-3">@lang('admin.user_id')</th>
                        <th scope="col" class="px-6 py-3">@lang('admin.ip_address')</th>
                        <th scope="col" class="px-6 py-3">@lang('admin.user_agent')</th>
                        <th scope="col" class="px-6 py-3">@lang('admin.last_activity')</th>
                        <th scope="col" class="px-6 py-3">@lang('admin.last_login')</th>
                        <th scope="col" class="px-6 py-3">@lang('admin.last_logout')</th>
                        <th scope="col" class="px-6 py-3">@lang('admin.actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datas as $data)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-300">
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ $data->id }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                {{ optional($data->user)->username }}
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ $data->user_id }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ $data->ip_address }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ $data->user_agent }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ $data->last_activity }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ $data->last_login }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">{{ $data->last_logout }}</td>
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
