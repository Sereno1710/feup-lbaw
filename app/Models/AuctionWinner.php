<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuctionWinner extends Model
{
    protected $table = 'auctionwinner';
    public $incrementing = false;
    public $timestamps  = false;

    protected $fillable = [
        'user_id','auction_id', 'rating'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function auction() {
        return $this->belongsTo('App\Models\Auction');
    }
}
