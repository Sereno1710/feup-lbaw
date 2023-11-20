@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Auction Search Results</h1>

    @if($auctions->isEmpty())
    <p>No auctions found.</p>
    @else
    <ul>
        @foreach($auctions as $auction)
        <li>
            <h2>{{ $auction->name }}</h2>
            <p>{{ $auction->description }}</p>
            <p>{{ $auction->category }}</p>
            <p>{{ $auction->price }}</p>
            <p>{{ $auction->end_time }}</p>
        </li>
        @endforeach
    </ul>
    @endif
</div>
@endsection