@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ url('/home') }}" class="text-blue-500 hover:underline">Home</a>
        <span class="mx-2"> > </span>
        <span class="text-stone-500">Auctions</span>
    </div>
    <div class="m-2 p-4 rounded-lg bg-stone-300">
        <h3 class="m-4 text-3xl font-bold">Active Auctions</h3>
        <div class="grid grid-cols-4 gap-8">
            @foreach ($activeAuctions as $auction)
                @include('partials.card', ['auction' => $auction])
            @endforeach
        </div>
    </div>
@endsection
