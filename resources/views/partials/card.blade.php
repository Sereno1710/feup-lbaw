<a href="{{ url('/auction/1') }}">
    <div class="bg-white text-stone-800 p-2 rounded-lg shadow-lg flex flex-col items-center">
        <h4 class="font-bold text-xl">{{ $auction->name }}</h4>
        <p class="text-gray-500">Category: {{ $auction->category }}</p>
        <img class="rounded-lg" src="https://picsum.photos/200" alt="Auction Image 1">
        <p class="font-bold">Current Bid: {{ $auction->price }}</p>
        <p><span class="auction-remaining-time"></span></p>
        <span class="auction-end-time" hidden>{{ $auction->end_time }}</span>

    </div>
</a>