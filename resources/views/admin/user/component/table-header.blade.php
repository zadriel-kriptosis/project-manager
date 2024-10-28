<div class="flex flex-row justify-between gap-6">
        @can($model . '-create')
        <a href="{{ route('admin.' . $model . '.create') }}" class="w-fit">
            @csrf
            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="column" value="{{ request('column') }}">
            <div>
                <div
                    class="bg-pink-800 hover:bg-pink-700 dark:bg-pink-900 dark:hover:bg-pink-700 px-4 py-1 rounded-t-md transition duration-300 ease-in-out">
                <span class="inline-block align-middle">
                    <svg fill="none" stroke="white" stroke-width="2" class="w-6 mr-1" viewBox="0 0 32 32"
                         xmlns="http://www.w3.org/2000/svg"><path
                            d="M16 0c-8.836 0-16 7.163-16 16s7.163 16 16 16c8.837 0 16-7.163 16-16s-7.163-16-16-16zM16 30.032c-7.72 0-14-6.312-14-14.032s6.28-14 14-14 14 6.28 14 14-6.28 14.032-14 14.032zM23 15h-6v-6c0-0.552-0.448-1-1-1s-1 0.448-1 1v6h-6c-0.552 0-1 0.448-1 1s0.448 1 1 1h6v6c0 0.552 0.448 1 1 1s1-0.448 1-1v-6h6c0.552 0 1-0.448 1-1s-0.448-1-1-1z"></path></svg>
                </span>
                    <span class="inline-block align-middle tracking-wider text-gray-100 hover:text-white">
                    @lang('admin.add') {{ trans_choice('admin.' . $model, 1) }}
                </span>
                </div>
            </div>
        </a>
    @endcan
</div>
