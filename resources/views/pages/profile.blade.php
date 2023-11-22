@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ url('/home') }}" class="text-blue-500 hover:underline">Home</a>
        <span class="mx-2"> > </span>
        <span class="text-stone-500">Profile</span>
    </div>
    <div class="flex flex-col items-center">
        <div class="flex flex-row items-center">
            <div class="user-avatar">
                <img class="rounded-full" src="https://picsum.photos/200" alt="Profile Picture">
            </div>
            <div class="mx-4 flex flex-col">
                <p class="text-xl">{{ Auth::user()->email }}</p>
                <p class="text-2xl">{{ Auth::user()->name }} ({{ Auth::user()->username }})<a class="mx-2 text-sm underline"
                        href="{{ route('profile.edit') }}">[edit profile]</a></p>
                <p>{{ Auth::user()->rating }}</p>
            </div>
        </div>
        <div class="m-0 mx-auto flex flex-row items-start">
            <div class="mx-8 my-4 flex flex-col items-center justify-between p-4 rounded-lg bg-stone-300">
                <h2 class="mb-4 text-2xl font-bold">Followed Auctions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    @foreach ($followedAuctions as $auction)
                        @include('partials.card', ['auction' => $auction])
                    @endforeach
                </div>
            </div>

            <div class="mx-8 my-4 flex flex-col items-center justify-between p-4 rounded-lg bg-stone-300">
                <h2 class="mb-4 text-2xl font-bold">Owned Auctions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    @foreach ($ownedAuctions as $auction)
                        @include('partials.card', ['auction' => $auction])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
