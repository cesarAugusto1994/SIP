<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessageBoard;
use App\Models\MessageBoard\User as MessageBoardUser;
use App\Models\{Department,People};
use App\Models\MessageBoard\{Category,Type, User, Attachment};
use App\Models\Category as MessageBoardCategory;
use App\Notifications\NewMessage;
use Notification;
use Storage;
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

            array_push($usersList, auth()->user()->id);

            $users = UserModel::whereIn('id', $usersList)->get();

        } elseif (!in_array(0, $departments) && !in_array(0, $usersList)) {

            array_push($usersList, auth()->user()->id);

            $people = People::whereIn('department_id', $departments)->pluck('id');
            $users = UserModel::whereIn('id', $usersList)->get();

        } elseif (!in_array(0, $departments) && in_array(0, $usersList)) {

            $people = People::whereIn('department_id', $departments)->pluck('id');
            $people->push(auth()->user()->person->id);

            $users = UserModel::whereIn('person_id', $people)->get();

        } else {

            array_push($usersList, auth()->user()->id);

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
        $user = auth()->user();

        $messageUser = MessageBoardUser::where('board_id', $messageBoard->id)->where('user_id', $user->id)->first();

        if($messageUser) {
            $messageUser->status = 'VISUALIZADO';
            $messageUser->save();
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
        try {

          $messageBoard = MessageBoard::uuid($id);

          $messageBoard->messages()->delete();

          $messageBoard->attachments->map(function($attach) {

            if(Storage::exists($attach->link)) {
                Storage::delete($attach->link);
            }

            $attach->delete();

          });

          $route = route('message-board.index');

          $messageBoard->delete();

          return response()->json([
            'success' => true,
            'message' => 'Mensagem removida com sucesso.',
            'route' => $route
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'route' => route('message-board.index')
          ]);
        }
    }
}
