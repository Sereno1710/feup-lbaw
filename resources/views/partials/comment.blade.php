@php
    $profileImagePath = $comment->user->profileImagePath();
@endphp

<div class="mb-4 p-4 flex flex-col items-start justify-between bg-stone-100 rounded-lg shadow-sm">
    <div class="w-full flex flex-row items-start justify-between">
        <a href="{{ url('/user/' . $comment->user_id) }}" class="flex items-center">
            <div class="h-8 w-8 rounded-full overflow-hidden">
                <img src="{{ asset($profileImagePath) }}" alt="{{ $comment->user->name }}"
                    class="object-cover h-full w-full">
            </div>
            <h4 class="mx-2 text-stone-800 font-bold">{{ $comment->user->name }}</h4>
        </a>
        <span class="text-stone-500 text-sm">{{ $comment->time }}</span>
    </div>
    <div class="w-full flex flex-row items-start justify-between">
        <p class="text-stone-700 mt-2">{{ $comment->message }}</p>
        @if (Auth::check())
            @if ($comment->user->id === Auth::user()->id)
                <button onclick="showDeletePopup()" class="p-1 border border-stone-800 rounded-md">
                    <img class="h-4 w-4" src="{{ asset('images/icons/bin.png') }}" alt="Delete Comment">
                </button>
            @endif
        @endif
    </div>
</div>


<form id="deleteConfirmation" method="POST"
    action="{{ url('/auction/' . $auction->id . '/comment/' . $comment->id . '/delete') }}"
    enctype="multipart/form-data"
    class="hidden flex-col fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 rounded-lg  text-center items-center justify-center z-10">
    @csrf
    <p class="text-black-500 mb-4">Are you sure you want to delete this comment? This action cannot be
        reversed.</p>
    <div class="flex flex-row">
        <button class="m-2 p-2 text-white bg-red-500 rounded" type="sumbit">Delete</button>
        <button class="m-2 p-2 text-stone-500 bg-white border-stone-500 border rounded" type="button"
            onclick="cancelDelete()">Cancel</button>
    </div>
</form>
