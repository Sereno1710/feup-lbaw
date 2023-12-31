@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ url('/home') }}" class="text-blue-500 hover:underline">Home</a>
        <span class="mx-2"> > </span>
        <a href="{{ url('/profile') }}" class="text-blue-500 hover:underline">Profile</a>
        <span class="mx-2"> > </span>
        <span class="text-stone-500">Edit Profile</span>
    </div>

    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-10"></div>

    <form class="m-auto p-8 max-w-xl flex flex-col text-stone-800 bg-white shadow-lg" method="POST"
        action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h2 class="mb-2 font-bold text-2xl">Edit Profile</h2>

        <label class="mt-2 mb-1" for="username">Username:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="username" name="username"
            value="{{ $user->username }}" required>
        @if ($errors->has('username'))
            <span class="error text-red-500">
                {{ $errors->first('username') }}
            </span>
        @endif

        <label class="mt-2 mb-1" for="name">Name:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="name" name="name"
            value="{{ $user->name }}" required>

        <label class="mt-2 mb-1" for="email">Email:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="email" id="email" name="email"
            value="{{ $user->email }}" required>
        @if ($errors->has('email'))
            <span class="error text-red-500">
                {{ $errors->first('email') }}
            </span>
        @endif

        <label class="mt-2 mb-1" for="current_password">Current Password:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="password" id="current_password"
            name="current_password">
        @if ($errors->has('current_password'))
            <span class="error text-red-500">
                {{ $errors->first('current_password') }}
            </span>
        @endif

        <label class="mt-2 mb-1" for="new_password">New Password:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="password" id="new_password" name="new_password">
        @if ($errors->has('new_password'))
            <span class="error text-red-500">
                {{ $errors->first('new_password') }}
            </span>
        @endif

        <label class="mt-2 mb-1" for="new_password_confirmation">Confirm New Password:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="password" id="new_password_confirmation"
            name="new_password_confirmation">

        <label class="mt-2 mb-1" for="biography">Biography:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="biography" name="biography"
            value="{{ $user->biography }}">

        <label class="mt-2 mb-1" for="street">Street:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="street" name="street"
            value="{{ $user->street }}">

        <label class="mt-2 mb-1" for="city">City:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="city" name="city"
            value="{{ $user->city }}">

        <label class="mt-2 mb-1" for="zip_code">Zip Code:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="zip_code" name="zip_code"
            value="{{ $user->zip_code }}">

        <label class="mt-2 mb-1" for="country">Country:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="country" name="country"
            value="{{ $user->country }}">

        <label class="mt-2 mb-1" for="image">Profile Image:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="file" id="image" name="image">

        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Save Changes</button>

        <p class="mt-4 text-center" id="delete_profile">
            If you want to delete your account click <button user_id="{{ Auth::user()->id}}" balance="{{ Auth::user()->balance}}" class="text-black-500 cursor-pointer underline delete-profile-btn" type="button">here</button>.
        </p>
    </form>
@endsection
