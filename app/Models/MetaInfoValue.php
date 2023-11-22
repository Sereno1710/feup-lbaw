<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaInfoValue extends Model
{
    protected $table = 'metainfovalue';

    public function metaInfo()
    {
        return $this->belongsTo(MetaInfo::class, 'meta_info_name');
    }
}
