@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/editprofile.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="edit-profile-container">
        <h2>Edit Profile</h2>
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="{{ $user->username }}" required>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" required>

            <label for="password">New Password:</label>
            <input type="password" id="password" name="password">

            <label for="street">Street:</label>
            <input type="text" id="street" name="street" value="{{ $user->street }}">

            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="{{ $user->city }}">

            <label for="zip_code">Zip Code:</label>
            <input type="text" id="zip_code" name="zip_code" value="{{ $user->zip_code }}">

            <label for="country">Country:</label>
            <input type="text" id="country" name="country" value="{{ $user->country }}">

            <label for="image">Profile Image:</label>
            <input type="file" id="image" name="image">

            <button type="submit">Save Changes</button>
        </form>
    </div>
@endsection