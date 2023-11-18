@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="auth-container">
    <form method="POST" action="{{ route('register') }}" class="auth-form">
        {{ csrf_field() }}

        <label for="username">Username</label>
        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
        @if ($errors->has('name'))
            <span class="error">
                {{ $errors->first('name') }}
            </span>
        @endif

        <label for="name">Name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>

        <label for="email">E-Mail Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
            <span class="error">
                {{ $errors->first('email') }}
            </span>
        @endif

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
        @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
        @endif

        <label for="password-confirm">Confirm Password</label>
        <input id="password-confirm" type="password" name="password_confirmation" required>

        <label for="date_of_birth">Date of Birth</label>
        <input id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required>

        <label for="street">Street</label>
        <input id="street" type="text" name="street" value="{{ old('street') }}" required>

        <label for="city">City</label>
        <input id="city" type="text" name="city" value="{{ old('city') }}" required>

        <label for="zip_code">Zip Code</label>
        <input id="zip_code" type="text" name="zip_code" value="{{ old('zip_code') }}" required>

        <label for="country">Country</label>
        <input id="country" type="text" name="country" value="{{ old('country') }}" required>

        <button type="submit"> Register </button>
    </form>
</div>
@endsection
