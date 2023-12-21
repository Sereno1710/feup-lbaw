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

    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-10" onclick="closeBidsPopup()"></div>

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
            <div class="mx-4 flex flex-col items-start">

                <p class="text-2xl">
                    {{ $user->name }} (&#64;{{ $user->username }})
                </p>
                @if (!($user->rating == null))
                    <p class="text-xl">Rating: {{ $user->rating }}</p>
                @endif
                @if (!($user->biography == null))
                    <p class="text-sm mt-2"> {{ $user->biography }}</p>
                @endif
                @if (Auth::check() && Auth::user()->id == $user->id)
                    <div class="mt-2">
                        <a class="mr-2 text-sm text-stone-700 underline" href="{{ route('profile.edit') }}">[edit
                            profile]</a>
                        @if (Auth::user()->ownBids->count() > 0)
                            <button class="text-sm text-stone-700 underline" onclick="showBidsPopup()">[my bidding
                                history]</button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        @if (isset($auctions) && isset($type))
            <div class="flex flex-col m-2 p-4 rounded-lg bg-stone-300">
                <div class="flex flex-row justify-between items-center">
                    <h3 class="m-4 text-3xl font-bold"> {{ $type }} Auctions</h3>
                    <div class="flex flex-row mt-4">
                        @if ($type === 'Followed')
                            <span class="mr-4 py-2 px-4 bg-stone-500 text-white rounded opacity-50 cursor-not-allowed">
                                Followed
                            </span>
                            <a href="{{ route('profile', ['type' => 'owned']) }}"
                                class="py-2 px-4 bg-stone-500 text-white rounded transition duration-300">
                                Owned
                            </a>
                        @elseif($type === 'Owned')
                            <a href="{{ route('profile', ['type' => 'followed']) }}"
                                class="mr-4 py-2 px-4 bg-stone-500 text-white rounded transition duration-300">
                                Followed
                            </a>
                            <span class="py-2 px-4 bg-stone-500 text-white rounded opacity-50 cursor-not-allowed">
                                Owned
                            </span>
                        @endif
                    </div>
                </div>
                <div class="mb-4 grid grid-cols-4 gap-8">
                    @foreach ($auctions as $auction)
                        @include('partials.card', ['auction' => $auction])
                    @endforeach

                </div>
                {{ $auctions->links() }}
            </div>
        @endif
    </div>

    @if (Auth::check() && Auth::user()->id == $user->id)
        <div id="bidsPopup"
            class="hidden fixed flex-col top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 rounded-lg items-center justify-center w-[40rem]">
            <h2 class="mb-2 font-bold text-3xl text-center self-start">Bidding History</h2>
            <div class="w-full px-2 flex flex-col max-h-[42vh] overflow-y-auto items-center">
                @foreach ($user->ownBids as $bid)
                    @include('partials.biduser', ['bid' => $bid])
                @endforeach
            </div>

            <button class="mt-2 mx-2 px-3 py-2 text-stone-500 bg-white border-stone-500 border rounded"
                onclick="closeBidsPopup()">Close</button>
        </div>
    @endif

    <script>
        function showBidsPopup() {
            document.getElementById('overlay').classList.remove('hidden');
            bidsPopup = document.getElementById('bidsPopup');
            bidsPopup.classList.remove('hidden');
            bidsPopup.classList.add('flex');
        }

        function closeBidsPopup() {
            bidsPopup = document.getElementById('bidsPopup');
            if (bidsPopup.classList.contains('flex')) {
                document.getElementById('overlay').classList.add('hidden');
                bidsPopup.classList.remove('flex');
                bidsPopup.classList.add('hidden');
            }
        }
    </script>
@endsection
