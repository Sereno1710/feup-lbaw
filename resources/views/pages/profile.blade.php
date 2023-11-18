@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="profile-container">
        <div class="top-bar">
            <div class="breadcrumbs">
                <a href="{{ url('/home') }}">Home</a> > Profile
            </div>
            <div class="profile-buttons">
                <a href="{{ url('/view-bidding-history') }}" class="button">View Bidding History</a>
                <a href="{{ url('/view-selling-history') }}" class="button">View Selling History</a>
            </div>
            <div class="search-bar">
                <input type="text" placeholder="Search users and auctions">
            <button type="button">Search</button>
        </div>
        </div>

        <div class="profile-info">
            <div class="user-avatar">
            </div>
            <div class="user-details">
                <p>Email: {{ Auth::user()->email }}</p>
                <p>Nome:  {{ Auth::user()->name }} <button>Edit Profile</button></p>
                <p>Rating: {{ Auth::user()->rating }}</p>
            </div>
        </div>
        <div class="auctions-sections">
            <div class="auctions-section">
                <h2>Followed Auctions</h2>
                <div class="featured-auctions-container">
                     @for ($i = 1; $i <= 4; $i++)
                        <div class="auction-card">
                            <img src="auction{{ $i }}.jpg" alt="Auction {{ $i }}">
                            <h4>Auction {{ $i }}</h4>
                            <p>Description of Auction {{ $i }}</p>
                            <a href="#">Bid Now</a>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="auctions-section">
                <h2>Owned Auctions</h2>
                <div class="featured-auctions-container">
                    @for ($i = 5; $i <= 8; $i++)
                        <div class="auction-card">
                            <img src="auction{{ $i }}.jpg" alt="Auction {{ $i }}">
                            <h4>Auction {{ $i }}</h4>
                            <p>Description of Auction {{ $i }}</p>
                            <a href="#">Manage Auction</a>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>        
@endsection
