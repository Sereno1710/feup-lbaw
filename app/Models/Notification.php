<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    protected $fillable = ['notification_type', 'date', 'viewed','flag','receiver_id', 'bid_id', 'auction_id', 'comment_id'];
    protected $table = 'notification';

    public function ownNotifications($userId) {
        return $this->where('receiver_id', $userId)
            ->orderBy('date', 'desc')
            ->get();
    }
}