<?php
use Carbon\Carbon;

use App\Models\Notification;
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>SoundSello</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/auction.js')
    @vite('resources/js/dropdown.js')
    @vite('resources/js/search_filters.js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="flex flex-col min-h-screen">
    <header class="fixed top-0 w-screen p-16 pt-4 pb-4 bg-white text-stone-800 shadow-lg z-1000" style="z-index: 1000;">
        <nav class="items-center m-auto flex flex-row justify-between ">
            <h1 class="text-4xl font-bold"><a href="{{ url('/home') }}">SoundSello</a></h1>
            <div class="flex justify-between items-center">

                <form class="p-1 m-0 bg-stone-200 rounded-lg flex flex-row items-center relative" action="/search"
                    method="GET">
                    <input class="bg-stone-200 outline-none px-2 py-2" type="text" name="input"
                        placeholder="Search auctions and users" id="searchBar">

                    <span class="dropdown-button cursor-pointer mr-2">&#9660;</span>

                    <div class="absolute w-[40rem] left-[-100%] top-[100%] mt-2 p-2 bg-gray-100 overflow-y-auto max-h-72 border rounded border-gray-300 rounded shadow-md hidden"
                        id="categoriesDropdown">
                        <h3 class="text-lg font-bold">Categories</h3>
                        <div class="flex flex-wrap items-center space-x-4">
                            <label for="strings" class="flex items-center">
                                <input type="checkbox" id="strings" name="categories[]" value="strings" class="mr-1"
                                    checked>Strings</label>
                            <label for="woodwinds" class="flex items-center">
                                <input type="checkbox" id="woodwinds" name="categories[]" value="woodwinds" class="mr-1"
                                    checked>Woodwinds</label>
                            <label for="brass" class="flex items-center">
                                <input type="checkbox" id="brass" name="categories[]" value="brass" class="mr-1"
                                    checked>Brass</label>
                            <label for="percussion" class="flex items-center">
                                <input type="checkbox" id="percussion" name="categories[]" value="percussion"
                                    class="mr-1" checked>Percussion</label>
                        </div>

                        <div class="flex flex-wrap space-x-4 mt-6">
                            @foreach ($metaInfos as $metaInfo)
                            <div class="flex flex-col space-y-2 meta-info-container">
                                <h4 class="dropdown-button-filter text-lg font-bold" id="{{ $metaInfo->name }}Dropdown">
                                    {{ $metaInfo->name }}<span class="cursor-pointer text-sm ml-1">&#9660;</span>
                                </h4>

                                <div class="values hidden">
                                    @foreach ($metaInfo->values as $value)
                                    <label for="{{ $value->value }}" class="flex items-center">
                                        <input type="checkbox" id="{{ $value->value }}"
                                            name="metaInfo{{ $metaInfo->name }}[]" value="{{ $value->value }}"
                                            class="mr-2" checked>{{ $value->value }}</label>
                                    @endforeach
                                </div>
                                <input name="metaInfos[]" value="{{ $metaInfo->name }}" class="meta-info-input hidden">
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit">
                        <button type="submit"><img class="h-[1.5rem] object-contain"
                                src="{{ asset('images/icons/search.png') }}"></button>
                    </button>
                </form>

                @if (Auth::check() && (Auth::user()->isAdmin() or Auth::user()->isSystemManager()))
                <a href="{{ url('/admin/users') }}" class="ml-4">Admin</a>
                @endif
                <a href="{{ url('/auctions') }}" class="ml-4">View Auctions</a>
                @if (Auth::check())
                <a href="{{ url('/auction/submit') }}" class="ml-4">Submit Auction</a>
                @php
                $unviewedNotificationsCount = Notification::where('receiver_id', Auth::user()->id)
                ->where('viewed', false)
                ->count();
                $noflagNotificationsCount = Notification::where('receiver_id', Auth::user()->id)
                ->where('flag', true)
                ->count();
                @endphp
                <button class="notification-icon dropdown-button relative ml-4" id="notificationBtn">
                    <img class="h-[1.5rem] object-contain" src="{{ asset('images/icons/bell.png') }}">
                    @if ($unviewedNotificationsCount > 0)
                    <span
                        class="notification-badge bg-red-500 text-white text-xs font-bold rounded-full p-1 absolute top-3 left-3">
                        {{ $unviewedNotificationsCount }}
                    </span>
                    @endif
                </button>
                <div class="dropdown-content hidden bg-gray-100 absolute top-16 right-0 mt-2 p-4 border rounded max-h-40 overflow-y-auto"
                    id="notificationDropdown">
                    @if (Auth::check())
                    <div id="notifications" class="notification-content">
                        <div class="notifications-title inline flex flex-row justify-between border-b border-black">
                            <h3 class="text-lg font-bold ">Notifications</h3>
                            @if ($noflagNotificationsCount != 0)
                            <div id="notification-buttons">
                                <button type="button" class="inline hover:text-gray-500 btn-viewall" user_id="{{Auth::user()->id}}">Mark all as read</button>
                                <button type="button" class="inline hover:text-gray-500 btn-deleteall" user_id="{{Auth::user()->id}}">Delete all</button>
                            </div>
                            @endif
                        </div>
                        <div class="notification-list">
                            <ul id="notification-ul">
                                @foreach (Auth::user()->notifications as $notification)
                                @if ($notification->flag == false)
                                @continue
                                @endif
                                @include('partials.notification', [
                                'notification' => $notification,
                                ])
                                @endforeach
                                @if ($unviewedNotificationsCount == 0 && $noflagNotificationsCount == 0)
                                <li class="no-notifications mt-2">
                                    You currently have zero notifications.
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="user-info ml-4">
                    @php
                    $profileImagePath = Auth::user()->profileImagePath();
                    @endphp
                    <button class="m-2 p-2 dropdown-button flex flex-row items-center bg-stone-300 rounded-lg"
                        id="profileBtn">
                        <div class="flex flex-col">
                            <p> {{ Auth::user()->name }} </p>
                            <p class="text-sm">Balance: {{ Auth::user()->balance }} </p>
                        </div>
                        <img class="w-[3rem] h-[3rem] rounded-full object-cover ml-2"
                            src="{{ asset($profileImagePath) }}">
                    </button>
                    <div class="dropdown-content hidden bg-stone-900 absolute top-16 mt-2 p-4 border max-h-30 max-w-20 overflow-y-auto rounded-lg"
                        id="profileDropdown">
                        <div class="profile-content">
                            <div class="profile-list">
                                <ul>
                                    <li class="border-b py-2 text-white">
                                        <a href="{{ url('/profile') }}" class="hover:text-gray-400">Profile</a>
                                    </li>
                                    <li class="border-b py-2 text-white">
                                        <a href="{{ url('/balance') }}" class="hover:text-gray-400">Deposit/Withdraw</a>
                                    </li>
                                    <li class="py-2 text-white">
                                        <a href="{{ url('/logout') }}" class="hover:text-gray-400">Log out</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <a href="{{ url('/login') }}" class="ml-4">Sign In</a>
                <a href="{{ url('/register') }}" class="ml-4">Sign Up</a>
                @endif
            </div>
        </nav>
        <nav class="m-auto">
            @yield('nav-bar')
        </nav>
    </header>
    <main class="flex-1">
        <section id="content" class="mt-32 mb-4 mx-32">
            @yield('content')
        </section>
    </main>
    <footer class="p-8 pt-4 pb-4 bg-stone-800 flex flex-col justify-between">
        <ul class="flex flex-row text-stone-200 divide-x">
            <li class="pr-4"><a href="{{ url('/about-us') }}">About Us</a></li>
            <li class="px-4"><a href="{{ url('/faq') }}">FAQ</a></li>
            <li class="px-4"><a href="{{ url('/contacts') }}">Contacts</a></li>
            <li class="px-4"><a href="{{ url('/terms-of-use') }}">Terms of Use</a></li>
            <li class="pl-4"><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
        </ul>
        <p class="mt-1 text-sm text-stone-50">Copyright &copy; 2023 SoundSello</p>

    </footer>
</body>

</html>