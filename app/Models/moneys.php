<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class moneys extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table='moneys';
    protected $fillable = ['user_id', 'amount','type', 'time'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function pending() {
        return moneys::join('users', 'moneys.user_id', '=', 'users.id')
            ->select('moneys.id', 'users.username', 'moneys.amount')
            ->where('moneys.state', 'pending')
            ->orderBy('moneys.id', 'asc')
            ->get();
    }

    public static function deposits() {
        return moneys::where('type', true)
            ->where('moneys.state', 'pending')->join('users', 'moneys.user_id', '=', 'users.id')
            ->select('moneys.id', 'users.username', 'moneys.amount')
            ->where('moneys.state', 'pending')
            ->orderBy('moneys.id', 'asc')
            ->get();
    }

    public static function withdrawals() {
        return moneys::where('type', false)
            ->where('moneys.state', 'pending')->join('users', 'moneys.user_id', '=', 'users.id')
            ->select('moneys.id', 'users.username', 'moneys.amount')
            ->where('moneys.state', 'pending')
            ->orderBy('moneys.id', 'asc')
            ->get();
    }

    public static function notPending() {
        return moneys::where('moneys.state','!=', 'pending')
            ->join('users', 'moneys.user_id', '=', 'users.id')
            ->select('moneys.id', 'users.username', 'moneys.amount', 'moneys.state')
            ->orderBy('moneys.id', 'asc')
            ->get();
    }
}
