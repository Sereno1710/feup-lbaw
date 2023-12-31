<?php
use Illuminate\Support\Str;

$bio=Str::limit($user->biography, 26);
?>

<a href="{{ url('/user/' . $user->id) }}">
    <div class="h-96 bg-white text-stone-800 p-2 rounded-lg shadow-lg flex flex-col items-center justify-center">
        <h4 class="font-bold text-xl">{{ $user->name }}</h4>
        <p class="text-gray-500">&#64;{{ $user->username }}</p>
        @php
        $profileImagePath = $user->profileImagePath();
        @endphp
        <img class="h-[12rem] w-[12rem] object-cover rounded-lg" src="{{ asset($profileImagePath) }}"
            alt="User Image 1">
        <p>{{ $bio }}</p>
        @if($user->rating != 0)
        <p>Rating: {{ $user->rating }}</p>
        @endif
    </div>
</a>