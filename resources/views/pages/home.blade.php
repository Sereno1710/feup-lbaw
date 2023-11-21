@extends('layouts.app')

@section('content')
    <div class="text-stone-800">
        <div class="mb-8 flex flex-row justify-between items-center">
            <div class="text-2xl ">
                <h2>Welcome to SoundSello.<br>Where bidding hits<br>all the right notes.</h2>
            </div>
            <div class="image">
                <img src="https://picsum.photos/500/300" alt="Auction Image 1">
            </div>
        </div>

        <div class="p-4 rounded-lg bg-stone-300">
            <h3 class="m-4 text-3xl font-bold">Featured Auctions</h3>
            <div class="grid grid-cols-4 gap-8">
                @foreach ($featuredAuctions as $auction)
                    @include('partials.card', ['auction' => $auction])
                @endforeach
            </div>
        </div>
    @endsection
