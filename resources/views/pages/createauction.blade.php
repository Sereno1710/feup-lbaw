@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ url('/home') }}" class="text-blue-500 hover:underline">Home</a>
        <span class="mx-2"> > </span>
        <a href="{{ url('/auctions') }}" class="text-blue-500 hover:underline">Auctions</a>
        <span class="mx-2"> > </span>
        <span class="text-stone-500">Submit Auction</span>
    </div>

    <form class="m-2 mx-auto p-8 max-w-xl flex flex-col text-stone-800 bg-white shadow-lg">
        @csrf

        <h2 class="mb-2 font-bold text-2xl">Submit Auction</h2>

        <label class="mt-2 mb-1" for="auction_name">Auction Name:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="auction_name" name="auction_name"
            required>

        <label class="mt-2 mb-1" for="description">Auction Description:</label>
        <textarea class="p-2 mb-2 border border-stone-400 rounded" id="description" name="description" rows="4"
            required></textarea>

        <label class="mt-2 mb-1" for="image">Auction Image:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="file" id="image" name="image" required>

        <label class="mt-2 mb-1" for="starting_price">Starting Price:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="number" min="1" step=".01" id="starting_price"
            name="starting_price" required>


        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Submit Auction</button>
    </form>
@endsection
