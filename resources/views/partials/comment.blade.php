@php
    $profileImagePath = $comment->user->profileImagePath();
@endphp

<div class="mb-4 p-4 bg-stone-100 rounded-lg">
    <div class="flex flex-col items-start justify-between">
        <div class="w-full flex flex-row items-start justify-between">
            <div class="flex items-center">
                <div class="h-8 w-8 rounded-full overflow-hidden">
                    <img src="{{ asset($profileImagePath) }}" alt="{{ $comment->user->name }}"
                        class="object-cover h-full w-full">
                </div>
                <h4 class="mx-2 text-stone-800 font-bold">{{ $comment->user->name }}</h4>
            </div>
            <span class="text-stone-500 text-sm">{{ $comment->time }}</span>
        </div>
        <div class="w-full flex flex-row items-start justify-between">
            <p class="text-stone-700 mt-2">{{ $comment->message }}</p>
            @if (Auth::check())
                @if ($comment->user->id === Auth::user()->id)
                    <form method="POST"
                        action="{{ url('/auction/' . $comment->auction_id . '/comment/' . $comment->id . '/delete') }}">
                        @csrf
                        <button type="submit" class="p-1 border border-stone-800 rounded-md">
                            <img class="h-4 w-4" src="{{ asset('images/icons/bin.png') }}" alt="Delete Comment">
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>
</div>
