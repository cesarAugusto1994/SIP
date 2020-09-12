<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $this->markAsRead();

        $today = $yesterday = $older = [];

        $yesterdayDate = now()->modify('-1 day');

        foreach($user->notifications as $notification) {
            if($notification->created_at >= now()->format('Y-m-d '). '00:00:00') {
              $today[] = $notification;
            }
            if($notification->created_at >= $yesterdayDate->format('Y-m-d '). '00:00:00' &&
                $notification->created_at <= $yesterdayDate->format('Y-m-d '). '23:59:59') {
                  $yesterday[] = $notification;
            }
            if($notification->created_at < $yesterdayDate->format('Y-m-d '). '00:00:00') {
                  $older[] = $notification;
            }
        }

        return view('notifications.index', compact('user', 'today', 'yesterday', 'older'));
    }

    public function markAsRead()
    {
        $user = Auth::user();

        $user->unreadNotifications->markAsRead();

        notify()->flash('Ok', 'info', [
          'text' => 'Não possui notificações pendentes de visualização.'
        ]);
    }
}
