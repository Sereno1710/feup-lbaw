@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('login') }}" class="m-auto p-8 max-w-xl flex flex-col text-stone-800 bg-white shadow-lg">
    {{ csrf_field() }}

    <label class="mt-2 mb-1" for="email">E-mail:</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
    @endif

    <label class="mt-2 mb-1" for="password">Password:</label>
    <input class="p-2 border border-stone-400 rounded" id="password" type="password" name="password" required>
    <section class="mb-2"> Forgot your password? Reset it <a class="underline" href="{{ route('password.recover') }}">here</a>.</section>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    <label class="my-2 flex">
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
        <span class="ml-2">Remember Me</span>
    </label>

    <button type="submit" class="p-2 text-white bg-stone-800 rounded">
        Login
    </button>
    @if (session('success'))
        <p class="success">
            {{ session('success') }}
        </p>
    @endif
    <section class="m-2"> Don't have an account? Sign up <a class="underline" href="{{ route('register') }}">here</a>. </section> 
    
    </section>
</form>
@endsection
