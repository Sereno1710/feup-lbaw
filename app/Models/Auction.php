<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auction extends Model
{
    protected $table = 'auction';
    public $timestamps  = false;
    protected $fillable = [
        'name','description','initial_price','price','initial_time','end_time','category','owner_id', 'state'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'auction_id');
    }

    public function tags() 
    {
        return $this->belongstoMany(MetaInfoValue::class, 'auctionmetainfovalue', 'auction_id', 'meta_info_value_id');
    }

    public static function activeAuctions() 
    {
        return Auction::where('state', 'active');
    }

    public static function others() 
    {
        return Auction::where('state', 'finished')->orWhere('state', 'approved')->orWhere('state', 'denied')->orWhere('state', 'disabled')
            ->join('users', 'users.id', '=', 'auction.owner_id')
            ->select('auction.id', 'users.username', 'auction.initial_price', 'auction.price','auction.state')
            ->get();

    }

    public static function active() 
    {
        return Auction::where('state', 'active')->orWhere('state', 'paused')
            ->join('users', 'users.id', '=', 'auction.owner_id')
            ->select('auction.id', 'users.username', 'auction.initial_price', 'auction.price','auction.state')
            ->get();
    }

    public static function pending()
    {
        return Auction::where('state', 'pending')
            ->join('users', 'users.id', '=', 'auction.owner_id')
            ->select('auction.id', 'users.username', 'auction.initial_price', 'auction.price','auction.state')
            ->get();
    }
}
