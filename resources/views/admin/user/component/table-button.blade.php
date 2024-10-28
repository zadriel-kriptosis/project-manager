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
    @can($model . '-edit')
        <a href="{{ route('admin.' . $model . '.edit', ['id' => $data->id]) }}" title="@lang('admin.edit_data')">
            <svg viewBox="0 0 24 24" class="text-white w-8 rounded-md bg-green-500" fill="transparent"
                 stroke="currentColor"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M14 6L8 12V16H12L18 10M14 6L17 3L21 7L18 10M14 6L18 10M10 4L4 4L4 20L20 20V14"
                      stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </a>
    @endcan

    @can($model . '-ban')
        <a href="#banModal{{ $data->id }}" title="@lang('admin.ban_unban_user')">
            <svg viewBox="0 0 472.615 472.61" class="text-white w-8 rounded-md bg-gray-950" fill="transparent"
                 stroke="currentColor" stroke-width="20" xmlns="http://www.w3.org/2000/svg">
                <circle cx="147.692" cy="98.47" r="68.923"></circle>
                <path
                    d="M271.266,200.647c-10.266-9.228-22.454-16.234-36.014-20.319l-15.854-4.629l-67.946,67.947l-68.045-67.947l-15.854,4.629 C27.178,192.539,0,228.974,0,271.12v83.407h211.226c-11.629-47.005,0.726-98.784,37.39-135.448 C255.6,212.093,263.203,205.959,271.266,200.647z"></path>
                <path
                    d="M436.618,233.005c-23.253-23.253-54.16-36.053-87.039-36.053c-32.878,0-63.786,12.8-87.039,36.053 c-47.995,47.996-47.995,126.082,0,174.078c23.994,23.993,55.517,35.985,87.039,35.985c31.523,0,63.046-11.992,87.039-35.985 C484.614,359.087,484.614,281.001,436.618,233.005z M246.182,320.044c0-27.619,10.751-53.584,30.283-73.115 c19.531-19.531,45.495-30.283,73.114-30.283c24.309,0,47.327,8.345,65.814,23.659L269.842,385.856 C254.527,367.369,246.182,344.352,246.182,320.044z M422.694,393.157c-37.953,37.954-98.327,40.137-138.912,6.608L429.317,254.23 c15.315,18.487,23.659,41.505,23.659,65.814C452.976,347.662,442.224,373.627,422.694,393.157z"></path>
            </svg>
        </a>

        @if($data->banned_until !== null)
            <div id="banModal{{ $data->id }}"
                 class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-11/12 md:w-1/3">
                    <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">@lang('admin.confirm_remove_ban')</h2>
                    <p class="mb-6 mt-2 text-gray-700 dark:text-gray-300">@lang('admin.confirm_remove_ban_desc')</p>
                    <div class="mb-4">
                        @php
                            $attributes = collect($data->getAttributes())->take(3);
                            $bannedDays = round(now()->diffInDays($data->banned_until));
                            $message = Lang::get('messages.user_banned', ['days' => $bannedDays, 'username' => $data->username]);
                        @endphp
                        <p><strong>{{ $message }}</strong></p>
                        @foreach ($attributes as $key => $value)
                            <p><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</p>
                        @endforeach
                    </div>
                    <form action="{{ route('admin.' . $model . '.unban_user', ['id' => $data->id]) }}" method="POST">
                        @csrf
                        <div class="flex justify-end mt-4">
                            <a href="#"
                               class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded mr-2">@lang('admin.cancel')</a>
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded">@lang('admin.unban_user')</button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <!-- Modal -->
            <div id="banModal{{ $data->id }}"
                 class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-11/12 md:w-1/3">
                    <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">@lang('admin.confirm_ban')</h2>
                    <p class="mb-6 mt-2 text-gray-700 dark:text-gray-300">@lang('admin.confirm_ban_desc')</p>
                    <div class="mb-4">
                        @php
                            $attributes = collect($data->getAttributes())->take(3);
                        @endphp
                        @foreach ($attributes as $key => $value)
                            <p><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</p>
                        @endforeach
                    </div>
                    <form action="{{ route('admin.' . $model . '.ban_user', ['id' => $data->id]) }}" method="POST">
                        @csrf
                        <label for="days">Number of Ban Days:</label>
                        <input type="number" name="days" id="days" value="15" required>
                        <div class="flex justify-end mt-4">
                            <a href="#"
                               class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded mr-2">@lang('admin.cancel')</a>
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded">@lang('admin.ban_user')</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    @endcan

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
