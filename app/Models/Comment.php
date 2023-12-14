<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{

    public $timestamps = false;
    protected $table='comment';
    protected $fillable = ['user_id', 'auction_id', 'message', 'time'];

    public function user() {
        return $this->belongsTo(User::Class);
    }

    public function auction() {
        return $this->belongsTo('App\Models\Auction');
    }
}
