<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admin';
    public $timestamps  = false;

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
