@extends('layouts.profile')

@section('content')
    <div>
        <a href="{{ url('/home') }}" class="text-blue-500 hover:underline">Home</a>
        <span class="mx-2"> > </span>
        @if (Auth::check() && !isset($user))
        <span class="text-stone-500">Profile</span>
        @else
        <span class="text-stone-500">{{ $user->name }}</span>
        @endif
    </div>
    <div class="flex flex-col items-center">
        <div class="flex flex-row items-center">
            <div class="user-avatar">
                <img class="rounded-full" src="https://picsum.photos/200" alt="Profile Picture">
            </div>
            <div class="mx-4 flex flex-col">
                @if (Auth::check() && !isset($user))
                    <p class="text-xl">&#64;{{ Auth::user()->username }}</p>
                    <p class="text-2xl">{{ Auth::user()->name }} <a class="mx-2 text-sm underline" href="{{ route('profile.edit') }}">[edit profile]</a></p>
                    @if (Auth::user()->rating == NULL)
                    @else
                        <p>Rating: {{ Auth::user()->rating }}</p>
                    @endif
                    <p class="text-xl">{{ Auth::user()->biography }}</p>
                @else
                    <p class="text-xl">&#64;{{ $user->username }}</p>
                    <p class="text-2xl">{{ $user->name }}</p>
                    @if ($user->rating == NULL)    
                    @else
                        <p> Rating: {{ $user->rating }}</p>
                    @endif
                    <p class="text-xl">{{ $user->biography }}</p>
                @endif
            </div>
        </div>
        <div class="m-0 mx-auto flex flex-row items-center">
            @if (Auth::check() && !isset($user))
                <div class="mx-8 my-4 flex flex-col items-center justify-between p-4 rounded-lg bg-stone-300">
                    <h2 class="mb-4 text-2xl font-bold">Followed Auctions</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        @foreach ($followedAuctions as $auction)
                        @include('partials.card', ['auction' => $auction])
                    @endforeach
                    </div>
                </div>
            @endif
            <div class="mx-8 my-4 flex flex-col items-center justify-between p-4 rounded-lg bg-stone-300">
                <h2 class="mb-4 text-2xl font-bold">Owned Auctions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    @foreach ($ownedAuctions as $auction)
                        @include('partials.card', ['auction' => $auction])
                    @endforeach
                </div>
            </div>
        </div>
        @endsection