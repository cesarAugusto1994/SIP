<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessageBoard;
use App\Models\{Department,People};
use App\Models\MessageBoard\{Category,Type, User, Attachment};
use App\Models\Category as MessageBoardCategory;
use App\Notifications\NewMessage;
use Notification;
use App\Helpers\Helper;
use App\User as UserModel;

class MessageBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Helper::messageBoardCategories();

        $messages = MessageBoard::whereHas('messages', function($query) use($request) {
          $query->where('user_id', $request->user()->id);
        })->orderByDesc('id')->get();

        $messagesWaiting = $messages->filter(function($message) {
            return $message->user->status == 'ENVIADO';
        });

        return view('message.board.index', compact('messages', 'categories', 'messagesWaiting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Helper::departments();
        $categories = Helper::messageBoardCategories();
        $types = Helper::messageBoardTypes();
        return view('message.board.create', compact('departments', 'categories','types'));
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

        $user = $request->user();

        $messageBoard = MessageBoard::create([
            'type_id' => $data['type_id'],
            'subject' => $data['subject'],
            'created_by' => $user->id,
            'content' => $data['content'],
            'important' => $request->has('important'),
            'status' => 'ENVIADO'
        ]);

        if ($request->hasFile('files')) {

            foreach ($request->file('files') as $key => $file) {

                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $path = $file->store('messageboard');

                Attachment::create([
                  'board_id' => $messageBoard->id,
                  'link' => $path,
                  'filename' => $filename,
                  'extension' => $extension,
                ]);
            }


        }

        $departments = $data['departments'];
        $usersList = $data['to'];

        if(in_array(0, $departments) && in_array(0, $usersList)) {

            $users = Helper::users();

        } elseif (in_array(0, $departments) && !in_array(0, $usersList)) {

            $users = UserModel::whereIn('id', $usersList)->get();

        } elseif (!in_array(0, $departments) && !in_array(0, $usersList)) {

            $people = People::whereIn('department_id', $departments)->pluck('id');
            $users = UserModel::whereIn('id', $usersList)->get();

        } elseif (!in_array(0, $departments) && in_array(0, $usersList)) {

            $people = People::whereIn('department_id', $departments)->pluck('id');
            $users = UserModel::whereIn('id', $people)->get();

        } else {

            $users = UserModel::whereIn('id', $usersList)->get();

        }

        foreach ($users as $key => $user) {
            User::create([
              'user_id' => $user->id,
              'board_id' => $messageBoard->id
            ]);
        }

        notify()->flash('Novo Recado Adicionado!', 'success', [
          'text' => 'Novo Recado adicionado com sucesso.'
        ]);

        Notification::send($users, new NewMessage($messageBoard));

        return redirect()->route('message-board.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $messageBoard = MessageBoard::uuid($id);

        if($messageBoard->status == 'PENDENTE' || $messageBoard->status == 'ENVIADO') {
            $messageBoard->status = 'VISUALIZADO';
            $messageBoard->save();
        }

        $categories = Helper::messageBoardCategories();
        return view('message.board.show', compact('messageBoard', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
