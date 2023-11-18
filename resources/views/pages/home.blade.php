@extends('layouts.app')

@section('content')
<div class="top-bar">
    <div class="home-button">
        <a href="{{ url('/home') }}">Home</a>
    </div>
    <form action="/users/search" method="GET">
        <input type="text" name="keyword" placeholder="Search users">
        <button type="submit">Search</button>
    </form>
</div>

<div class="main-content">
    <div class="top-row">
        <div class="slogan">
            <h2>Welcome to SoundSello, where bidding hits all the right notes</h2>
        </div>
        <div class="image">

        </div>
    </div>

    <div class="featured-auctions-container">
        <div class="featured-auctions-title">Featured Auctions</div>
        <div class="featured-auctions-grid">
            <div class="auction-card">
                <h4><a href="{{ url('/auction/1') }}">Auction Title 1</a></h4>
                <img src="path/to/auction_image_1.jpg" alt="Auction Image 1">
                <p>Current Bid: $100</p>
            </div>

            <div class="auction-card">
                <h4><a href="{{ url('/auction/2') }}">Auction Title 2</a></h4>
                <img src="path/to/auction_image_2.jpg" alt="Auction Image 2">
                <p>Current Bid: $150</p>
            </div>

            <div class="auction-card">
                <h4><a href="{{ url('/auction/3') }}">Auction Title 3</a></h4>
                <img src="path/to/auction_image_3.jpg" alt="Auction Image 3">
                <p>Current Bid: $120</p>
            </div>

            <div class="auction-card">
                <h4><a href="{{ url('/auction/4') }}">Auction Title 4</a></h4>
                <img src="path/to/auction_image_4.jpg" alt="Auction Image 4">
                <p>Current Bid: $200</p>
            </div>
        </div>
    </div>
    @endsection