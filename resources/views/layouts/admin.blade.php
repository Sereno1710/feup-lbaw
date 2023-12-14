<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>SoundSello</title>
    @vite('resources/css/app.css')
    <script src="{{ asset('js/admin.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="flex">

    <div class="bg-stone-800 w-3/14 p-4 sticky top-0 h-screen fixed">
        <div class="flex items-center justify-center">
            <h1 class="text-white h-20" style="font-size: 24px; font-bold"><a href="{{ url('/home') }}">SoundSello</a></h1>
        </div>
        <ul class="text-white flex-1 overflow-y-auto">
            <li class="py-2 px-4 flex items-center"><a href="{{ url('/home') }}">Home Page</a></li>
            <li class="py-2 px-4 flex items-center"><a href="{{url('/admin/users')}}">Users</a></li>
            <li class="py-2 px-4 flex items-center"><a href="{{url('admin/auctions/active')}}">Auctions</a></li>
            @if (Auth::user()->isAdmin())
                <li class="py-2 px-4 flex items-center"><a href="{{url('admin/transfers/withdrawals')}}">Transfers</a></li>
            @endif
            <li class="py-2 px-4 flex items-center"><a href="{{url('admin/reports/listed')}}">Reports</a></li>
        </ul>
    </div>
    <div class="flex-1 w-11/14">
        <div class="bg-stone-300 sticky top-0 right-0 w-screen h-15 fixed">
        @yield('nav-bar')
        </div>
        <main class="flex-1">
            @yield('content')
        </main>
    </div>

</body>

</html>
