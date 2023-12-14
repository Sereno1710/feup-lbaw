<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function markAsViewed($id)
    {
        Notification::where(['id' => $id])->update(['viewed' => true]);
    }
}
