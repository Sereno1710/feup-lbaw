<?php
use Illuminate\Support\Str;

$bio=Str::limit($user->bio, 30);
?>

<a href="{{ url('/user/' . $user->id) }}">
    <div class="bg-white text-stone-800 p-2 rounded-lg shadow-lg flex flex-col items-center">
        <h4 class="font-bold text-xl">{{ $user->name }}</h4>
        <p class="text-gray-500">&#64;{{ $user->username }}</p>
        <img class="rounded-lg" src="https://picsum.photos/200" alt="User Image 1">
        <p>{{ $bio }}</p>
        @if($user->rating != 0)
        <p>Rating: {{ $user->rating }}</p>
        @endif
    </div>
</a>