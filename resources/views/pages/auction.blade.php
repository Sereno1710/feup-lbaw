@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ url('/home') }}" class="text-blue-500 hover:underline">Home</a>
        <span class="mx-2"> > </span>
        <a href="{{ url('/auctions') }}" class="text-blue-500 hover:underline">Auctions</a>
        <span class="mx-2"> > </span>
        <span class="text-stone-500">{{ $auction->name }}</span>
    </div>
    <div class=" m-2 p-4 flex flex-col items-center rounded-lg text-stone-800 bg-white shadow-lg">
        <div class="w-full px-4 py-1 flex flex-row items-end justify-between border-b-2 border-stone-400">
            <div class="flex flex-row items-end">
                <h2 class="text-3xl">{{ $auction->name }}</h2>
                <p class="text-sm mx-5"> STATUS: {{ $auction->state }}
                <p>
            </div>
        </div>
        <div class="mt-4 w-full flex flex-row items-center justify-evenly">
            @php
                $auctionImagePath = $auction->auctionImagePath();
            @endphp
            <img class="m-4 max-h-64 rounded-lg" src="{{ asset($auctionImagePath) }}" alt="auctionphoto">
            @if (auth()->check() && $auction->state === 'active')
                <div class="bg-stone-200 m-2 p-4 flex flex-col rounded-lg">
                    <p><span class="font-bold">Current price:</span>{{ $auction->price }}</p>
                    <form class="flex flex-col" method="POST" action="{{ url('/auction/' . $auction->id . '/bid') }}">
                        @csrf
                        <input class="p-1 bg-stone-50 outline-none rounded-t-lg" type="number" min="1"
                            step=".01" name="amount" placeholder="Bid amount">
                        <button class="p-1 bg-stone-800 text-white rounded-b-lg" type="submit">Bid</button>
                        @if (session('error'))
                            <div class="text-sm text-red-800">
                                {{ session('error') }}
                            </div>
                        @endif
                    </form>
                </div>
            @endif
        </div>
        <div class="w-full flex flex-row items-start justify-between">

            <table class="table-fixed w-full text-left ">
                <tr class="border-b border-stone-300">
                    <th class="border-r border-stone-300">
                        <h3 class="mx-2 my-1">Auction Description</h3>
                    </th>
                    <th>
                        <h3 class="mx-2 my-1">Bidding History</h3>
                    </th>
                </tr>
                <tr>
                    <td class="border-r border-stone-300">
                        <div class="m-2">
                            <p>{{ $auction->description }}</p>
                            <br>
                            <p>Auction Owner: {{ $auction->owner->name }}</p>
                            @if (count($auction->tags) > 0)
                                <div class="my-2 grid grid-cols-3">
                                    @foreach ($auction->tags as $tag)
                                        @include('partials.tag', ['tag' => $tag])
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="m-2 flex flex-col">
                            @foreach ($bids as $bid)
                                @include('partials.bid', ['bid' => $bid])
                            @endforeach
                            <p>Auction started at {{ $auction->initial_price }} euros.</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div>
            <p><span class="auction-remaining-time"></span></p>
            <span class="auction-end-time" hidden>{{ $auction->end_time }}</span>
            <span class="auction-status" hidden>{{ $auction->state }}</span>
        </div>
    </div>

    @if ($auction->state === 'approved')
        <form class="my-8 mx-auto p-8 max-w-xl flex flex-col text-stone-800 bg-stone-200 shadow-lg" method="POST"
            action="{{ url('/auction/' . $auction->id . '/start') }}" enctype="multipart/form-data">
            @csrf

            <h2 class="mb-2 font-bold text-2xl">Start Auction</h2>

            <input class="p-2 bg-stone-50 outline-none rounded-lg" type="number" min="1" step=".01"
                name="days" placeholder="Number of days">

            <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">Start</button>
        </form>
    @endif
@endsection
