<div class="my-1 flex flex-row items-center">
    @php
        $profileImagePath = $bid->user->profileImagePath();
    @endphp
    <img class="rounded-full mr-2" src="{{ asset($profileImagePath) }}">
    <p> {{ $bid->user->name }} has bid {{ $bid->amount }}</p>
</div>
