<a href="{{ url('/auction/n/'.$auction->id) }}">
    <div class="bg-white text-stone-800 p-2 rounded-lg shadow-lg flex flex-col items-center">
        <h4 class="font-bold text-xl">{{ $auction->name }}</h4>
        <img class="rounded-lg" src="https://picsum.photos/200" alt="{{ $auction->name }}">
        <p>Current Bid: {{ $auction->price }}</p>
    </div>
</a>