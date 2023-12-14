@extends('layouts.app')

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
                @php
                    if (Auth::check() && !isset($user)) {
                        $profileImagePath = Auth::user()->profileImagePath();
                    } else {
                        $profileImagePath = $user->profileImagePath();
                    }
                @endphp
                <img class="h-[12rem] w-[12rem] object-cover rounded-full" src="{{ asset($profileImagePath) }}"
                    alt="Profile Picture">
            </div>
            <div class="mx-4 flex flex-col">
                @if (Auth::check() && Auth::user()->id == $user->id)
                    <p class="text-xl">&#64;{{ Auth::user()->username }}</p>
                    <p class="text-2xl">{{ Auth::user()->name }} <a class="mx-2 text-sm underline"
                            href="{{ route('profile.edit') }}">[edit profile]</a></p>
                    @if (Auth::user()->rating == null)
                    @else
                        <p>Rating: {{ Auth::user()->rating }}</p>
                    @endif
                    <p class="text-xl">{{ Auth::user()->biography }}</p>
                @else
                    <p class="text-xl">&#64;{{ $user->username }}</p>
                    <p class="text-2xl">{{ $user->name }}</p>
                    @if ($user->rating == null)
                    @else
                        <p> Rating: {{ $user->rating }}</p>
                    @endif
                    <p class="text-xl">{{ $user->biography }}</p>
                @endif
            </div>
        </div>
        <div class="m-0 mx-auto flex flex-row items-start">
            @if (Auth::check() && Auth::user()->id == $user->id)
                @if ($user->followedAuctions->count() > 0)
                    <div class="m-2 p-4 rounded-lg bg-stone-300">
                        <h3 class="m-4 text-3xl font-bold">Followed Auctions</h3>
                        <div class="grid grid-cols-2 gap-8">
                            @foreach ($user->followedAuctions as $auction)
                                @include('partials.card', ['auction' => $auction])
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($user->ownAuction->count() > 0)
                    <div class="m-2 p-4 rounded-lg bg-stone-300">
                        <h3 class="m-4 text-3xl font-bold">Owned Auctions</h3>
                        <div class="grid grid-cols-2 gap-8">
                            @foreach ($user->ownAuction as $auction)
                                @include('partials.card', ['auction' => $auction])
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                @if ($user->ownPublicAuction->count() > 0)
                    <div class="m-2 p-4 rounded-lg bg-stone-300">
                        <h3 class="m-4 text-3xl font-bold">Owned Auctions</h3>
                        <div class="grid grid-cols-4 gap-8">
                            @foreach ($user->ownPublicAuction as $auction)
                                @include('partials.card', ['auction' => $auction])
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

        </div>
    @endsection
