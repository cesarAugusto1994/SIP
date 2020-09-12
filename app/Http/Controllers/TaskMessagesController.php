<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task\Message;
use App\Models\Task;
use Auth;

class TaskMessagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->request->all();

        $task = Task::uuid($data['task']);

        $message = new Message();
        $message->message = $data['message'];
        $message->user_id = Auth::user()->id;
        $message->task_id = $task->id;

        $message->save();

        return redirect()->route('tasks.show', $task->uuid);
    }
}
