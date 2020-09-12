<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Schedule\Message;

class ScheduleMessageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            if(!$request->filled('schedule_id')) {
                throw new \Exception("Código do Compromisso não encontrado.", 1);
            }

            $data = $request->request->all();
            $user = $request->user();

            $schedule = Schedule::uuid($data['schedule_id']);

            $data['user_id'] = $user->id;
            $data['schedule_id'] = $schedule->id;

            Message::create($data);

            return response()->json([
              'success' => true,
              'message' => 'Mensagem adicionada com sucesso.'
            ]);

        } catch(\Exception $e) {

            return response()->json([
              'success' => false,
              'message' => 'Ocorreu um erro ao adicionar a mensagem'
            ]);

        }
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

            $message = Message::uuid($id);
            $message->delete();

            return response()->json([
              'success' => true,
              'message' => 'Mensagem apagada com sucesso.'
            ]);

        } catch(\Exception $e) {

            return response()->json([
              'success' => false,
              'message' => 'Ocorreu um erro ao remover a mensagem'
            ]);

        }
    }
}
