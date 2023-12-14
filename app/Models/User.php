<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Admin;
use App\Models\Auction;
use App\Models\Bid;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;
    protected $table = 'users';

    protected $fillable = ['username', 'name', 'email', 'password', 'balance', 'date_of_birth', 'biography', 'street', 'city', 'zip_code', 'country', 'rating', 'image', 'tsvectors',];
    protected $hidden = ['password', 'remember_token',];

    public function isAdmin()
    {
        return count(Admin::where('user_id', $this->id)->get()) > 0;
    }

    public function isBanned()
    {
        return $this->state == 'banned';
    }

    public function isSystemManager()
    {
        return count(SystemManager::where('user_id', $this->id)->get()) > 0;
    }

    public function ownAuction() {
      return $this->hasMany(Auction::class, 'owner_id')->orderBy('state', 'asc');
    }

    public function ownPublicAuction()
    {
        return $this->hasMany(Auction::class, 'owner_id')
            ->where(function ($query) {
                $query->where('state', 'active')->orWhere('state', 'paused')->orWhere('state', 'finished');
            })
            ->orderBy('state', 'asc');
    }

    public function ownBids()
    {
        return $this->hasMany(Bid::class, 'user_id')->orderBy('time', 'desc');
    }

    public function followedAuctions() {
        return $this->belongstoMany(Auction::class, 'follows', 'user_id', 'auction_id');
    }

    public function ownTransfers()
    {
        return $this->hasMany('App\Models\moneys', 'id')->where('user_id', $this->id)->where('state', 'accepted')->orderBy('id', 'desc');
    }

    public static function active()
    {
        return User::where('state', '!=', 'disabled')->orderBy('id', 'asc')->paginate(10);
    }

    public function profileImagePath()
    {
        $files = glob("images/profile/".$this->id.".jpg", GLOB_BRACE);
        $default = "/images/profile/default.jpg";
        if(sizeof($files) < 1) return $default;
        return "/".$files[0];
    }
}
