<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>SoundSello</title>
    @vite('resources/css/app.css')
    <script src="{{ asset('js/admin.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="flex h-screen">
    
    <div class="bg-stone-800 top-0 bottom-0 w-3/12 p-4">
        <div class="flex items-center justify-center">
            <h1 class="text-white h-20" style="font-size: 20px;"><a href="{{ url('/home') }}">SoundSello</a></h1>
        </div>
        <ul class="text-white flex-1">
            <li class="py-2 px-4 flex items-center"><a href="{{ url('/home') }}">Home Page</a></li>
            <li class="py-2 px-4 flex items-center"><a href="{{url('/admin/users')}}">Users</a></li>
            <li class="py-2 px-4 flex items-center"><a href="{{url('admin/auctions/active')}}">Auctions</a></li>
            @if (Auth::user()->isAdmin())
            <li class="py-2 px-4 flex items-center"><a href="{{url('admin/transfers/withdrawals')}}">Transfers</a></li>
            @endif
            <li class="py-2 px-4 flex items-center"><a href="{{url('admin/reports/listed')}}">Reports</a></li>
        </ul>
    </div>
    <div class="flex-1 w-9/12 p-16 p-4" >
        @yield('nav-bar')
        <main class="flex-1">
            @yield('content')
        </main>
    </div>

</body>

</html>
