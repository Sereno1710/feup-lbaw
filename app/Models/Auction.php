<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auction extends Model
{
    protected $table = 'auction';
    public $timestamps  = false;
    protected $fillable = [
        'name','description','initial_price','price','initial_time','end_time','category','owner_id'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public static function activeAuctions() {
        return Auction::where('state', 'active');
    }
}
