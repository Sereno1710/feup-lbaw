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
                    @php
                        $unviewedNotificationsCount = \App\Models\Notification::where('receiver_id', Auth::user()->id)
                                ->where('viewed', false)
                                ->count();
                        $noflagNotificationsCount = \App\Models\Notification::where('receiver_id', Auth::user()->id)
                                ->where('flag', true)
                                ->count();
                    @endphp
                    <button class="notification-icon dropdown-button relative" id="notificationBtn">
                        @if ($unviewedNotificationsCount > 0)
                            🔔 <span class="notification-badge bg-red-500 text-white text-xs font-bold rounded-full p-1 absolute top-3 left-3">
                                {{ $unviewedNotificationsCount }}
                            </span>
                        @else 
                            🔔
                        @endif
                    </button>
                    
                    <div class="dropdown-content hidden bg-gray-100 absolute right-0 mt-2 p-4 border rounded max-h-40 overflow-y-auto"
                        id="notificationDropdown">
                        @if (Auth::check())
                        @php
                            $notifications = \App\Models\Notification::where('receiver_id', Auth::user()->id)
                                ->orderBy('date', 'desc')
                                ->get();
                        @endphp
                        <div class="notification-content">
                            <div class="notification-header border-b-2 border-black">
                                <h3 class="text-lg font-bold">Notifications</h3>
                            </div>
                            <div class="notification-list">
                                <ul>
                                    @foreach ($notifications as $notification)
                                    @if ($notification->flag == false)
                                        @continue
                                    @endif
                                    <li
                                        class="border-b border-black py-2 {{ $notification->viewed ? 'bg-gray-300' : 'text-black' }}">
                                        @if ($notification->flag)
                                            @php
                                                $bid = \App\Models\Bid::where('id', $notification->bid_id)->first();
                                                $auction = $bid ? $bid->auction : null;
                                                $formattedDate = \Carbon\Carbon::parse($notification->date)->format('F j, Y g:i
                                                A');
                                            @endphp
                                            @if ($auction && $notification->notification_type == 'auction_bid')
                                                @php
                                                    $user = \App\Models\User::where('id', $bid->user_id)->first();
                                                @endphp
                                                @if ($user->id == Auth::user()->id)
                                                    Your bid has been successfully placed in <a href="{{ url('/auction/' . $auction->id) }}" class="underline hover:text-gray-600">{{ $auction->name }}</a> 
                                                @else
                                                    <a href="{{ url('/user/' . $user->id) }}" class="underline hover:text-gray-600">{{ $user->name }}</a> just made a higher bid in <a href="{{ url('/auction/' . $auction->id) }}" class="underline hover:text-gray-600">{{ $auction->name }}</a> 
                                                @endif
                                            @elseif ($notification->notification_type == 'auction_comment')
                                                @php
                                                    $comment = \App\Models\Comment::where('id', $notification->comment_id)->first();
                                                    $user = \App\Models\User::where('id', $comment->user_id)->first();
                                                    $auction = \App\Models\Auction::where('id', $comment->auction_id)->first();
                                                @endphp
                                                    @if ($user->id == Auth::user()->id)
                                                        Your comment has been successfully submitted to <a href="{{ url('/auction/' . $auction->id) }}" class="underline hover:text-gray-600">{{ $auction->name }}</a> 
                                                    @else
                                                        <a href="{{ url('/user/' . $user->id) }}" class="underline hover:text-gray-600">{{ $user->name }}</a> has posted a comment in <a href="{{ url('/auction/' . $auction->id) }}" class="underline hover:text-gray-600">{{ $auction->name }}</a> 
                                                    @endif
                                            @elseif ($notification->notification_type == 'user_upgrade')
                                                @php
                                                    $user = \App\Models\User::where('id', $notification->receiver_id)->first();
                                                @endphp
                                                    Your account has been promoted! 
                                            @elseif ($notification->notification_type == 'user_downgrade')
                                                @php
                                                    $user = \App\Models\User::where('id', $notification->receiver_id)->first();
                                                @endphp
                                                    Your account has been demoted! 
                                            @elseif ($notification->notification_type == 'auction_paused')
                                                @php
                                                    $auction = \App\Models\Auction::where('id', $notification->auction_id)->first();
                                                @endphp
                                                    <a href="{{ url('/auction/' . $auction->id) }}" class="underline hover:text-gray-600">{{ $auction->name }}</a> has been paused 
                                            @elseif ($notification->notification_type == 'auction_resumed')
                                                @php
                                                    $auction = \App\Models\Auction::where('id', $notification->auction_id)->first();
                                                @endphp
                                                    <a href="{{ url('/auction/' . $auction->id) }}" class="underline hover:text-gray-600">{{ $auction->name }}</a> has resumed 
                                            @elseif ($notification->notification_type == 'auction_approved')
                                                @php
                                                    $auction = \App\Models\Auction::where('id', $notification->auction_id)->first();
                                                @endphp
                                                    Your <a href="{{ url('/auction/' . $auction->id) }}" class="underline hover:text-gray-600">{{ $auction->name }}</a> auction request has been approved! You can start it now! 
                                            @elseif ($notification->notification_type == 'auction_denied')
                                                @php
                                                    $auction = \App\Models\Auction::where('id', $notification->auction_id)->first();
                                                @endphp
                                                    The <a href="{{ url('/auction/' . $auction->id) }}" class="underline hover:text-gray-600">{{ $auction->name }}</a> auction request has been declined! 
                                            @elseif ($notification->notification_type == 'auction_finished')
                                                @php
                                                    $auction = \App\Models\Auction::where('id', $notification->auction_id)->first();
                                                @endphp
                                                    <a href="{{ url('/auction/' . $auction->id) }}" class="underline hover:text-gray-600">{{ $auction->name }}</a> has ended 
                                            @endif
                                        @else
                                            @continue
                                        @endif
                                            <div class="notification-buttons inline flex flex-row justify-between mr-2">
                                                <p class="text-gray-600 text-sm">{{ $formattedDate }} </span>
                                                <div>
                                                    <form action="{{ route('notification.view', $notification->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="btn-view">✔️</button>
                                                    </form>

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