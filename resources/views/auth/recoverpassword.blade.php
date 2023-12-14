@extends('layouts.app')

@section('content')

<form class="m-auto p-8 max-w-xl flex flex-col text-stone-800 bg-white shadow-lg" method="POST"
    action="{{ route('password.sendmail') }}">
    {{ csrf_field() }}

    <h2 class="mb-2 font-bold text-2xl">Recover Password</h2>

    <label class="mt-2 mb-1" for="email">Email:</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" type="email" id="email" name="email"
        value="{{ old('email') }}" required>

    @error('email')
        <span class="error mt-1">
            That email doesn't exist in our database.
        </span>
    @enderror

    <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Reset your password</button>
</form>

@endsection