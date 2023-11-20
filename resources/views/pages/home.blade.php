@extends('layouts.app')

@section('content')
    <div class="main-content text-stone-800">
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
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <?php for ($i = 0; $i < 12; $i++): ?>
                @include('partials.card')
                <?php endfor; ?>
            </div>
        </div>
    @endsection
