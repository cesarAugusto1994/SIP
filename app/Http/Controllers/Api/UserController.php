<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $user = User::find(2);

        return response()->json([
          'id' => $user->uuid,
          'nick' => $user->nick,
          'name' => $user->person->name,
          'email' => $user->name,
          'avatar' => route('image', ['link' => $user->avatar, 'avatar' => true])
        ]);

    }
}
