<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\{MessageSent, Notifications};
use Auth;
use App\User;
use App\Helpers\Helper;
use App\Models\People;
use App\Models\{Department};
use App\Models\Department\Occupation;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Show chats
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $users = Helper::users();
        $departments = Helper::departments();
        $occupations = Occupation::where('department_id', $departments->first()->id)->get();

        return view('chat.index', compact('users', 'departments', 'occupations'));
    }

    public function create($id)
    {
        $user = User::uuid($id);
        return view('chat.conversation', compact('user'));
    }

    /**
    * Fetch all messages
    *
    * @return Message
    */
    public function fetchMessages($id)
    {
        $user = User::find($id);
        $messages = Message::where('user_id', $user->id)->where('receiver_id', Auth::user()->id)
        ->orWhere('receiver_id', $user->id)->where('user_id', Auth::user()->id)->get();

        $messages->map(function($message) {
            $message->read_at = now();
            $message->save();
        });

        return $messages;
    }

    /**
    * Persist message to database
    *
    * @param  Request $request
    * @return Response
    */
    public function sendMessage($id, Request $request)
    {
        $user = User::find($id);

        $message = Auth::user()->messages()->create([
          'message' => $request->input('message'),
          'receiver_id' => $user->id
        ]);

        $messageOnNotifications = Auth::user()->person->name . " te enviou uma mensagem.";

        Helper::drop('messages');

        broadcast(new MessageSent(Auth::user(), $message, $user))->toOthers();
        broadcast(new Notifications($user, $messageOnNotifications))->toOthers();

        return ['status' => 'Mensagem Enviada!'];
    }

    public function masrkAsRead($id, Request $request)
    {
        $message = Message::uuid($id);
        $message->read_at = now();
        $message->save();

        return ['status' => 'read'];
    }

}
