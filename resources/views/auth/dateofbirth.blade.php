@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('update.dateofbirth') }}" class="m-auto p-8 max-w-xl flex flex-col text-stone-800 bg-white shadow-lg">
    {{ csrf_field() }}

    <p class="mb-4">Please provide your Date of Birth.</p>
    <p class="mb-4">By clicking 'Register,' you confirm that you are at least 18 years old.</p>
    <p class="mb-4">Providing false information can lead to legal action.</p>

    <input class="p-2 mb-2 border border-stone-400 rounded" id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required>

    <button class="mt-2 p-2 text-white bg-stone-800 rounded" type="submit">
        Register
    </button>
</form>
@endsection