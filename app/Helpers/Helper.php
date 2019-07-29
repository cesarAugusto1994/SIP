<?php

namespace App\Helpers;

use Auth;
use Session;
use App\User;
use App\Models\Training\Course;
use App\Models\{People, Menu, Client};
use App\Models\Task\Status as TicketStatus;
use App\Models\Ticket\{Type,Status};
use App\Models\{Department, Module};
use App\Models\Department\Occupation;
use App\Models\Ticket\Type\Category;
use App\Models\{Unit,Email};
use App\Models\Schedule\Type as ScheduleType;
use App\Models\{Message, Folder, Ticket, Task};
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Models\Category as MessageBoardCategory;
use App\Models\MessageBoard\Type as MessageBoardType;

/**
 *
 */
class Helper
{
    public static function slug($key)
    {
        $user = Auth::user();
        return (string)$user->id.'-'.$key;
    }

    public static function has($key)
    {
        $slug = self::slug($key);
        return Session::exists($slug);
    }

    public static function get($key)
    {
        $slug = self::slug($key);
        return Session::get($slug);
    }

    public static function set($key, $value)
    {
        $slug = self::slug($key);
        return Session::put($slug, $value);
    }

    public static function create($key, $value)
    {
        $slug = self::slug($key);
        Session::put($slug, $value);
        return Session::get($slug);
    }

    public static function drop($key)
    {
        $slug = self::slug($key);
        return Session::forget($slug);
    }

    public static function usedSpace()
    {
        $path = config('app.env') == 'production' ? '/home/defaultwebsite/' : '/';
        $used = disk_total_space($path) - disk_free_space($path);
        return self::formatBytesToSize($used);
    }

    public static function totalSpace()
    {
        $path = config('app.env') == 'production' ? '/home/defaultwebsite/' : '/';
        return self::formatBytes(disk_total_space($path));
    }

    public static function formatBytesToSize($size = 0, $precision = 2)
    {
        $base = log($size, 1024);

        if($base < 0) {
          return '0 Kb';
        }

        return round(pow(1024, $base - floor($base)), $precision);
    }

    public static function formatBytes($size = 0, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('bytes', 'Kb', 'Mb', 'Gb', 'Tb');

        return self::formatBytesToSize($size, $precision) .' '. $suffixes[floor($base)];
    }

    public static function formatTime($time = 1, $format = 'hour')
    {
        $stringFormat = 'Hora(s)';

        switch($format) {
          case 'day':
            $stringFormat = 'Dia(s)';
          break;
          case 'minute':
            $stringFormat = 'Minuto(s)';
          break;
        }

        return $time . ' ' . $stringFormat;
    }

