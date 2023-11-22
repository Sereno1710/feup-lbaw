<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Auction extends Model
{
    use HasFactory;
    // Don't add create and update timestamps in database.
    protected $table = 'auction';
    public $timestamps  = false;
    protected $fillable = [
        'name','description','initial_price','price','initial_time','end_time','category','owner'
    ];

    public function owned() {
        return $this->belongsTo('App\Models\User', 'owner');
    }

    public function bids() {
        return $this->hasMany('App\Models\Bid', 'auction_id')->orderBy('amount', 'desc');
    }

    public function images() {
        return $this->hasMany('App\Models\AuctionPhoto', 'auction_id')->orderBy('id', 'desc');
    }

    public function comments() {
        return $this->hasMany('App\Models\Comment', 'auction_id')->orderBy('time', 'asc');
    }
    public function auctionWinner() {
        return $this->belongsTo('App\Models\AuctionWinner', 'user_id');
    }

    public static function noActions() {
        return Auction::where('state', 'pending')->orWhere('state', 'finished')->orWhere('state', 'approved')->orWhere('state', 'denied')->orWhere('state', 'disabled')
            ->join('users', 'users.id', '=', 'auction.owner')
            ->select('auction.id', 'users.username', 'auction.initial_price', 'auction.price','auction.state')
            ->get();

    }

    public static function active() {
        return Auction::where('state', 'active')->orWhere('state', 'paused')->orWhere('state', 'pending')
            ->join('users', 'users.id', '=', 'auction.owner')
            ->select('auction.id', 'users.username', 'auction.initial_price', 'auction.price','auction.state')
            ->get();
    }
}
