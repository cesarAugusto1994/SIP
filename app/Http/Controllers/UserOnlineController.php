<?php

namespace App\Http\Controllers;

use App\User;
use App\Events\UserOnline;
use Illuminate\Http\Request;

class UserOnlineController extends Controller
{
    public function online($id)
    {
        $user = User::uuid($id);

        $user->status = 'online';
        $user->save();

        broadcast(new UserOnline($user));
    }

    public function __invoke(User $user)
    {
        $user->status = 'online';
        $user->save();

        broadcast(new UserOnline($user));
    }
}
