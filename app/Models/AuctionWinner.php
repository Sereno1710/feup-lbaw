<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuctionWinner extends Model
{
    use HasFactory;
    protected $table = 'auctionWinner';
    public $timestamps  = false;

    protected $fillable = [
        'user_id','auction_id','amount', 'rating'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function auction() {
        return $this->belongsTo('App\Models\Auction');
    }
}
