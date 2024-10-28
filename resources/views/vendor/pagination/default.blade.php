@if ($paginator->hasPages())
    <div class="py-3 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row items-center justify-between bg-white dark:bg-gray-800 px-4 py-3">
            <!-- Pagination Details -->
            <div class="text-sm text-gray-700 dark:text-gray-400 mb-2 sm:mb-0">
                {{ __('pagination.showing') }}
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                {{ __('pagination.to') }}
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                {{ __('pagination.of') }}
                <span class="font-medium">{{ $paginator->total() }}</span>
                {{ __('pagination.results') }}
            </div>

            <!-- Pagination Controls -->
            <div class="flex justify-center items-center space-x-1">
                <!-- Previous Page Link -->
                @if ($paginator->onFirstPage())
                    <span
                        class="inline-flex items-center px-2 py-1 text-sm font-medium text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-700 cursor-default rounded-full">
                    {{ __('pagination.prev') }}
                </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="inline-flex items-center px-2 py-1 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                        {{ __('pagination.prev') }}
                    </a>
                @endif

                <!-- Pagination Page Numbers -->
                <ul class="flex pl-0 list-none rounded mx-2">
                    @foreach ($elements as $element)
                        <li>
                            @if (is_string($element))
                                <span
                                    class="inline-flex items-center px-2 py-1 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 cursor-default rounded-full">{{ $element }}</span>
                            @elseif (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-sm font-medium text-white bg-blue-500 dark:bg-blue-600 border border-blue-500 dark:border-blue-600 rounded-full">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}"
                                           class="inline-flex items-center px-2 py-1 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 hover:bg-blue-100 dark:hover:bg-gray-700 rounded-full">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        </li>
                    @endforeach
                </ul>

                <!-- Next Page Link -->
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="inline-flex items-center px-2 py-1 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                        {{ __('pagination.next') }}
                    </a>
                @else
                    <span
                        class="inline-flex items-center px-2 py-1 text-sm font-medium text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-700 cursor-default rounded-full">
                    {{ __('pagination.next') }}
                </span>
                @endif
            </div>
        </div>
    </div>
@endif
