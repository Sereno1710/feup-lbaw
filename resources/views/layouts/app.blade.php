<?php
use Carbon\Carbon;
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

<body>
    <header class="fixed top-0 w-screen p-16 pt-4 pb-4 bg-white text-stone-800 shadow-lg">
        <nav class="items-center m-auto flex justify-between ">
            <h1 class="text-4xl font-bold"><a href="{{ url('/home') }}">SoundSello</a></h1>
            <div class="flex justify-between items-center">
                <div class="relative inline-block">
                    <form class="p-1 bg-stone-200 rounded-lg" action="/search" method="GET">
                        <input class="bg-stone-200 outline-none px-4 py-2" type="text" name="input"
                            placeholder="Search auctions and users" id="searchBar">

                        <span class="dropdown-button cursor-pointer mr-2">&#9660;</span>

                        <div class="absolute mt-2 p-2 bg-gray-100 border rounded border-gray-300 rounded shadow-md hidden"
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
                                <input type="checkbox" id="category4" name="categories[]" value="percussion"
                                    class="mr-2" checked>Percussion</label>
                        </div>

                        <button type="submit">🔎</button>
                    </form>
                </div>

                @if (Auth::check() && (Auth::user()->isAdmin() or Auth::user()->isSystemManager()))
                <a href="{{ url('/admin/users') }}" class="ml-4">Admin</a>
                @endif
                <a href="{{ url('/auctions') }}" class="ml-4">View Auctions</a>
                @if (Auth::check())
                <a href="{{ url('/auction/submit') }}" class="ml-4">Submit Auction</a>
                <div class="user-info ml-4">
                    <button class="notification-icon dropdown-button" id="notificationBtn">🔔</button>
                    <div class="dropdown-content hidden bg-gray-100 absolute right-0 mt-2 p-4 border rounded max-h-40 overflow-y-auto"
                        id="notificationDropdown">
                        @if (Auth::check())
                        @php
                        $notifications = \App\Models\Notification::where('receiver_id', Auth::user()->id)
                        ->orderBy('date', 'desc')
                        ->get();
                        @endphp

                        <div class="notification-content">
                            <div class="notification-header">
                                <h3 class="text-lg font-bold">Notifications</h3>
                            </div>
                            <div class="notification-list">
                                <ul>
                                    @php
                                    $displayedAuctions = [];
                                    @endphp

                                    @foreach ($notifications as $notification)
                                    <li
                                        class="border-b py-2 {{ $notification->viewed ? 'text-gray-500' : 'text-black' }}">
                                        @php
                                        $bid = \App\Models\Bid::where('id', $notification->bid_id)->first();
                                        $auction = $bid ? $bid->auction : null;
                                        $formattedDate = \Carbon\Carbon::parse($notification->date)->format('F j, Y g:i
                                        A');
                                        @endphp

                                        @if ($auction && !in_array($auction->id, $displayedAuctions))
                                        Someone just made a higher bid in <a
                                            href="{{ url('/auction/' . $auction->id) }}"
                                            class="underline hover:text-gray-600">{{
                                            $auction->name }}</a>
                                        <p class="text-gray-600 text-sm">{{ $formattedDate }}</p>
                                        @php
                                        $displayedAuctions[] = $auction->id;
                                        @endphp
                                        @else
                                        Not a bid notification
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                    @php
                    $profileImagePath = Auth::user()->profileImagePath();
                    @endphp
                    <button class="m-2 dropdown-button" id="profileBtn">
                        <img class="w-[3rem] h-[3rem] rounded-full object-cover" src="{{ asset($profileImagePath) }}">
                    </button>
                    <div class="dropdown-content hidden bg-stone-900 absolute mt-2 p-4 border rounded max-h-30 max-w-20 overflow-y-auto rounded-lg"
                        id="profileDropdown">

                        <div class="profile-content">
                            <div class="profile-list">
                                <ul>
                                    <li class="border-b py-2 text-white">
                                        <a href="{{ url('/profile') }}" class="hover:text-gray-400">Profile</a>
                                    </li>
                                    <li class="border-b py-2 text-white">
                                        <a href="{{ url('/balance') }}"
                                            class="hover:text-gray-400">{{Auth::user()->balance}}</a>
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