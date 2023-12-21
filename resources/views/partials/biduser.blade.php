<div class=" w-full my-1 p-4 flex flex-row items-center justify-between bg-stone-100 rounded-lg shadow-sm">
    <p class="text-stone-800 text-sm">You bid {{ $bid->amount }} in <a class="underline" href="{{ url('/auction/' . $bid->auction->id) }}">{{ $bid->auction->name }}</a></p>
    <span class="text-stone-500 text-sm">{{ $bid->time }}</span>
</div>
