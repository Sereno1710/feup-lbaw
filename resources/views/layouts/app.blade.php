<?php
use Carbon\Carbon;
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>SoundSello</title>
    @vite('resources/css/app.css')
    <script src="{{ asset('js/admin.js') }}" defer></script>
    <script src="{{ asset('js/auction_time.js') }}" defer></script>
    <script src="{{ asset('js/dropdown.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <header class="fixed top-0 w-screen p-16 pt-4 pb-4 bg-white text-stone-800 shadow-lg">
        <nav class="items-center m-auto flex justify-between ">
            <h1 class="text-4xl font-bold"><a href="{{ url('/home') }}">SoundSello</a></h1>
            <div class="flex justify-between items-center">
                <form class="p-1 bg-stone-200 rounded-lg" action="/search" method="GET">
                    <input class="bg-stone-200 outline-none" type="text" name="input" placeholder="Search auctions and users">
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
                                            href="{{ url('/auction/' . $auction->id) }}" class="underline hover:text-gray-600">{{
                                            $auction->name }}</a> <p class="text-gray-600 text-sm">{{ $formattedDate }}</span>
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
                </div>
                <a href="{{ url('/logout') }}" class="ml-4">Logout</a>
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