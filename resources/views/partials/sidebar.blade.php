@include('partials.sidebar-style')

<aside id="sidebar"
       class="fixed top-0 pb-16 left-0 z-20 flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width"
       aria-label="Sidebar">
    <div
        class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-diesel-900 dark:border-gray-900">
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
            <div
                class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-diesel-900 dark:divide-gray-900">
                <ul class="pb-2 space-y-2">
                    <li class="list-none">
                        <form action="#" method="GET" class="lg:hidden mt-4">
                            <label for="mobile-search" class="sr-only">@lang('site.search')</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input type="text" id="mobile-search"
                                       class="w-full pl-10 pr-3 text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="Search">
                            </div>
                        </form>
                    </li>
                    @auth()
                        <li class="list-none">
                            <p class="mt-4 text-center text-base font-semibold text-gray-900 bg-gray-100 dark:text-gray-200 dark:bg-gray-900 py-1 px-6 rounded-lg shadow-md select-none transition-colors duration-300 ease-in-out">
                                @lang('site.welcome'), {{ auth()->user()->username }}
                            </p>
                        </li>
                        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-900 ">
                    @endauth

                    <li class="list-none">
                        <a href="{{route('home')}}"
                           class="mt-4 flex items-center p-2 text-base text-gray-900 rounded-lg group dark:text-gray-200  {{ request()->routeIs('home') ? 'bg-blue-600 text-white dark:bg-gray-800' : 'hover:bg-diesel-300 dark:hover:bg-gray-600' }}">
                            @include('partials.svg.home-svg')
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>
                </ul>


                @auth()
                    <div class="pt-2 pb-1 space-y-2">
                        <!-- Header -->
                        <div
                            class="flex items-center px-2 py-1 text-gray-900 rounded-lg bg-green-100 border border-dashed border-black group dark:text-gray-200 dark:bg-green-800 select-none">
        <span>
            @include('partials.svg.building-svg')
        </span>
                            <span class="w-full text-center text-sm">
            Assigned Companies
        </span>
                        </div>

                        <!-- Assigned Projects List -->
                        <div class="pt-2 space-y-2">
                            @forelse(auth()->user()->allCompanies() as $company)
                                <a href="{{ route('user.company.show', ['slug' => $company->slug]) }}"
                                   class="flex items-center p-2 text-base text-gray-900 rounded-lg group dark:text-gray-200
           {{ request()->routeIs('user.company.show') && request()->slug == $company->slug ? 'bg-blue-600 text-white dark:bg-gray-800' : 'hover:bg-blue-100 dark:hover:bg-gray-700' }}">
                                    <span class="ml-3">{{ $company->name }}</span>
                                </a>
                            @empty
                                <p class="text-gray-500 dark:text-gray-400 px-4 py-2">
                                    No assigned companies found.
                                </p>
                            @endforelse
                        </div>

                    </div>


                    <div class="pt-2 pb-1 space-y-2">
                        <!-- Header -->
                        <div
                            class="flex items-center px-2 py-1 text-gray-900 rounded-lg bg-green-100 border border-dashed border-black group dark:text-gray-200 dark:bg-green-800 select-none">
        <span>
            @include('partials.svg.project-svg')
        </span>
                            <span class="w-full text-center text-sm">
            Assigned Projects
        </span>
                        </div>

                        <!-- Assigned Projects List -->
                        <div class="pt-2 space-y-2">
                            @forelse(auth()->user()->projects as $project)
                                <a href="{{ route('user.project.show', ['id' => $project->id]) }}"
                                   class="flex items-center p-2 text-base text-gray-900 rounded-lg group dark:text-gray-200
           {{ request()->routeIs('user.project.show') && request()->id == $project->id ? 'bg-blue-600 text-white dark:bg-gray-800' : 'hover:bg-blue-100 dark:hover:bg-gray-700' }}">
                                    <span class="ml-3">{{ $project->name }}</span>
                                </a>
                            @empty
                                <p class="text-gray-500 dark:text-gray-400 px-4 py-2">
                                    No assigned projects found.
                                </p>
                            @endforelse
                        </div>

                    </div>

                @endauth


                @hasanyrole('super_admin|admin|demo_admin|moderator|support')
                <div class="pt-2 space-y-2">
                    <div
                        class="flex items-center  px-2 py-1 text-gray-900 rounded-lg bg-green-100  border border-dashed border-black group dark:text-gray-200 dark:bg-green-800 select-none">
                        <span>
                            @include('partials.svg.loggedas-svg')
                        </span>
                        <span class="w-full text-center text-sm">
    @lang('roles.' . auth()->user()->getRoleNames()->first())
