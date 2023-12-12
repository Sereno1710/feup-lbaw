@extends('layouts.profile')

@section('content')
<div class="container mx-auto my-8">
    <h1 class="text-3xl font-bold mb-6">User Search Results</h1>

    @if($users->isEmpty())
    <p class="text-gray-600">No users found.</p>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-8">
        @foreach($users as $user)
        @include('partials.user_card', ['user' => $user])
        @endforeach
    </div>
    @endif
</div>
{{ $users->appends(['keyword' => $keyword])->links() }}
@endsection