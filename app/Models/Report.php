<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table='report';
    public $incrementing = false;
    protected $fillable = ['user_id', 'auction_id', 'description', 'time'];
    
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function auction() {
        return $this->belongsTo('App\Models\Auction');
    }
}
