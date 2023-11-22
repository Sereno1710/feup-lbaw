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
}
