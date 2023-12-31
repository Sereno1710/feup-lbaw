<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionMetaInfoValue extends Model
{
    protected $table = 'auctionmetainfovalue';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'auction_id', 'meta_info_value_id'
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }

    public function metaInfoValue()
    {
        return $this->belongsTo(MetaInfoValue::class, 'meta_info_value_id');
    }
}
