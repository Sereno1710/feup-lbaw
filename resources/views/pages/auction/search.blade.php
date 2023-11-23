@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8">
    <h1 class="text-3xl font-bold mb-6">Auction Search Results</h1>

    @if($auctions->isEmpty())
    <p class="text-gray-600">No auctions found.</p>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($auctions as $auction)
        @include('partials.card', ['auction' => $auction])
        @endforeach
    </div>
    @endif
</div>
{{ $auctions->appends(['keyword' => $keyword])->links() }}
@endsection