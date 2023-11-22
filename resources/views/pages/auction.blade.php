@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ url('/home') }}" class="text-blue-500 hover:underline">Home</a>
        <span class="mx-2"> > </span>
        <a href="{{ url('/auctions') }}" class="text-blue-500 hover:underline">Auctions</a>
        <span class="mx-2"> > </span>
        <span class="text-stone-500">{{ $auction->name }}</span>
    </div>
    <div class="bg-stone-500 m-2 p-4 flex flex-col items-center rounded-lg shadow-lg">
        <div class="w-full px-4 py-1 flex flex-row items-end justify-between border-b-2 border-stone-400">
            <div class="flex flex-row items-end">
                <h2 class="text-3xl">{{ $auction->name }}</h2>
                <p class="text-sm mx-5"> STATUS: {{ $auction->state }}
                <p>
            </div>
            <!--
                                        <div>
                                            <button>Report</button>
                                            <button>Follow</button>
                                        </div>
                                    -->
        </div>
        <div class="mt-4 w-full flex flex-row items-start justify-evenly">
            <img class="m-4 max-h-64 rounded-lg" src="https://picsum.photos/250" alt="auctionphoto">
            <table class="table-fixed w-full text-left ">
                <tr class="border-b border-stone-400">
                    <th class="border-r border-stone-400">
                        <h3 class="mx-2 my-1">Auction Description</h3>
                    </th>
                    <th>
                        <h3 class="mx-2 my-1">Bidding History</h3>
                    </th>
                </tr>
                <tr>
                    <td class="border-r border-stone-400">
                        <div class="m-2">
                            <p>{{ $auction->description }}</p>
                            <br>
                            <p>Auction Owner: {{ $auction->owner->name }}</p>
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
        <div class="w-full flex flex-row items-start justify-between">
            <div class="flex flex-col mx-4 my-1">
                <h3 class="font-bold">Details</h3>
                <div class="grid grid-cols-3">
                    @foreach ($auction->tags as $tag)
                        @include('partials.tag', ['tag' => $tag])
                    @endforeach
                </div>
            </div>
            <div class="flex flex-col">
                <p><span class="font-bold">Current price:</span>{{ $auction->price }}</p>
                <form class="flex flex-col" method="POST" action="{{ url('/auction/' . $auction->id . '/bid') }}">
                    @csrf
                    <input class="p-1 bg-stone-200 outline-none rounded-t-lg" type="number" min="1" step=".01"
                        name="amount" placeholder="Bid amount">
                    <button class="p-1 bg-stone-800 text-white rounded-b-lg" type="submit">Bid</button>
                    @if (session('error'))
                        <div class="text-sm text-red-800">
                            {{ session('error') }}
                        </div>
                    @endif
                </form>
            </div>
        </div>
        <div>

                 <p>Time remaining:<span class="auction-remaining-time"></span></p>
        </div>
    </div>
@endsection
