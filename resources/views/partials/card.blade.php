<?php
use Illuminate\Support\Str;

$description=Str::limit($auction->description, 30);
?>

<a href="{{ url('/auction/' . $auction->id) }}">
    <div class="h-96 bg-white text-stone-800 p-2 rounded-lg shadow-lg flex flex-col items-center justify-center">
        <h4 class="font-bold text-xl">{{ $auction->name }}</h4>
        <p class="text-gray-500">Category: {{ $auction->category }}</p>
        @php
            $auctionImagePath = $auction->auctionImagePath();
        @endphp
        <img class="rounded-lg" src="{{ asset($auctionImagePath) }}" alt="Auction Image 1">
        <p>{{ $description }}</p>
        <p class="font-bold">Current Bid: {{ $auction->price }}</p>
        <p><span class="auction-remaining-time"></span></p>
        <span class="auction-end-time" hidden>{{ $auction->end_time }}</span>
        <span class="auction-status" hidden>{{ $auction->state }}</span>
    </div>
</a>