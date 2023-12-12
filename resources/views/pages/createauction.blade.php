@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ url('/home') }}" class="text-blue-500 hover:underline">Home</a>
        <span class="mx-2"> > </span>
        <a href="{{ url('/auctions') }}" class="text-blue-500 hover:underline">Auctions</a>
        <span class="mx-2"> > </span>
        <span class="text-stone-500">Submit Auction</span>
    </div>

    <form class="m-auto p-8 max-w-xl flex flex-col text-stone-800 bg-white shadow-lg" method="POST"
        action="{{ route('auction.create') }}" enctype="multipart/form-data">
        @csrf

        <h2 class="mb-2 font-bold text-2xl">Submit Auction</h2>

        <label class="mt-2 mb-1" for="auction_name">Auction Name:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="text" id="auction_name" name="auction_name"
            required>

        <label class="mt-2 mb-1" for="description">Auction Description:</label>
        <textarea class="p-2 mb-2 border border-stone-400 rounded" id="description" name="description" rows="4" required></textarea>

        <label class="mt-2 mb-1" for="image">Auction Image:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="file" id="image" name="image">

        <label class="mt-2 mb-1" for="category">Auction Category:</label>
        <select class="p-2 mb-2 border border-stone-400 rounded" id="category" name="category" required>
            <option value="strings">Strings</option>
            <option value="woodwinds">Woodwinds</option>
            <option value="brass">Brass</option>
            <option value="percussion">Percussion</option>
        </select>

        <label class="mt-2 mb-1" for="starting_price">Starting Price:</label>
        <input class="p-2 mb-2 border border-stone-400 rounded" type="number" min="1" step=".01"
            id="starting_price" name="starting_price" required>

        <label class="mt-2 mb-1" for="categories">Select Categories:</label>
        @foreach ($metaInfos as $metaInfo)
            <div class="mb-2">
                <p>{{ $metaInfo->name }}</p>
                <select class="w-full p-2 mb-2 border border-stone-400 rounded" id="category_{{ $metaInfo->name }}" name="categories[{{ $metaInfo->name }}]">
                    <option value="" selected>None</option>
                    @foreach ($metaInfo->values as $value)
                        <option value="{{ $value->id }}">{{ $value->value }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach

        <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Submit Auction</button>
        @if (session('error'))
            <div class="text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif
    </form>
@endsection
