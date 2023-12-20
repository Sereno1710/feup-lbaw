<div class=" w-full my-1 p-4 flex flex-row items-center bg-stone-100 rounded-lg shadow-sm">
    @php
        $profileImagePath = $bid->user->profileImagePath();
    @endphp
    <a class="w-[4rem] h-[3rem] mr-1" href="{{ url('/user/' . $bid->user_id) }}">
        <img class="w-[3rem] h-[3rem] rounded-full object-cover" src="{{ asset($profileImagePath) }}">
    </a>
    <div class="w-full flex flex-col items-start">
      <div class=" w-full flex flex-row justify-between items-center">
        <a href="{{ url('/user/' . $bid->user_id) }}" class="font-bold text-lg"> {{ $bid->user->name }}</a>
        <span class="text-stone-500 text-sm">{{ $bid->time }}</span>
      </div>
        <p class="text-stone-800 text-sm">Bidded {{ $bid->amount }}</p>
    </div>
</div>
