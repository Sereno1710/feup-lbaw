@extends('layouts.app')

@section('content')
<div class="top-bar">
    <div class="search-button">
        <a href="{{ url('/users/search') }}">Search Results</a>
    </div>
</div>

<div class="main-content">

    <div class="users-container">
        <div class="users-title">Users</div>
        <div class="users-list">
            <div class="user-card">
                <h4><a href="{{ url('/user/1') }}">User Title 1</a></h4>
                <img src="path/to/user_image_1.jpg" alt="User Image 1">
            </div>

            <div class="user-card">
                <h4><a href="{{ url('/user/2') }}">User Title 2</a></h4>
                <img src="path/to/user_image_2.jpg" alt="User Image 2">
            </div>

            <div class="user-card">
                <h4><a href="{{ url('/user/3') }}">User Title 3</a></h4>
                <img src="path/to/user_image_3.jpg" alt="User Image 3">
            </div>

            <div class="user-card">
                <h4><a href="{{ url('/user/4') }}">User Title 4</a></h4>
                <img src="path/to/user_image_4.jpg" alt="User Image 4">
            </div>
        </div>
    </div>
    @endsection