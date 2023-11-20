@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')
<div class="container">
    <h1>User Search Results</h1>

    @if($users->isEmpty())
    <p>No users found.</p>
    @else
    <ul>
        @foreach($users as $user)
        <li>
            <h2>{{ $user->name }}</h2>
            <p>{{ $user->username }}</p>
            <p>{{ $user->email }}</p>
        </li>
        @endforeach
    </ul>
    @endif
</div>
@endsection