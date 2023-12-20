<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auction extends Model
{
    protected $table = 'auction';
    public $timestamps = false;
    protected $fillable = [
        'name', 'description', 'initial_price', 'price', 'initial_time', 'end_time', 'category', 'owner_id', 'state'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'auction_id')->orderBy('time', 'desc');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'auction_id')->orderBy('time', 'desc');
    }

    public function tags()
    {
        return $this->belongstoMany(MetaInfoValue::class, 'auctionmetainfovalue', 'auction_id', 'meta_info_value_id');
    }

    public function auctionWinner()
    {
        return $this->hasOne(AuctionWinner::class, 'auction_id');
    }

    public static function activeAuctions()
    {
        return Auction::where('state', 'active');
    }

    public static function others()
    {
        return Auction::where('auction.state', 'finished')->orWhere('auction.state', 'approved')->orWhere('auction.state', 'denied')
            ->join('users', 'users.id', '=', 'auction.owner_id')
            ->select('auction.id', 'users.username', 'auction.name', 'auction.initial_price', 'auction.price', 'auction.state')
            ->paginate(10);

    }

    public static function active()
    {
        return Auction::where('auction.state', 'active')->orWhere('auction.state', 'paused')
            ->join('users', 'users.id', '=', 'auction.owner_id')
            ->select('auction.id', 'users.username', 'auction.owner_id', 'auction.name', 'auction.initial_price', 'auction.price', 'auction.state')
            ->paginate(10);
    }

    public static function pending()
    {
        return Auction::where('auction.state', 'pending')
            ->join('users', 'users.id', '=', 'auction.owner_id')
            ->select('auction.id', 'users.username', 'auction.name', 'auction.initial_price', 'auction.price', 'auction.state')
            ->paginate(10);
    }

    public function auctionImagePath()
    {
        $files = glob("images/auction/" . $this->id . ".jpg", GLOB_BRACE);
        $default = "/images/auction/default.jpg";
        if (sizeof($files) < 1)
            return $default;
        return "/" . $files[0];
    }
}
