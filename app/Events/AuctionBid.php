<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionBid implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bid;
    public $bidder;
    public $message;
    public $auction;

    public function __construct($bid, $bidder, $auction)
    {
        $this->bid = $bid;
        $this->bidder = $bidder;
        $this->auction = $auction;
        $this->message = $bidder->name . 'has just bid' . $bid . 'in' .$auction->name;
    }

    public function broadcastOn(): array
    {   
        $bids = DB::table('Bid')
            ->select('user_id')
            ->where('auction_id', $this->auction->id)
            ->distinct()
            ->pluck('user_id');

        $channels = [
            new PrivateChannel('user.' . $this->bidder->id),
            new PrivateChannel('user.' . $this->auction->owner_id),
            new Channel('auction.' . $this->auction->id),
        ];
        foreach ($bids as $userId) {
            $channels[] = new PrivateChannel('user.' . $userId);
        }
        return $channels;
    }
}
