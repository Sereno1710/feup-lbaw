<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



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

    public function viewAllNotifications(){
        $user = Auth::user();
        DB::table('notification')
            ->where('receiver_id', $user->id)
            ->where('viewed', false)
            ->update(['viewed' => true]);
        
        return redirect()->back();
    }

    public function deleteAllNotificationsFromFeed(){
        $user = Auth::user();
        DB::table('notification')
            ->where('receiver_id', $user->id)
            ->where('viewed', false)
            ->update(['viewed' => true]);

        DB::table('notification')
            ->where('receiver_id', $user->id)
            ->where('flag', true)
            ->update(['flag' => false]);
        
            return redirect()->back();
    }
}
