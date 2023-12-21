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
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="flex flex-col min-h-screen">
    <header class="fixed top-0 w-screen p-16 pt-4 pb-4 bg-white text-stone-800 shadow-lg">
        <nav class="items-center m-auto flex flex-row justify-between ">
            <h1 class="text-4xl font-bold"><a href="{{ url('/home') }}">SoundSello</a></h1>
            <div class="flex justify-between items-center">

                <form class="p-1 m-0 bg-stone-200 rounded-lg flex flex-row items-center" action="/search" method="GET">
                    <input class="bg-stone-200 outline-none px-4 py-2" type="text" name="input"
                        placeholder="Search auctions and users" id="searchBar">

                    <span class="dropdown-button cursor-pointer mr-2">&#9660;</span>

                    <div class="absolute mt-2 p-2 bg-gray-100 border border-gray-300 rounded-lg shadow-md hidden"
                        id="categoriesDropdown">
                        <label for="category1" class="flex items-center">
                            <input type="checkbox" id="category1" name="categories[]" value="strings" class="mr-2"
                                checked>Strings</label>
                        <label for="category2" class="flex items-center">
                            <input type="checkbox" id="category2" name="categories[]" value="woodwinds" class="mr-2"
                                checked>Woodwinds</label>
                        <label for="category3" class="flex items-center">
                            <input type="checkbox" id="category3" name="categories[]" value="brass" class="mr-2"
                                checked>Brass</label>
                        <label for="category4" class="flex items-center">
                            <input type="checkbox" id="category4" name="categories[]" value="percussion" class="mr-2"
                                checked>Percussion</label>
                    </div>

                    <button type="submit"><img class="h-[1.5rem] object-contain"
                            src="{{ asset('images/icons/search.png') }}"></button>
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
                            <div class="notification-content">
                                <div class="notifications-title inline flex flex-row justify-between mr-2">
                                    <h3 class="text-lg font-bold">Notifications</h3>
                                    @if ($noflagNotificationsCount != 0)
                                    <div>
                                        <form action="{{ route('notification.viewall') }}" method="POST" class="inline hover:text-gray-500">
                                            @csrf
                                            <button type="submit" class="btn-view">Mark all as read</button>
                                        </form>
                                        |
                                        <form action="{{ route('notification.deleteall') }}" method="POST" class="inline hover:text-gray-500">
                                            @csrf
                                            <button type="submit" class="btn-delete">Delete all</button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                                <div class="notification-list">
                                    <ul>
                                        @foreach (Auth::user()->notifications as $notification)
                                            @if ($notification->flag == false)
                                                @continue
                                            @endif
                                        @else
                                            @continue
                                        @endif
                                            <div class="notification-buttons inline flex flex-row justify-between mr-2">
                                                <p class="text-gray-600 text-sm">{{ $formattedDate }} </span>
                                                <div>
                                                    @if (!$notification->viewed)
                                                    <form action="{{ route('notification.view', $notification->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="btn-view">✔️</button>
                                                    </form>
                                                    @endif

                                                    <form action="{{ route('notification.delete', $notification->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="btn-delete">❌</button>
                                                    </form>
                                                </div>
                                            </div>
                                    </li>
                                    @endforeach
                                    @if ($unviewedNotificationsCount == 0 && $noflagNotificationsCount == 0)
                                        <div class="no-notifications mt-2">
                                            You currently have zero notifications.
                                        </div>
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
                                            <a href="{{ url('/balance') }}"
                                                class="hover:text-gray-400">Deposit/Withdraw</a>
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
