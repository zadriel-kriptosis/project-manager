<div class="flex flex-row justify-between gap-6">
    <form action="{{ route('admin.' . $model . '.export') }}" method="POST" class="w-fit">
        @csrf
        <input type="hidden" name="search" value="{{ request('search') }}">
        <input type="hidden" name="column" value="{{ request('column') }}">
        <button type="submit">
            <div
                class="bg-blue-800 hover:bg-blue-700 dark:bg-gray-900 dark:hover:bg-gray-700 px-4 py-1 rounded-t-md transition duration-300 ease-in-out">
                <span class="inline-block align-middle">
                    <svg viewBox="0 0 64 64" class="w-6" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="white"
                         stroke-width="4">
                        <rect x="16" y="32" width="32" height="24"></rect>
                        <line x1="24" y1="48" x2="40" y2="48"></line>
                        <line x1="24" y1="40" x2="40" y2="40"></line>
                        <polyline points="20 16 20 8 44 8 44 16"></polyline>
                        <polyline points="16 40 8 40 8 16 56 16 56 40 48 40"></polyline>
                    </svg>
                </span>
                <span class="inline-block align-middle tracking-wider text-gray-100 hover:text-white">
                    @lang('admin.export') {{ trans_choice('admin.' . $model, 2) }}
                </span>
                <span
                    class="inline-block align-middle text-sm bg-gray-100 bg-opacity-90 rounded-sm px-1 lg:px-3 lg:ml-2 text-gray-800">
                    {{$totalItems}}
                </span>
            </div>
        </button>
    </form>
</div>
