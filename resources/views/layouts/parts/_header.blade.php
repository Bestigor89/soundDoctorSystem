<nav class="font-sans bg-white text-center flex justify-between my-2 mx-auto container overflow-hidden">
    <a href="/" class="block text-left">
        <img src="https://stitches.hyperyolo.com/images/logo.png" class="h-10 sm:h-10 rounded-full" alt="logo">
    </a>
    <ul class="text-sm text-gray-700 list-none p-0 flex items-center">
        <li class="pl-2 border-l"><a href="{{ route('login') }}"
                                     class="inline-block py-2 px-3 text-gray-900 hover:text-gray-700 no-underline">Log In</a></li>
        @if(Route::has('register'))
            <a href="{{ route('register') }}" class="bg-black hover:bg-text-gray-800 text-white ml-4 py-2 px-3">
                {{ __('global.register') }}
            </a>
        @endif
    </ul>
</nav>
