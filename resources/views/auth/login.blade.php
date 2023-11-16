@extends('layouts.app')

@section('content')
<div class="auth-container">
    <form method="POST" action="{{ route('login') }}" class="auth-form">
        {{ csrf_field() }}

        <label for="email">Enter your E-mail:</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @if ($errors->has('email'))
            <span class="error">
                {{ $errors->first('email') }}
            </span>
        @endif

        <label for="password">Enter your password:</label>
        <input id="password" type="password" name="password" required>
        @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
        @endif

        <label class="remember-me">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <span>Remember Me</span>
        </label>

        <button type="submit">
            Login
        </button>
        @if (session('success'))
            <p class="success">
                {{ session('success') }}
            </p>
        @endif
    </form>
</div>
@endsection
