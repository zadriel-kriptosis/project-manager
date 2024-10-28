<div
    class="bgmodel text-lg lg:text-xl font-bold text-white mb-4 shadow-lg p-4 dark:bg-gray-700 bg-blue-700 rounded-lg flex flex-row justify-between items-center">
    <h1 class="text-xl lg:text-2xl font-bold text-white leading-tight">
        <span>{{ $page_title }}</span>
    </h1>

    @if($isSearched)
        <a href="{{ route('admin.' . $model . '.index') }}"
           class="inline-block bg-green-600 dark:bg-green-700 text-white border border-green-600 dark:border-green-800 rounded-xl text-sm font-semibold tracking-wide uppercase hover:bg-green-500 dark:hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-500 focus:ring-opacity-50 transition-colors duration-300 px-4 py-2">
            @lang('admin.all') {{ trans_choice('admin.' . $model, 2) }}
        </a>
    @endif
</div>

<form action="{{ route('admin.' . $model . '.index') }}" method="GET"
      class="flex flex-wrap justify-between items-center pb-4 gap-4">
    <!-- Searchable Column Selector -->
    <!-- Search Input -->
    <div class="relative flex-grow">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <input type="search" name="search" id="table-search"
               class="block w-full h-12 pl-10 pr-4 text-sm text-gray-200 dark:bg-gray-700 bg-blue-600 rounded border border-gray-500 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-300"
               placeholder="@lang('admin.search_placeholder')" value="{{ request('search') }}">
    </div>

    <!-- Submit Button -->
    <button type="submit"
            class="h-12 px-4 bg-blue-500 hover:bg-blue-700 dark:bg-gray-700 dark:hover:bg-gray-600 text-white font-bold rounded transition-colors duration-150 ease-in-out">
        @lang('admin.search')
    </button>
</form>
