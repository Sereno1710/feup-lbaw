<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;


class NotificationController extends Controller
{
    public function viewNotification($id)
    {
        $notification = Notification::findOrFail($id);
        
        DB::table('notification')
            ->where('id', $id)
            ->update(['viewed' => true]);

        return redirect()->back();
    }

    public function deleteNotificationFromFeed($id)
    {
        $notification = Notification::findOrFail($id);
        
        DB::table('notification')
            ->where('id', $id)
            ->update(['flag' => false]);

        DB::table('notification')
            ->where('id', $id)
            ->update(['viewed' => true]);

        return redirect()->back();
    }
}
