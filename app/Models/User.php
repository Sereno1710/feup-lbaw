<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Admin;

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

    public function ownAuction() {
      return $this->hasMany('App\Models\Auction', 'owner_id')->orderBy('initial_time', 'desc');
    }

    public function ownBids()
    {
        return $this->hasMany('App\Models\Bid', 'user_id')->orderBy('id', 'desc');
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
        return User::where('is_anonymizing', '!=', 'true')->orderBy('id', 'asc')->paginate(10);
    }
    
}
