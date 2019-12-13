<?php

namespace App\Helpers;

use Auth;
use Session;
use App\User;
use App\Models\Training\{Course, Team};
use App\Models\Training\Team\Employee as TeamEmployee;
use App\Models\{People, Menu, Client, Contract};
use App\Models\Client\Address;
use App\Models\Client\{Employee, Occupation as ClientOccupation};
use App\Models\Task\Status as TicketStatus;
use App\Models\Ticket\{Type,Status};
use App\Models\{Department, Module};
use App\Models\Department\Occupation;
use App\Models\Ticket\Type\Category;
use App\Models\Ticket\Type as TicketType;
use App\Models\{Unit,Email};
use App\Models\Schedule\Type as ScheduleType;
use App\Models\{Message, Folder, Ticket, Task};
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Models\Category as MessageBoardCategory;
use App\Models\MessageBoard\Type as MessageBoardType;
use App\Models\DeliveryOrder\Status as DeliveryStatus;
use App\Models\Fleet\Vehicle\Status as VehicleStatus;
use App\Models\DeliveryOrder;
use App\Models\Delivery\Document as DeliveryDocument;
use App\Models\Stock\{Stock,Brand,Product,Vendor};
use App\Models\Stock\Brand\Models as BrandModels;
use App\Models\Delivery\Document\Type as DocumentType;
use App\Models\Delivery\Document\Status as DocumentStatus;
use App\Models\Stock\Product\Type as ProductType;
use App\Models\ServiceOrder\Service\Type as ServiceType;
use Spatie\Activitylog\Models\Activity;

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

    public static function documentsTotal()
    {
        $key = 'documents-total';

        if(self::has($key)) {
            //return self::get($key);
        }

        $data = DeliveryDocument::count();

        return $data;

        self::set($key, $data);
        return self::get($key);
    }

    public static function deliveriesTotal()
    {
        $key = 'deliveries-total';

        if(self::has($key)) {
            //return self::get($key);
        }

        $data = DeliveryOrder::count();

        return $data;

        self::set($key, $data);
        return self::get($key);
    }

    public static function teamsTotal()
    {
        $key = 'teams-total';

        if(self::has($key)) {
            //return self::get($key);
        }

        $data = Team::count();

        return $data;

        self::set($key, $data);
        return self::get($key);
    }

    public static function teamEmloyeesTotal()
    {
        $key = 'team-employees-total';

        if(self::has($key)) {
            //return self::get($key);
        }

        $data = TeamEmployee::count();

        return $data;

        self::set($key, $data);
        return self::get($key);
    }

    public static function ticketsTotal()
    {
        $key = 'tickets-total';

        if(self::has($key)) {
            //return self::get($key);
        }

        $user = auth()->user();

        if($user->isAdmin()) {
            $data = Ticket::count();
        } else {
            $data = Ticket::where('user_id', $user->id)->count();
        }

        return $data;

        self::set($key, $data);
        return self::get($key);
    }

    public static function ticketsClosedTotal()
    {
        $key = 'tickets-closed-total';

        if(self::has($key)) {
            //return self::get($key);
        }

        $user = auth()->user();

        if($user->isAdmin()) {
            $data = Ticket::where('status_id', 4)->count();
        } else {
            $data = Ticket::where('status_id', 4)->where('user_id', $user->id)->count();
        }

        return $data;

        self::set($key, $data);
        return self::get($key);
    }

    public static function tasksTotal()
    {
        $key = 'tasks-total';

        if(self::has($key)) {
            //return self::get($key);
        }

        $user = auth()->user();

        if($user->isAdmin()) {
            $data = Task::count();
        } else {
            $data = Task::where('user_id', $user->id)->count();
        }

        return $data;

        self::set($key, $data);
        return self::get($key);
    }

    public static function tasksClosedTotal()
    {
        $key = 'tasks-closed-total';

        if(self::has($key)) {
            //return self::get($key);
        }

        $user = auth()->user();

        if($user->isAdmin()) {
            $data = Task::where('status_id', 4)->count();
        } else {
            $data = Task::where('status_id', 4)->where('user_id', $user->id)->count();
        }

        return $data;

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

    public static function ticketTypes()
    {
        $key = 'ticket-types';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = TicketType::where('active', true)->get();

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

    public static function productTypes()
    {
        $key = 'product-types';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = ProductType::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function serviceTypes()
    {
        $key = 'service-types';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = ServiceType::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function vendors()
    {
        return Vendor::where('active', true)->get();
    }

    public static function brands()
    {
        return Brand::where('active', true)->get();
    }

    public static function models()
    {
        return BrandModels::where('active', true)->get();
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

    public static function metricUnits()
    {
        $key = 'metric-units';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = ['Unidade', 'Serviço', 'Peça', 'Kilo', 'Litro', 'Metro', 'Caixa'];

        self::set($key, $data);
        return self::get($key);
    }

    public static function purchasingStatus()
    {
        $key = 'purchasing-status';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = ['Aberta', 'Em Andamento', 'Aprovada', 'Rejeitada'];

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

    public static function usersByOccupation($code)
    {
        $key = 'user-by-occupation-' . $code;

        if(self::has($key)) {
            return self::get($key);
        }

        $data = People::where('occupation_id', $code)->where('active', true)->get();

        self::set($key, $data);
        return self::get($key);
    }

    public static function courses()
    {
        $key = 'courses';

        if(self::has($key)) {
            return self::get($key);
        }

        $courses = Course::where('active', true)->get();

        self::set($key, $courses);
        return self::get($key);
    }

    public static function companiesWhereHasEmployees()
    {
        $key = 'companies-has-employees';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = Client::whereHas('employees')->get();

        self::set($key, $data);
        return self::get($key);
    }

    public static function contracts()
    {
        $key = 'contracts';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = Contract::where('active', true)->get();

        self::set($key, $data);
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

    public static function clientOccupation()
    {
        $key = 'client-occupation';

        if(self::has($key)) {
            //return self::get($key);
        }

        return ClientOccupation::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function users()
    {
        $key = 'users';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = User::where('active', true)->get();

        self::set($key, $data);
        return self::get($key);
    }

    public static function usersBySentMessages()
    {
        $user = auth()->user();

        $data = User::whereHas('messages', function($query) use($user) {
            $query->where('receiver_id', $user->id);
            $query->where('read_at', null);
        })->get();

        return $data;
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

    public static function documentTypes()
    {
        $key = 'document-types';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = DocumentType::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function documentStatuses()
    {
        $key = 'document-statuses';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = DocumentStatus::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function stockStatus()
    {
        $key = 'stock-status';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = ['Disponível', 'Em Uso', 'Em Manutenção', 'Troca', 'Danificado', 'Perdido', 'Descartado'];

        self::set($key, $data);
        return self::get($key);
    }

    public static function stockLocalization()
    {
        $key = 'stock-localization';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = ['Almoxarifado','Usuário', 'Departamento', 'Unidade', 'Fornecedor'];

        self::set($key, $data);
        return self::get($key);
    }

    public static function menus()
    {
        $key = 'menus';

        if(self::has($key)) {
            return self::get($key);
        }

        $menus = Menu::where('active', true)->orderBy('order')->get();

        self::set($key, $menus);
        return self::get($key);
    }

    public static function clients()
    {
        $key = 'clients';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = Client::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function addresses()
    {
        $key = 'addresses';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = Address::all();

        self::set($key, $data);
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

    public static function employees()
    {
        $key = 'employees';

        if(self::has($key)) {
            //return self::get($key);
        }

        return Employee::where('active', true)->get();

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

    public static function vehicleStatus()
    {
        $key = 'vehicle-status';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = VehicleStatus::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function deliveryStatus()
    {
        $key = 'delivery-orider-status';

        if(self::has($key)) {
            return self::get($key);
        }

        $data = DeliveryStatus::all();

        self::set($key, $data);
        return self::get($key);
    }

    public static function onlineUsers()
    {
        return User::online()->count();
    }

    public static function onlineUsersList()
    {
        return User::online()->get();
    }

    public static function userLogs($user)
    {
        return $user->activities()->count();
    }

    public static function usersLogs()
    {
        return Activity::count();
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

        if($model == 'App\Models\Stock\Product') {

          if($item) {
            $route = route('products.index', $item->uuid);
            $html = "<a target='_blank' href=".$route."> " . $item->name."</a>";
          }

        }

        if($model == 'App\Models\Stock\Stock') {

          if($item) {
            $route = route('products.show', $item->product->uuid);
            $html = "<a target='_blank' href=".$route."> " . $item->id."</a>";
          }

        }

        if($model == 'App\Models\Stock\Vendor') {

          if($item) {
            $route = route('vendors.index');
            $html = "<a target='_blank' href=".$route."> " . $item->name."</a>";
          }

        }

        if($model == 'App\Models\Stock\Brand') {

          if($item) {
            $route = route('brands.index');
            $html = "<a target='_blank' href=".$route."> " . $item->name."</a>";
          }

        }

        if($model == 'App\Models\Stock\Brand\Models') {

          if($item) {
            $route = route('models.index');
            $html = "<a target='_blank' href=".$route."> " . $item->name."</a>";
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

        if($model == 'App\Models\DeliveryOrder') {

          if($item) {
            $route = route('delivery-order.show', $item->uuid);
            $html = "<a href=".$route.">#".$item->id."</a>";
          }
        }

        if($model == 'App\Models\DeliveryOrder\Documents') {

          if($item) {
            $route = route('delivery-order.show', $item->deliveryOrder->uuid);
            $html = "<a href=".$route.">#".$item->deliveryOrder->id."</a>";
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

        if($model == 'App\Models\Client\Phone') {

          if($item) {
            $route = route('clients.show', $item->client->uuid);
            $html = "<a href=".$route.">".$item->number."</a>";
          }
        }

        if($model == 'App\Models\Client\Email') {

          if($item) {
            $route = route('clients.show', $item->client->uuid);
            $html = "<a href=".$route.">".$item->email."</a>";
          }
        }

        if($model == 'App\Models\Training\Team\Employee') {

          if($item) {
            $route = route('employees.show', $item->uuid);
            $html = "<a href=".$route.">".$item->employee->name."</a>";
          }
        }

        if($model == 'App\Models\Training\Team') {

          if($item) {
            $route = route('teams.show', $item->uuid);
            $html = "<a href=".$route.">#".$item->id."</a>";
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

        if($model == 'App\Models\Client\Occupation') {
          if($item) {
            $route = route('client-occupations.index');
            $html = '<a href='.$route.'>'.$item->name.'</a>';
          }
        }

        if($model == 'App\Models\Fleet\Schedule') {

          if($item) {
            $route = route('vehicle-schedule.show', $item->uuid);
            $html = '<a href='.$route.'>#'.$item->id.'</a>';
          }
        }

        if($model == 'App\Models\Department\Occupation') {

          if($item) {
            $route = route('occupations.show', $item->uuid);
            $html = '<a href='.$route.'>'.$item->name.'</a>';
          }
        }

        if($model == 'App\Models\Fleet\Vehicle') {
          if($item) {
            $route = route('vehicles.index');
            $html = '<a href='.$route.'>'.$item->name.'</a>';
          }
        }

        if($model == 'App\Models\People') {
          if($item) {
            $route = route('user', $item->uuid);
            $html = '<a href='.$route.'>'.$item->name.'</a>';
          }
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

          if($item) {
            $route = route('message-board.show', $item->uuid);
            $html = '<a href='.$route.'>'.$item->subject.'</a>';
          }

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

    public static function deliveryStatusColor($value)
    {
          switch($value) {
            case '1':
              return'primary';
              break;
            case '2':
              return 'warning';
              break;
            case '3':
              return 'success';
              break;
            case '4':
              return 'danger';
              break;
            default:
                return 'info';
          }
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
                return 'success';
            case 5:
                return 'danger';
            default:
                return 'info';
          }
    }

    public static function statusTeams($value)
    {
          switch ($value) {
            case 'RESERVADO':
                return 'warning';
            case 'EM ANDAMENTO':
                return 'primary';
            case 'FINALIZADA':
                return 'success';
            case 'CANCELADA':
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

    public function recurringTasks()
    {
        $tasks = Task::whereNull('end')->get();
    }

    public static function convertMonths($code)
    {
        switch($code) {
          case 1:
              return 'Janeiro';
          case 2:
              return 'Fevereiro';
          case 3:
              return 'Março';
          case 4:
              return 'Abril';
          case 5:
              return 'Maio';
          case 6:
              return 'Junho';
          case 7:
              return 'Julho';
          case 8:
              return 'Agosto';
          case 9:
              return 'Setembro';
          case 10:
              return 'Outubro';
          case 11:
              return 'Novembro';
          case 12:
              return 'Dezembro';
          default:
              throw new \Exception("O Mês informado não existe.", 1);
        }
    }

    public static function convertToEnglish($string)
    {
        switch($string) {
          case 'Segunda':
              return 'Monday';
          case 'Terca':
              return 'Tuesday';
          case 'Quarta':
              return 'Wednesday';
          case 'Quinta':
              return 'Thursday';
          case 'Sexta':
              return 'Friday';
          case 'Sabado':
              return 'Saturday';
          default:
              return 'Sunday';
        }
    }

    public static function delivery()
    {
        return DeliveryOrder::all();
    }

    public static function totalDelivery()
    {
        return self::delivery()->count();
    }

    public static function openedDeliveries()
    {
        return self::delivery()->filter(function($delivery, $index) {
            return $delivery->status_id == 1;
        })->count();
    }

    public static function delivered()
    {
        return self::delivery()->filter(function($delivery, $index) {
            return $delivery->status_id == 3;
        })->count();
    }

    public static function finishedDeliveries()
    {
        return self::delivery()->filter(function($delivery, $index) {
            return $delivery->status_id == 5;
        })->count();
    }

    public static function brl2decimal($brl, $casasDecimais = 2)
    {
        // Se já estiver no formato USD, retorna como float e formatado
        if(preg_match('/^\d+\.{1}\d+$/', $brl))
            return (float) number_format($brl, $casasDecimais, '.', '');
        // Tira tudo que não for número, ponto ou vírgula
        $brl = preg_replace('/[^\d\.\,]+/', '', $brl);
        // Tira o ponto
        $decimal = str_replace('.', '', $brl);
        // Troca a vírgula por ponto
        $decimal = str_replace(',', '.', $decimal);
        return (float) number_format($decimal, $casasDecimais, '.', '');
    }

    public static function formatCnpjCpf($value)
    {
        $cnpj_cpf = preg_replace("/\D/", '', $value);

        if (strlen($cnpj_cpf) === 11) {
          return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        }

        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
    }

    public static function calculateDistances($lat1, $lon1, $lat2, $lon2, $unit) {

      if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
      }
      else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
          return ($miles * 1.609344);
        } else if ($unit == "N") {
          return ($miles * 0.8684);
        } else {
          return $miles;
        }
      }

    }

}
