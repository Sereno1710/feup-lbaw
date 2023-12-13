@extends('layouts.app')

@section('content')
<script src="{{ asset('js/search_filters.js') }}" defer></script>
<div class="container mx-auto my-8">
    <h1 class="text-3xl font-bold mb-6">Search Results</h1>

    @if($results->isEmpty())
    <p class="text-gray-600">No results found.</p>
    @else

    <div class="flex space-x-4" id="filters">
        <button
            class="button all bg-black border-black text-white hover:bg-gray-600 font-bold py-2 px-4 rounded-full border">All</button>
        <button
            class="button auctions bg-white border-black text-black hover:bg-gray-200 font-bold py-2 px-4 rounded-full border">Auctions</button>
        <button
            class="button users bg-white border-black text-black hover:bg-gray-200 font-bold py-2 px-4 rounded-full border">Users</button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8" id="results">
        @foreach($results as $result)
        @if($result->type === 'auction')
        @include('partials.card', ['auction' => $result])
        @elseif($result->type === 'user')
        @include('partials.user_card', ['user' => $result])
        @endif
        @endforeach
    </div>
    @endif
</div>
{{ $results->appends(['input' => $input])->links() }}
@endsection