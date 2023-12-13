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
    protected $fillable = ['user_id', 'auction_id', 'description', 'time','state'];
    
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function auction() {
        return $this->belongsTo('App\Models\Auction');
    }

    public static function listed(){
        return Report::where('report.state','=','listed')->join('users', 'report.user_id', '=', 'users.id')
            ->join('auction', 'report.auction_id', '=', 'auction.id')
            ->select('users.username', 'auction.name','report.auction_id', 'report.user_id','report.description')
            ->orderBy('report.auction_id', 'asc')
            ->paginate(10);
    }

    public static function reviewed(){
        return Report::where('report.state','!=','listed')->join('users', 'report.user_id', '=', 'users.id')
            ->join('auction', 'report.auction_id', '=', 'auction.id')
            ->select('users.username', 'auction.name','report.auction_id','report.user_id', 'report.description','report.state')
            ->orderBy('report.auction_id', 'asc')
            ->paginate(10);
    }
}
