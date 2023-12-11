@extends('layouts.app')

@section('content')
<div>
    <a href="{{ url('/home') }}" class="text-blue-500 hover:underline">Home</a>
    <span class="mx-2"> > </span>
    <a href="{{ url('/profile') }}" class="text-blue-500 hover:underline">Profile</a>
    <span class="mx-2"> > </span>
    <span class="text-stone-500">Edit Profile</span>
</div>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden"></div>

<form class="m-auto p-8 max-w-xl flex flex-col text-stone-800 bg-white shadow-lg" method="POST"
    action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <h2 class="mb-2 font-bold text-2xl">Edit Profile</h2>

    <label class="mt-2 mb-1" for="username">Username:</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="username" name="username"
        value="{{ $user->username }}" required>

    <label class="mt-2 mb-1" for="name">Name:</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="name" name="name" value="{{ $user->name }}"
        required>

    <label class="mt-2 mb-1" for="email">Email:</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" type="email" id="email" name="email"
        value="{{ $user->email }}" required>

    <label class="mt-2 mb-1" for="password">New Password:</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" type="password" id="password" name="password">

    <label class="mt-2 mb-1" for="biography">Biography:</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="biography" name="biography"
        value="{{ $user->biography }}">

    <label class="mt-2 mb-1" for="street">Street:</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="street" name="street"
        value="{{ $user->street }}">

    <label class="mt-2 mb-1" for="city">City:</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="city" name="city" value="{{ $user->city }}">

    <label class="mt-2 mb-1" for="zip_code">Zip Code:</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="zip_code" name="zip_code"
        value="{{ $user->zip_code }}">

    <label class="mt-2 mb-1" for="country">Country:</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="country" name="country"
        value="{{ $user->country }}">

    <label class="mt-2 mb-1" for="image">Profile Image:</label>
    <input class="p-2 mb-2 border border-stone-400 rounded" type="file" id="image" name="image">

    <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Save Changes</button>

    <p class="mt-4 text-center">
        If you want to delete your account click <span class="text-red-500 cursor-pointer underline" onclick="showDeletePopup()">here</span>.
    </p>

    <div id="deleteConfirmation" class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-md text-center">
            <p class="text-red-500 mb-4">Are you sure you want to delete your account? This action cannot be reversed.</p>
            <button class="mt-2 p-2 text-white bg-red-500 rounded" type="button" onclick="confirmDelete()">Yes, I want to delete my account</button>
            <button class="mt-2 p-2 text-white bg-blue-500 rounded" type="button" onclick="cancelDelete()">Cancel</button>
        </div>
    </div>
</form>

<script>
    function showDeletePopup() {
        document.getElementById('overlay').classList.remove('hidden');
        document.getElementById('deleteConfirmation').classList.remove('hidden');
    }

    function confirmDelete() {
        window.location.href = "{{ route('profile.delete') }}";
    }

    function cancelDelete() {
        document.getElementById('overlay').classList.add('hidden');
        document.getElementById('deleteConfirmation').classList.add('hidden');
    }
</script>
@endsection