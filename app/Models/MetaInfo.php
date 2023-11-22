<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaInfo extends Model
{
    protected $table = 'metainfo';
    public $incrementing = false;
    public $timestamps = false;

    public function metaInfoValues()
    {
        return $this->hasMany(MetaInfoValue::class, 'meta_info_name');
    }
}
