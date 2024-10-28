<!-- Modal Section -->
<input type="checkbox" id="my-menu" class="modal-toggle hidden"/>
<div class="modal bg-gray-100 dark:bg-gray-900 transition-all duration-500 ease-in-out">
    <div class="modal-box relative grid grid-cols-1 gap-4 p-4 bg-white rounded-xl shadow-md dark:bg-gray-800">
        <label for="my-menu"
               class="absolute right-2 top-2 cursor-pointer border rounded-full dark:border-gray-500 p-2 bg-white shadow-lg transition-all duration-200 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-blue-200 dark:bg-gray-900 dark:hover:bg-blue-500"
               aria-label="Close Menu">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round"
                 stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-5 h-5">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </label>


        <div class="flex items-center space-x-2 bg-gray-700 w-full p-2 rounded-lg justify-center gap-2">
            <div class="flex-shrink-0">
                <img class="h-16 w-16" src="/img/default_user_avatar.png" />
            </div>
            <div>
                @auth
                    <div class="text-xl font-medium text-black dark:text-white">{{auth()->user()->username}}</div>
                    <p class="text-gray-500 dark:text-gray-300">What do you need?</p>
                @else
                    <div class="text-xl font-medium text-black dark:text-white">Welcome Guest</div>
                    <p class="text-gray-500 dark:text-gray-300">register, or login</p>
                @endauth
            </div>
        </div>
    </div>
</div>
