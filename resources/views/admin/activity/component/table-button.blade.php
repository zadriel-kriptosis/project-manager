<style>
    /* CSS for modal visibility and transitions */
    .modal:target {
        visibility: visible;
        opacity: 1;
    }

    .modal {
        visibility: hidden;
        opacity: 0;
    }
</style>
<div class="flex flex-row gap-2">
    @can($model . '-destroy')
        <a href="#deleteModal{{ $data->id }}" title="@lang('admin.destroy_data')">
            <svg viewBox="0 0 72 72" class="text-white w-8 rounded-md bg-red-500" fill="transparent"
                 stroke="currentColor" stroke-width="3" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M53.678,61.824c-2.27,0-4.404-0.885-6.01-2.49L36,47.667L24.332,59.334c-1.604,1.605-3.739,2.49-6.01,2.49 s-4.404-0.885-6.01-2.49c-1.605-1.604-2.49-3.739-2.49-6.01c0-2.271,0.885-4.405,2.491-6.011l11.666-11.667l-10.96-10.961 c-1.605-1.604-2.49-3.739-2.49-6.01s0.885-4.405,2.49-6.01c1.605-1.605,3.739-2.49,6.011-2.49c2.271,0,4.405,0.885,6.01,2.49 L36,23.626l10.96-10.96c1.605-1.605,3.738-2.49,6.01-2.49s4.406,0.885,6.01,2.49c1.605,1.604,2.49,3.739,2.49,6.01 s-0.885,4.405-2.49,6.01L48.021,35.646l11.666,11.668c1.605,1.604,2.49,3.738,2.49,6.01c0,2.271-0.885,4.405-2.49,6.01 C58.084,60.939,55.949,61.824,53.678,61.824z M36,42.839c0.511,0 1.023,0.195 1.414,0.586l13.082,13.081 c0.852,0.851,1.98,1.318,3.182,1.318c1.203,0 2.332-0.468 3.182-1.318c0.852-0.851,1.318-1.98,1.318-3.182 c0-1.202-0.467-2.332-1.318-3.181l-13.08-13.083c-0.781-0.781-0.781-2.047,0-2.828l12.373-12.375 c0.852-0.851,1.318-1.979,1.318-3.182s-0.467-2.331-1.318-3.182c-0.85-0.851-1.98-1.318-3.182-1.318s-2.332,0.468-3.18,1.318 L37.414,27.868c-0.781,0.781-2.046,0.781-2.828,0L22.21,15.494c-0.85-0.851-1.979-1.318-3.181-1.318 c-1.202,0-2.332,0.468-3.182,1.318c-0.851,0.851-1.319,1.979-1.319,3.182s0.469,2.331,1.318,3.182l12.374,12.375 c0.781,0.781,0.781,2.047,0,2.828L15.14,50.143c-0.85,0.85-1.318,1.979-1.318,3.182c0,1.201,0.469,2.331,1.318,3.182 c0.851,0.851,1.98,1.318,3.182,1.318c1.202,0 2.332-0.468 3.182-1.318l13.083-13.081C34.977,43.034 35.489,42.839 36,42.839z"></path>
            </svg>
        </a>

        <!-- Modal -->
        <div id="deleteModal{{ $data->id }}"
             class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-11/12 md:w-1/3">
                <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">@lang('admin.confirm_delete')</h2>
                <div>
                    @php
                        $attributes = collect($data->getAttributes())->take(3);
                    @endphp
                    @foreach ($attributes as $key => $value)
                        <p><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</p>
                    @endforeach
                </div>
                <p class="mb-6 mt-2 text-gray-700 dark:text-gray-300">@lang('admin.confirm_delete_desc')</p>
                <div class="flex justify-end">
                    <a href="#"
                       class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded mr-2">@lang('admin.cancel')</a>
                    <a href="{{ route('admin.' . $model . '.destroy', ['id' => $data->id]) }}"
                       class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded">@lang('admin.delete')</a>
                </div>
            </div>
        </div>
    @endcan

</div>