    public static function ociousTime($mapperID)
    {
        $mapper = \App\Models\Mapper::find($mapperID);

        $user = User::find($mapper->user->id);

        $week = 44;
        $days = 5;

        $time = ($week) * 60;

        $minutes = 0;

        $tasks = $mapper->tasks->filter(function($task) {
            return $task->status->id == 2 || $task->status->id == 3;
        });

        foreach ($tasks as $key => $task) {

          switch($task->time_type) {
            case 'day':
                $minutes += $task->time % 24;
            break;
            case 'minute':
                $minutes += $task->time % 60;
            break;
            default:
                $minutes += $task->time % 60;
            break;
          }

        }

        $rest = $minutes;

        if(0 > $rest) {
          echo '<span class="label label-primary"><i class="fa fa-thumbs-up"></i> Sem tempo ocioso.</span>';
          return;
        }

        return self::minutesToHour($rest);
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

    public static function taskTimeToHour($tasks)
    {
        $hour = 0;
        $minutes = 0;
        $seconds = 0;

        foreach ($tasks as $key => $task) {

          switch($task->time_type) {
            case 'day':
                $hour += $task->time*24;
            break;
            case 'minute':

                if($task->time < 60) {

                    $minutes += $task->time;

                } else {

                    $hour += floor($task->time/60);
                    $minutes += $task->time % 60;

                }

            break;
            default:
                $hour += $task->time;
            break;
          }

        }

        return $hour . ':' . $minutes;
    }

    public static function ticketsTotal()
    {
        $key = 'tickets-total';

        if(self::has($key)) {
            return self::get($key);
        }

        $user = auth()->user();

        if($user->isAdmin()) {
            $data = Ticket::count();
        } else {
            $data = Ticket::where('user_id', $user->id)->count();
        }

        self::set($key, $data);
        return self::get($key);
    }

    public static function ticketsClosedTotal()
    {
        $key = 'tickets-closed-total';

        if(self::has($key)) {
            return self::get($key);
        }

        $user = auth()->user();

        if($user->isAdmin()) {
            $data = Ticket::where('status_id', 4)->count();
        } else {
            $data = Ticket::where('status_id', 4)->where('user_id', $user->id)->count();
        }

        self::set($key, $data);
        return self::get($key);
    }

    public static function tasksTotal()
    {
        $key = 'tasks-total';

        if(self::has($key)) {
            return self::get($key);
        }

        $user = auth()->user();

        if($user->isAdmin()) {
            $data = Task::count();
        } else {
            $data = Task::where('user_id', $user->id)->count();
        }

        self::set($key, $data);
        return self::get($key);
    }

    public static function tasksClosedTotal()
    {
        $key = 'tasks-closed-total';

        if(self::has($key)) {
            return self::get($key);
        }

        $user = auth()->user();

        if($user->isAdmin()) {
            $data = Task::where('status_id', 4)->count();
        } else {
            $data = Task::where('status_id', 4)->where('user_id', $user->id)->count();
        }

        self::set($key, $data);
        return self::get($key);
    }



    public static function ticketStatus()
    {
        $key = 'ticket-status';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = Status::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function scheduleTypes()
    {
        $key = 'schedule-types';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = ScheduleType::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function taskStatus()
    {
        $key = 'task-status';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = TicketStatus::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function folders()
    {
        $key = 'folders';

        if(self::has($key)) {
            //return self::get($key);
        }

        return Folder::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function courses()
    {
        $key = 'courses';

        if(self::has($key)) {
            return self::get($key);
        }

        $courses = Course::all();

        self::set($key, $courses);
        return self::get($key);
    }

    public static function roles()
    {
        $key = 'roles';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = Role::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function messageBoardCategories()
    {
        $key = 'messageBoardCategories';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = MessageBoardCategory::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function unreadChatMessages()
    {
        $user = auth()->user();

        return Message::where('receiver_id', $user->id)->where('read_at', null)
        ->get();
    }

    public static function messageBoardTypes()
    {
        $key = 'messageBoardTypes';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = MessageBoardType::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function units()
    {
        $key = 'units';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = Unit::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function departments()
    {
        $key = 'departments';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = Department::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function occupation($department)
    {
        $key = 'ocupation-'.$department;

        if(self::has($key)) {
            return self::get($key);
        }

        $data = Occupation::where('department_id', $department)->get();

        self::set($key, $data);
        return self::get($key);
    }

    public static function modules()
    {
        $key = 'modules';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = Module::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function permissions()
    {
        $key = 'permissions';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = Permission::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function users()
    {
        $key = 'users';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = User::whereNotIn('id', [1])->get();

        self::set($key, $data);
        return self::get($key);
    }

    public static function ticketCategories()
    {
        $key = 'ticket_type_categories';

        if(self::has($key)) {
            return self::get($key);
        }

        $types = Category::all();

        self::set($key, $types);
        return self::get($key);
    }

    public static function ticketTypes()
    {
        $key = 'ticket_types';

        if(self::has($key)) {
            return self::get($key);
        }

        $types = Type::where('active', true)->get();

        self::set($key, $types);
        return self::get($key);
    }

    public static function menus()
    {
        $key = 'menus';

        if(self::has($key)) {
            return self::get($key);
        }

        $menus = Menu::all();

        self::set($key, $menus);
        return self::get($key);
    }

    public static function countClients()
    {
        $key = 'count-clients';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = Client::count();

        self::set($key, $data);
        return self::get($key);
    }

    public static function messages()
    {
        $key = 'messages';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = Message::count();

        self::set($key, $data);
        return self::get($key);
    }


    public static function onlineUsers()
    {
        $onlineUsers = self::users()->where('status', 'online')->count();

        return $onlineUsers;
    }

    public static function getRouteForModel($model, $subject)
    {
        $item = $model::find($subject);

        $route = null;
        $html = null;

        if($model == 'App\Models\Ticket') {

          if($item) {
            $route = route('tickets.show', $item->uuid);
            $html = "<a href=".$route.">".$item->type->name."</a>";
          }
        }

        if($model == 'App\Models\Ticket\Type') {

          if($item) {
            $route = route('ticket-types.index', $item->uuid);
            $html = "<a href=".$route."> ".$item->name."</a>";
          }
        }

        if($model == 'App\Models\Folder') {

          if($item) {
            $route = route('folders.show', $item->uuid);
            $html = "<a href=".$route.">".$item->name."</a>";
          }
        }

        if($model == 'App\Models\Folder\Archive') {

          if($item) {
            $route = route('archive_preview', $item->uuid);
            $html = "<a target='_blank' href=".$route.">".$item->filename."</a>";
          }
        }

        if($model == 'App\Models\Documents') {

          if($item) {
            $route = route('document_preview', $item->uuid);
            $html = "<a target='_blank' href=".$route."> " . $item->filename."</a>";
          }

        }

        if($model == 'App\Models\Training\Course') {

          if($item) {
            $route = route('courses.edit', $item->uuid);
            $html = "<a href=".$route.">".$item->title."</a>";
          }
        }

        if($model == 'App\Models\Task') {

          if($item) {
            $route = route('tasks.show', $item->uuid);
            $html = "<a href=".$route.">".$item->name."</a>";
          }
        }

        if($model == 'App\Models\Schedule') {

          if($item) {
            $route = route('schedules.show', $item->uuid);
            $html = "<a href=".$route.">".$item->title."</a>";
          }
        }

        if($model == 'App\User') {

          if($item) {
            $route = route('user', $item->uuid);
            $html = "<a href=".$route.">".$item->person->name."</a>";
          }
        }

        if($model == 'App\Models\MessageBoard\Type') {
          if($item) {
            $route = route('message-types.edit', $item->uuid);
            $html = '<a href='.$route.'>'.$item->name.'</a>';
          }
        }

        if($model == 'App\Models\Client') {

          if($item) {
            $route = route('clients.show', $item->uuid);
            $html = '<a href='.$route.'>'.$item->name.'</a>';
          }
        }

        if($model == 'App\Models\Department') {

          if($item) {
            $route = route('departments.show', $item->uuid);
            $html = '<a href='.$route.'>'.$item->name.'</a>';
          }
        }

        if($model == 'App\Models\Department\Occupation') {

          if($item) {
            $route = route('occupations.show', $item->uuid);
            $html = '<a href='.$route.'>'.$item->name.'</a>';
          }
        }

        if($model == 'App\Models\People') {
          $route = route('user', $item->uuid);
          $html = '<a href='.$route.'>'.$item->name.'</a>';
        }

        if($model == 'App\Models\Client\Address') {

          if($item) {
            $route = route('clients.show', $item->client->uuid);
            $html = '<a href='.$route.'>'.$item->description.': '.$item->street.', '.$item->number.', '.$item->district.', '.$item->city.', '.$item->zip.'</a>';
          }

        }

        if($model == 'App\Models\Client\Employee') {

          if($item) {
            $route = route('clients.show', $item->company->uuid);
            $html = '<a href='.$route.'>'.$item->name.'</a>';
          }

        }

        if($model == 'App\Models\MessageBoard') {
          $route = route('message-board.show', $item->uuid);
          $html = '<a href='.$route.'>'.$item->subject.'</a>';
        }

        return [
          'route' => $route,
          'html' => $html
        ];
    }

    public static function getTagHmtlForModel($model, $subject)
    {
        if(!$subject) {
          return null;
        }

        $itens = self::getRouteForModel($model, $subject);

        echo $itens['html'];
    }

    public static function idade(People $person)
    {
        $date = $person->birthday;
        $interval = $date->diff(now());

        return $interval->format( '%y Anos' );
    }

    public static function Initials($string = null) {
        return array_reduce(
            explode(' ', $string),
            function ($initials, $word) {
                return sprintf('%s%s', $initials, substr($word, 0, 1));
            },
            ''
        );
    }

    public static function getColorFromValue($value)
    {
          switch ($value) {
            case 2:
                return 'primary';
            case 3:
                return 'success';
            case 4:
                return 'warning';
            case 5:
                return 'danger';
            default:
                return 'info';
          }
    }

    public static function getStatusCollor($value)
    {
          switch ($value) {
            case 2:
                return 'primary';
            case 3:
                return 'success';
            case 4:
                return 'warning';
            case 5:
                return 'danger';
            default:
                return 'info';
          }
    }

    public static function statusTaskCollor($value)
    {
          switch ($value) {
            case 2:
                return 'warning';
            case 3:
                return 'primary';
            case 4:
                return 'primary';
            case 5:
                return 'danger';
            default:
                return 'info';
          }
    }

    public static function statusTaskPriorityCollor($priority)
    {
        switch($priority) {
          case 'Baixa':
            $priority = 'info';
            break;
          case 'Normal':
            $priority = 'primary';
            break;
          case 'Alta':
            $priority = 'warning';
            break;
          case 'Altíssima':
            $priority = 'danger';
            break;
        }

        return $priority;
    }

    public static function percent($value)
    {
          switch ($value) {
            case 1:
                return '0%';
            case 2:
                return '50%';
            case 3:
                return '100%';
            default:
                return '100%';
          }
    }

    public static function progressBarCollor($value)
    {
          switch ($value) {
            case 2:
                return 'progress-bar-warning';
            case 4:
                return 'progress-bar-danger';
            default:
                return 'progress-bar-success';
          }
    }

    public static function getTaskPercentage($userUuid)
    {
        $user = User::uuid($userUuid);

        $total = $user->tasks->isNotEmpty() ? count($user->tasks->filter(function($task) {
            return $task->status_id != Task::STATUS_CANCELADO && !$task->is_model;
        })) : 1;

        $concludedTasks = count($user->tasks->filter(function($task) {
            return $task->status_id == Task::STATUS_FINALIZADO && !$task->is_model;
        }));

        $inProgressTasks = count($user->tasks->filter(function($task) {
            return $task->status_id == Task::STATUS_EM_ANDAMENTO && !$task->is_model;
        }));

        if($total <= 0) {
          $total = 1;
        }

        if(!$inProgressTasks && !$inProgressTasks && !$total) {
          return 0;
        }

        if(!$concludedTasks) {
          $inProgressTasks = $inProgressTasks*0.50;
        }

        $porcent = round((($concludedTasks + $inProgressTasks) / $total) * 100);

        return $porcent;
    }

    public static function listNextSchedules()
    {
        $user = auth()->user();

        $cardCollor = "#1ab394";
        $editable = false;

        $data = [];
        $schedules = $user->schedules->where('start', '>', now());

        foreach ($schedules as $key => $schedule) {

          $data[] = [
              'id' => $schedule->id,
              'uuid' => $schedule->uuid,
              'title' => $schedule->title,
              'description' => $schedule->description,
              'start' => $schedule->start ? $schedule->start->format('d/m/Y H:i') : null,
              'end' => $schedule->end ? $schedule->end->format('d/m/Y H:i') : null,
              'created' => $schedule->created_at,
              'route' => route('schedules.show', $schedule->uuid),
          ];
        }

        foreach ($user->guest as $key => $guest) {

            $schedules = $guest->schedules->where('start', '>', now());

            foreach ($schedules as $keya => $schedule) {

              $data[] = [
                  'id' => $schedule->id,
                  'uuid' => $schedule->uuid,
                  'title' => $schedule->title,
                  'description' => $schedule->description,
                  'start' => $schedule->start ? $schedule->start->format('d/m/Y H:i') : null,
                  'end' => $schedule->end ? $schedule->end->format('d/m/Y H:i') : null,
                  'created' => $schedule->created_at,
                  'route' => route('schedules.show', $schedule->uuid),
              ];
            }
        }

        return $data;
    }

    public static function unSeenEmailsCount()
    {
        return Email::where('user_id', auth()->user()->id)->where('flag_seen', false)->count();
    }

}
