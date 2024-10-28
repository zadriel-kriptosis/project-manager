@extends('layouts.base')

@section('content')
    <div class="container mx-auto p-4">
        <div
            class="bgmodel text-lg lg:text-xl font-bold text-white mb-4 shadow-lg p-4 dark:bg-gray-700 bg-blue-700 rounded-lg flex flex-row justify-between items-center">
            <h1 class="text-xl lg:text-2xl font-bold text-white leading-tight">
                <span>{{ $page_title }}</span>
            </h1>
            <a href="{{ route('admin.' . $model . '.index') }}"
               class="inline-block bg-green-600 dark:bg-green-700 text-white border border-green-600 dark:border-green-800 rounded-xl text-sm font-semibold tracking-wide uppercase hover:bg-green-500 dark:hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-500 focus:ring-opacity-50 transition-colors duration-300 px-4 py-2">
                @lang('admin.all') {{ trans_choice('admin.' . $model, 2) }}
            </a>
        </div>
        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg dark:bg-gray-800">
            <div class="md:flex">
                <div class="w-full p-6">
                    <form action="{{ route('admin.' . $model . '.update', $data->uuid) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <fieldset class="mb-6">
                            <legend class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Permissions
                            </legend>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                @foreach (\App\Models\Permission::all() as $permission)
                                    <div class="flex items-center">
                                        <input id="permissions_{{ $permission->uuid }}" name="permissions[]"
                                               type="checkbox" value="{{ $permission->uuid }}"
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600 rounded"
                                            {{ in_array($permission->uuid, $role_permissions) ? 'checked' : '' }}>
                                        <label for="permissions_{{ $permission->uuid }}"
                                               class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 select-none cursor-pointer">@lang('permissions.' . $permission->name)</label>
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>

                        <!-- Update Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="inline-flex items-center justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150 ease-in-out">
                                <svg class="mr-2 -ml-1 w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke="#000000" stroke-width="2" stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M7 7L5.5 5.5M15 7L16.5 5.5M5.5 16.5L7 15M11 5L11 3M5 11L3 11M17.1603 16.9887L21.0519 15.4659C21.4758 15.3001 21.4756 14.7003 21.0517 14.5346L11.6992 10.8799C11.2933 10.7213 10.8929 11.1217 11.0515 11.5276L14.7062 20.8801C14.8719 21.304 15.4717 21.3042 15.6375 20.8803L17.1603 16.9887Z"></path>
                                </svg>
                                @lang('admin.update') {{ucfirst($model)}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
