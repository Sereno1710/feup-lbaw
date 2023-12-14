<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class MetaInfo extends Model
{
    protected $table = 'metainfo';
    public $incrementing = false;
    public $timestamps = false;

    public function values()
    {
        return $this->hasMany(MetaInfoValue::class, 'meta_info_name', 'name');
    }
}
