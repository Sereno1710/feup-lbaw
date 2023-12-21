<?php
use Carbon\Carbon;

use App\Models\Notification;
use App\Models\Bid;
use App\Models\User;
use App\Models\Auction;
use App\Models\Comment;
?>

<li class="border-b border-black py-2 {{ $notification->viewed ? 'bg-gray-300' : 'text-black' }}">
    @if ($notification->flag)
        @php
            $bid = Bid::where('id', $notification->bid_id)->first();
            $auction = $bid ? $bid->auction : null;
            $notificationDate = \Carbon\Carbon::parse($notification->date);
            $formattedDate = $notificationDate->diffForHumans();
        @endphp
        @if ($auction && $notification->notification_type == 'auction_bid')
            @php
                $user = User::where('id', $bid->user_id)->first();
            @endphp
            @if ($user->id == Auth::user()->id)
                Your bid has been successfully placed in <a href="{{ url('/auction/' . $auction->id) }}"
                    class="underline hover:text-gray-600">{{ $auction->name }}</a>
            @else
                <a href="{{ url('/user/' . $user->id) }}" class="underline hover:text-gray-600">{{ $user->name }}</a>
                just made a higher bid in <a href="{{ url('/auction/' . $auction->id) }}"
                    class="underline hover:text-gray-600">{{ $auction->name }}</a>
            @endif
        @elseif ($notification->notification_type == 'auction_comment')
            @php
                $comment = Comment::where('id', $notification->comment_id)->first();
                $user = User::where('id', $comment->user_id)->first();
                $auction = Auction::where('id', $comment->auction_id)->first();
            @endphp
            @if ($user->id == Auth::user()->id)
                Your comment has been successfully submitted to <a href="{{ url('/auction/' . $auction->id) }}"
                    class="underline hover:text-gray-600">{{ $auction->name }}</a>
            @else
                <a href="{{ url('/user/' . $user->id) }}" class="underline hover:text-gray-600">{{ $user->name }}</a>
                has posted a comment in <a href="{{ url('/auction/' . $auction->id) }}"
                    class="underline hover:text-gray-600">{{ $auction->name }}</a>
            @endif
        @elseif ($notification->notification_type == 'user_upgrade')
            @php
                $user = User::where('id', $notification->receiver_id)->first();
            @endphp
            Your account has been promoted!
        @elseif ($notification->notification_type == 'user_downgrade')
            @php
                $user = User::where('id', $notification->receiver_id)->first();
            @endphp
            Your account has been demoted!
        @elseif ($notification->notification_type == 'auction_paused')
            @php
                $auction = Auction::where('id', $notification->auction_id)->first();
            @endphp
            <a href="{{ url('/auction/' . $auction->id) }}"
                class="underline hover:text-gray-600">{{ $auction->name }}</a> has been paused
        @elseif ($notification->notification_type == 'auction_resumed')
            @php
                $auction = Auction::where('id', $notification->auction_id)->first();
            @endphp
            <a href="{{ url('/auction/' . $auction->id) }}"
                class="underline hover:text-gray-600">{{ $auction->name }}</a> has resumed
        @elseif ($notification->notification_type == 'auction_approved')
            @php
                $auction = Auction::where('id', $notification->auction_id)->first();
            @endphp
            Your <a href="{{ url('/auction/' . $auction->id) }}"
                class="underline hover:text-gray-600">{{ $auction->name }}</a> auction request has been approved! You
            can start it now!
        @elseif ($notification->notification_type == 'auction_denied')
            @php
                $auction = Auction::where('id', $notification->auction_id)->first();
            @endphp
            The <a href="{{ url('/auction/' . $auction->id) }}"
                class="underline hover:text-gray-600">{{ $auction->name }}</a> auction request has been declined!
        @elseif ($notification->notification_type == 'auction_finished')
            @php
                $auction = Auction::where('id', $notification->auction_id)->first();
            @endphp
            <a href="{{ url('/auction/' . $auction->id) }}"
                class="underline hover:text-gray-600">{{ $auction->name }}</a> has ended
        @endif
    @endif
    <div class="notification-buttons inline flex flex-row justify-between mr-2">
        <p class="text-gray-600 text-sm">{{ $formattedDate }} </span>
        <div>
            <form action="{{ route('notification.view', $notification->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn-view">✔️</button>
            </form>

            <form action="{{ route('notification.delete', $notification->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn-delete">❌</button>
            </form>
        </div>
    </div>
</li>
