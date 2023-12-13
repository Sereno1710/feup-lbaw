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
    use Dispatchable, SerializesModels;

    public $bid;
    public $bidder;
    public $message;
    public $auction;

    public function __construct($bid, $bidder, $auction)
    {
        $this->bid = $bid;
        $this->bidder = $bidder;
        $this->auction = $auction;
        $this->message = $bidder->name . ' has just bid ' . $bid . ' in ' . $auction->name;
    }

    public function broadcastOn(): PrivateChannel
    {   
        return new PrivateChannel('user.' . $this->bidder->id);
    }

    public function broadcastAs() {
        return 'userBid';
    }

}