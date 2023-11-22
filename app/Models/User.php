<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Admin;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps = false;
    protected $table='users';

    protected $fillable = ['username', 'name', 'email', 'password', 'balance', 'date_of_birth', 'street', 'city', 'zip_code', 'country', 'rating', 'image', 'tsvectors',];
    protected $hidden = ['password', 'remember_token',];

    public function isAdmin() {
        return count(Admin::where('user_id', $this->id)->get()) > 0;
    }

    public function ownAuction() {
      return $this->hasMany('App\Models\Auction', 'owner')->orderBy('initial_time', 'desc');
    }

    public function ownBids() {
        return $this->hasMany('App\Models\Bid', 'user_id')->orderBy('id', 'desc');
    }

    public function followedAuctions() {
        return $this->hasMany('\App\Models\Auctions','user_id')->where('user_id', $this->id)->orderBy('end_time', 'asc');
    }

    public function ownTransfers() {
        return $this->hasMany('App\Models\moneys','id')->where('user_id', $this->id)->where('state','accepted')->orderBy('id', 'desc');
    }

    public static function activeUsers() {
        return User::leftJoin('admin', 'users.id', '=', 'admin.user_id')->whereNull('admin.user_id')->orderBy('id','asc')->get();
    }
    
    public static function activeAdmins() {
        return User::join('admin', 'users.id', '=', 'admin.user_id')->orderBy('id','asc')->get();
    }
}
