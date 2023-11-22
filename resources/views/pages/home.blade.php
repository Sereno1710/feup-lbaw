@extends('layouts.app')

@section('content')
    <div class="text-stone-800">
        <div class="mb-8 flex flex-row justify-between items-center">
            <div class="text-2xl ">
                <h2>Welcome to SoundSello.<br>Where bidding hits<br>all the right notes.</h2>
            </div>
            <div class="image">
                <img src="https://cdn.discordapp.com/attachments/806919335356006451/1177017030080204871/30-musicas-de-superacao-que-vao-inspirar-voce.png?ex=6570f987&is=655e8487&hm=431d300755fb9c23b75b85af91304ac98863df7e07ab8f1bc2438f0f3e299494&" alt="Home page photo">
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