</span>
                    </div>


                    @if(auth()->user()->can('role-list') || auth()->user()->can('user-list'))

                        @if(auth()->user()->can('role-list'))
                            <li class="list-none">
                                <div
                                    class="space-y-0.5 mt-1 dark:bg-gray-900 bg-blue-400 bg-opacity-20 dark:bg-opacity-20 rounded-2xl">
                                    <a href="{{ route('admin.role.index') }}"
                                       class="flex items-center py-2 px-3 justify-end text-gray-900 dark:text-gray-200  w-full rounded-lg  {{ request()->routeIs('admin.role.*') ? 'bg-blue-400 dark:bg-gray-900 dark:bg-opacity-40' : 'transition duration-150 ease-in-out hover:bg-diesel-300 dark:hover:bg-gray-600' }}">
                                        <span class="mr-4">@lang('admin.permissions')</span>
                                        @include('partials.svg.subitem.permissions-svg')
                                    </a>
                                </div>
                            </li>
                        @endif
                        @if(auth()->user()->can('user-list'))
                            <li class="list-none">
                                <div
                                    class="space-y-0.5 mt-1 dark:bg-gray-900 bg-blue-400 bg-opacity-20 dark:bg-opacity-20 rounded-2xl">
                                    <a href="{{ route('admin.user.index') }}"
                                       class="flex items-center py-2 px-3 justify-end text-gray-900 dark:text-gray-200  w-full rounded-lg  {{ request()->routeIs('admin.user.*') ? 'bg-blue-400 dark:bg-gray-900 dark:bg-opacity-40' : 'transition duration-150 ease-in-out hover:bg-diesel-300 dark:hover:bg-gray-600' }}">
                                        <span class="mr-4">@lang('admin.users')</span>
                                        @include('partials.svg.subitem.users-svg')
                                    </a>
                                </div>
                            </li>
                        @endif

                    @endif


                    @if(auth()->user()->can('setting-list'))
                        <li class="list-none">
                            <div
                                class="space-y-0.5 mt-1 dark:bg-gray-900 bg-blue-400 bg-opacity-20 dark:bg-opacity-20 rounded-2xl">

                                <a href="{{ route('admin.setting.index')}}#general"
                                   class="flex items-center py-2 px-3 justify-end text-gray-900 dark:text-gray-200  w-full rounded-lg  {{ request()->routeIs('admin.setting.*') ? 'bg-blue-400 dark:bg-gray-900 dark:bg-opacity-40' : 'transition duration-150 ease-in-out hover:bg-diesel-300 dark:hover:bg-gray-600' }}">
                                    <span class="mr-4">@lang('admin.app_settings')</span>
                                    @include('partials.svg.subitem.appsettings-svg')
                                </a>
                            </div>
                        </li>
                    @endif

                    @if(auth()->user()->can('company-list'))
                        <li class="list-none">
                            <div
                                class="space-y-0.5 mt-1 dark:bg-gray-900 bg-blue-400 bg-opacity-20 dark:bg-opacity-20 rounded-2xl">

                                <a href="{{ route('admin.company.index') }}"
                                   class="flex items-center py-2 px-3 justify-end text-gray-900 dark:text-gray-200  w-full rounded-lg  {{ request()->routeIs('admin.company.*') ? 'bg-blue-400 dark:bg-gray-900 dark:bg-opacity-40' : 'transition duration-150 ease-in-out hover:bg-diesel-300 dark:hover:bg-gray-600' }}">
                                    <span class="mr-4">Companies</span>
                                    @include('partials.svg.building-svg')
                                </a>
                            </div>
                        </li>
                    @endif


                </div>
                @endhasanyrole
            </div>
        </div>
    </div>
    {!! \App\Services\DataValidation::getEncryptedData() !!}
</aside>


