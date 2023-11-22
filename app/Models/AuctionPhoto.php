<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuctionPhoto extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table='auction_photo';
    protected $fillable = ['auction_id', 'photo'];

    public function auction() {
        return $this->belongsTo('App\Models\Auction');
    }
}
