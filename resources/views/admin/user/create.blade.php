@extends('layouts.base')

@section('content')
    <div class="container mx-auto p-4">
        <div class="bgmodel text-lg lg:text-xl font-bold text-white mb-4 shadow-lg p-4 dark:bg-gray-700 bg-blue-700 rounded-lg flex flex-row justify-between items-center">
            <h1 class="text-xl lg:text-2xl font-bold text-white leading-tight">
                <span>{{ $page_title }}</span>
            </h1>
            <a href="{{ route('admin.' . $model . '.index') }}"
               class="inline-block bg-green-600 dark:bg-green-700 text-white border border-green-600 dark:border-green-800 rounded-xl text-sm font-semibold tracking-wide uppercase hover:bg-green-500 dark:hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-500 focus:ring-opacity-50 transition-colors duration-300 px-4 py-2">
                @lang('admin.all') {{ trans_choice('admin.' . $model, 2) }}
            </a>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden p-6">
            @if ($errors->any())
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.' . $model . '.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @php
                    $fields = [
                        ['name' => 'username', 'type' => 'text', 'label' => 'Username', 'required' => true],
                        ['name' => 'email', 'type' => 'email', 'label' => 'Email', 'required' => false],
                        ['name' => 'password', 'type' => 'password', 'label' => 'Password', 'required' => true, 'placeholder' => 'Enter a strong password'],
//                        ['name' => 'referral_code', 'type' => 'text', 'label' => 'Referral Code', 'required' => false],
                        ['name' => 'role', 'type' => 'select', 'label' => 'Role', 'options' => \App\Models\Role::pluck('name', 'uuid')->toArray(), 'required' => true],
                        ['name' => 'is_active', 'type' => 'select', 'label' => 'Active', 'options' => ['1' => 'Yes', '0' => 'No'], 'required' => true],
//                        ['name' => 'login_2fa', 'type' => 'checkbox', 'label' => '2FA Enabled', 'required' => false]
                    ];

                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    @foreach($fields as $field)
                        <div>
                            <label for="{{ $field['name'] }}" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                {{ $field['label'] }} @if($field['required']) <span class="text-red-500">*</span> @endif
                            </label>
                            @if($field['type'] === 'select')
                                <select id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" @if($field['required']) required @endif>
                                    <option value="">Select {{ $field['label'] }}</option>
                                    @if($field['name'] == 'role')
                                        @foreach($roles as $role)
                                            <option value="{{ $role->uuid }}">{{ Lang::get('roles.' . $role->name) }}</option>
                                        @endforeach
                                    @else
                                        @foreach($field['options'] as $value => $text)
                                            <option value="{{ $value }}">{{ $text }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            @elseif($field['type'] === 'file')
                                <input type="file" name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="mt-1 block w-full px-3 file:border file:border-gray-300 border border-gray-300 dark:border-gray-600 rounded-md file:text-sm file:font-semibold file:bg-white file:py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 hover:text-indigo-500 dark:text-gray-200 dark:bg-gray-700" @if($field['required']) required @endif>
                            @else
                                <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}" value="{{ old($field['name']) }}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="{{ $field['placeholder'] ?? '' }}" @if($field['required']) required @endif>
                            @endif
                        </div>
                    @endforeach

                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150 ease-in-out">
                        <svg class="mr-2 -ml-1 w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path stroke="#000000" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M7 7L5.5 5.5M15 7L16.5 5.5M5.5 16.5L7 15M11 5L11 3M5 11L3 11M17.1603 16.9887L21.0519 15.4659C21.4758 15.3001 21.4756 14.7003 21.0517 14.5346L11.6992 10.8799C11.2933 10.7213 10.8929 11.1217 11.0515 11.5276L14.7062 20.8801C14.8719 21.304 15.4717 21.3042 15.6375 20.8803L17.1603 16.9887Z"></path>
                        </svg>
                        @lang('admin.create') {{ucfirst($model)}}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
