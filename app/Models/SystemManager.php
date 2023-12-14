<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SystemManager extends Model
{
    use HasFactory;
    protected $table = 'systemmanager';
    public $timestamps  = false;

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}