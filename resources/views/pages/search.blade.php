@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8">
    <h1 class="text-3xl font-bold mb-6">Search Results</h1>

    @if($results->isEmpty())
    <p class="text-gray-600">No results found.</p>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
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
{{ $results->appends(['keyword' => $keyword])->links() }}
@endsection