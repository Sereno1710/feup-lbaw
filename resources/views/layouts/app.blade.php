<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>SoundSello</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/admin.js')
    @vite('resources/js/auction_time.js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <header class="fixed top-0 w-screen p-16 pt-4 pb-4 bg-white text-stone-800 shadow-lg">
        <nav class="items-center m-auto flex justify-between ">
            <h1 class="text-4xl font-bold"><a href="{{ url('/home') }}">SoundSello</a></h1>
            <div class="flex justify-between items-center">
                <form class="p-1 bg-stone-200 rounded-lg" action="/auction/search" method="GET">
                    <input class="bg-stone-200 outline-none" type="text" name="keyword" placeholder="Search auctions">
                    <button type="submit">🔎</button>
                </form>
                @if (Auth::check() && Auth::user()->isAdmin())
                <a href="{{ url('/admin') }}" class="ml-4">Admin</a>
                @endif
                <a href="{{ url('/auctions') }}" class="ml-4">View Auctions</a>
                @if (Auth::check())
                    <a href="{{ url('/auction/submit') }}" class="ml-4">Submit Auction</a>
                    <div class="user-info">
                        <a href="{{ url('/profile') }}" class="ml-4">{{ Auth::user()->name }}</a>
                        <a href="{{ url('/balance') }}" class="ml-4">{{ Auth::user()->balance}}</a>
                        <a href="{{ url('/notifications') }}" class="notification-icon">🔔</a>
                    </div>
                    <a href="{{ url('/logout') }}" class="ml-4">Logout</a>
                @else
                <a href="{{ url('/login') }}" class="ml-4">Sign In</a>
                <a href="{{ url('/register') }}" class="ml-4">Sign Up</a>
                @endif
            </div>
        </nav>
        <nav class="m-auto" >
                @yield('nav-bar')
        </nav>
    </header>   
    <main>
        <section id="content" class="m-32">
            @yield('content')
        </section>
    </main>
    <footer>
        <div class="fixed bottom-0 w-screen p-8 pt-4 pb-4 bg-stone-800">
            <div class="flex flex-col justify-between">
                <ul class="flex flex-row flex-auto text-stone-200 divide-x">
                    <li class="pr-4"><a href="{{ url('/about-us') }}">About Us</a></li>
                    <li class="px-4"><a href="{{ url('/faq') }}">FAQ</a></li>
                    <li class="px-4"><a href="{{ url('/contacts') }}">Contacts</a></li>
                    <li class="px-4"><a href="{{ url('/terms-of-use') }}">Terms of Use</a></li>
                    <li class="pl-4"><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
                </ul>
                <p class="mt-1 text-sm text-stone-50">Copyright &copy; 2023 SoundSello</p>
            </div>
        </div>
    </footer>
</body>

</html>