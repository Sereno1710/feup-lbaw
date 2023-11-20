<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;
    protected $table='bids';
    protected $fillable = ['user_id', 'auction_id', 'amount', 'time', 'state'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function auction() {
        return $this->belongsTo('App\Models\Auction');
    }
}
