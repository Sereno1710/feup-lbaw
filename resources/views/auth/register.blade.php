@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('register') }}" class="m-auto p-8 max-w-xl flex flex-col text-stone-800 bg-white shadow-lg">
    {{ csrf_field() }}

    <label class="mt-2 mb-1" for="username">Username</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
    @if ($errors->has('username'))
        <span class="error">
            {{ $errors->first('username') }}
        </span>
    @endif
    
    <label class="mt-2 mb-1" for="name">Name</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
    @endif

    <label class="mt-2 mb-1" for="email">E-mail:</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" id="email" type="email" name="email" value="{{ old('email') }}" required>
    @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
    @endif

    <label class="mt-2 mb-1" for="password">Password</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" id="password" type="password" name="password" required>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    <label class="mt-2 mb-1" for="password-confirm">Confirm Password</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" id="password-confirm" type="password" name="password_confirmation" required>

    <label class="mt-2 mb-1" for="date_of_birth">Date of Birth</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
    @if ($errors->has('date_of_birth'))
        <span class="error">
            {{ $errors->first('date_of_birth') }}
        </span>
    @endif

    <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">
        Register
    </button>
    <section class="m-2"> Already have an account? <a class="underline" href="{{ route('login') }}">Click here</a> to log in. </section>
    
    <section class="my-4 flex items-center">
        <div class="border-t border-stone-400 flex-grow"></div>
        <span class="mx-4 text-stone-800">or sign up with</span>
        <div class="border-t border-stone-400 flex-grow"></div>
    </section>

    <a href="{{ route('login.google') }}" class="p-2 text-white bg-blue-300 rounded flex items-center justify-center hover:bg-blue-700">
        <img class="mr-2" src="{{ asset('images/icons/googleicon.png') }}" alt="Google Icon" width="20" height="20">
        Google
    </a>
</form>
@endsection
