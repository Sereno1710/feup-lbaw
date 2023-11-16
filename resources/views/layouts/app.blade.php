<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-content">
            <h1><a href="{{ url('/home') }}">SoundSello</a></h1>
            <div class="header-buttons">
                <a href="{{ url('/auctions') }}" class="button">View Auctions</a>
                @if (Auth::check())
                    <a href="{{ url('/logout') }}" class="button">Logout</a>
                @else
                    <a href="{{ url('/login') }}" class="button">Sign In</a>
                    <a href="{{ url('/register') }}" class="button">Sign Up</a>
                @endif
            </div>
        </div>
    </header>
    <main>
        <section id="content">
            @yield('content')
        </section>
    </main>
    <footer>
        <div class="footer-content">
            <div class="footer-left">
                <p class="footer-brand">SoundSello</p>
                <ul>
                    <li><a href="{{ url('/about-us') }}">About Us</a></li>
                    <li><a href="{{ url('/faq') }}">FAQ</a></li>
                    <li><a href="{{ url('/contacts') }}">Contacts</a></li>
                    <li><a href="{{ url('/terms-of-use') }}">Terms of Use</a></li>
                    <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-right">
                <p>&copy; 2023</p>
            </div>
        </div>
    </footer>
</body>
</html>