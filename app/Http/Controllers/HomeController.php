<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskLogs;
use App\Models\Process;
use App\User;
use App\Models\Department;
use Auth;
use Redis;
use Redirect;

use Joli\JoliNotif\Notification;
use Joli\JoliNotif\NotifierFactory;
use App\Models\MessageBoard;
use Webklex\IMAP\Client;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if(!$user->hasPermission('view.painel.principal')) {
            return abort(403, 'Acesso Negado.');
        }

        if(!$user->active) {
            Auth::logout();
            return Redirect::route('login')->withErrors('Desculpe, mas o Usuário está desativado, entre em contato com o Administrador.');
        }

        return view('index');
    }

    public function createTasksFromProcesses()
    {
        $dailyProcesses = Process::where('frequency_id', 2)->get();

        $itens = $dailyProcesses->map(function($subprocesses) {
          return $subprocesses->get()->map(function($tasks) {
            return $tasks->get()->map(function($task) {

                if($task->status_id != Task::STATUS_PENDENTE) {

                    $newTask = new Task();
                    $task->description = $task->description;
                    $task->sub_process_id = $task->sub_process_id;
                    $task->user_id = $task->user_id;
                    $task->time = $task->time;
                    $task->method = $task->method;
                    $task->indicator = $task->indicator;
                    $task->client_id = $task->client_id;
                    $task->vendor_id = $task->vendor_id;
                    $task->severity = $task->severity;
                    $task->urgency = $task->urgency;
                    $task->trend = $task->trend;

                }
            });
          });
        });

    }

    public static function getPercetageDoneTasks($concludedInThisMount, $concludedInThisMountWithDelay)
    {
        return round((count($concludedInThisMountWithDelay)/ !empty($concludedInThisMount) ? count($concludedInThisMount) : 1) * 100, 2);
    }

    public static function minutesToHour($time)
    {
        $hours = floor($time / 60);
        $minutes = ($time % 60);

        $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);

        if ($hours < 10) {
           $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
        }

        return "{$hours}:{$minutes}:00";
    }

    public static function intToHour($hour)
    {
        if(empty($hour)) {
            return;
        }

        return "{$hour}:00:00";
    }
}
