<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class follows extends Model
{
    public $timestamps = false;
    protected $table='bid';
    protected $fillable = ['user_id', 'auction_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }
}
