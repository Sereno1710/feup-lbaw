<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @vite('resources/css/app.css')
</head>
<body class="flex h-screen">
    <div class="side-menu bg-red-500 w-1/5 min-h-screen flex flex-col">
        <div class="site-name  flex items-center justify-center">
            <h1 class="text-white h-20" style="font-size: 24px;">SoundSello</h1>
        </div>
        <ul class="text-white">
            <li class="py-2 px-4 flex items-center"><a href="{{ url('/home') }}">Home Page</a></li>
            <li class="py-2 px-4 flex items-center"><a>Users</a></li>
            <li class="py-2 px-4 flex items-center"><a>Auctions</a></li>
            <li class="py-2 px-4 flex items-center"><a>Transfers</a></li>
            <li class="py-2 px-4 flex items-center"><a>Reports</a></li>
        </ul>
    </div>
    <div class="container absolute right-0 w-4/5 h-screen bg-gray-100">
        <div class="header fixed top-0 right-0 w-4/5 h-1/10 bg-white flex items-center justify-center shadow-md z-10">
            <div class="nav w-90 flex items-center">
                <div class="search flex justify-center">
                    <input type="text" placeholder="Search.." class="border-none bg-gray-300 px-4 w-3/4">
                    <button type="submit" class="w-10 h-10 border-none flex items-center justify-center">
                        <img src="search.png" alt="">
                    </button>
                </div>
            </div>
        </div>
    </div>

    
</body>
</html>
