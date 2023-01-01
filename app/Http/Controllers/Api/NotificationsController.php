<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
    public function index(){
        return auth()->user()->fresh()->unreadNotifications;
    }

    public function dismiss(DatabaseNotification $notification){
        $notification->markAsRead();
    }
}
