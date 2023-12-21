<a href="{{ url('/user/' . $bid->user_id) }}" class="my-1 flex flex-row items-center">
        @php
            $profileImagePath = $bid->user->profileImagePath();
        @endphp
        <img class="w-[3rem] h-[3rem] rounded-full mr-2 object-cover" src="{{ asset($profileImagePath) }}">
        <p> {{ $bid->user->name }} has bid {{ $bid->amount }}</p>
</a>
