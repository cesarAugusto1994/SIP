<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\TaskLogs;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Auth, Notification;

use App\Models\People;

use App\Models\{Department,Module, RoleDefaultPermissions, Unit};
use App\Models\Department\Occupation;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Notifications\NewUser as NewUserNotification;
use App\Helpers\Helper;
use App\Models\Localization;
use Storage;
use Image;

class UsersController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->hasPermission('view.usuarios')) {
            return abort(403, 'Unauthorized action.');
        }

        if(!Auth::user()->isAdmin()) {
            return redirect()->route('users.show', ['id' => $request->get('id')]);
        }

        $people = People::where('id', '>', 0);

        if($request->filled('active')) {
          $active = $request->get('active');
          $people->where('active', $active);
        }

        if($request->filled('department')) {
          $department = $request->get('department');
          $department = Department::uuid($department);
          $people->where('department_id', $department->id);
        }

        if($request->filled('occupation')) {
          $occupation = $request->get('occupation');
          $occupation = Occupation::uuid($occupation);
          $people->where('occupation_id', $occupation->id);
        }

        if($request->filled('search')) {

          $search = $request->get('search');

          $people->where('name', 'like', "%$search%")
          ->orWhere('id', 'like', "%$search%")
          ->orWhere('phone', 'like', "%$search%")
          ->orWhere('cpf', 'like', "%$search%");

          $people->whereHas('user', function($query) use ($search) {
            $query->where('email', 'like', "%$search%")
            ->where('nick', 'like', "%$search%");
          });

        }

        $people = $people->paginate();

        $roles = Helper::roles();

        $departments = Helper::departments();
        $occupations = Helper::occupation($departments->first()->id);

        return view('users.index', compact('roles', 'people', 'departments', 'occupations'));
    }

    public function contacts()
    {
        $users = Helper::users();

        return view('users.contacts', compact('users'));
    }

    public function permissions($id)
    {
        $permissions = Helper::permissions();

        $modules = Helper::modules();

        $permissionsGroupedByModule = [];

        $user = User::uuid($id);

        return view('users.permissions', compact('permissionsGroupedByModule', 'user', 'modules'));
    }

    public function grant($id, $permission)
    {
        $user = User::uuid($id);
        $user->attachPermission($permission);
        $user->save();

        return response()->json([
          'success' => true,
          'message' => 'Permissão concedida com sucesso.'
        ]);
    }

    public function revoke($id, $permission)
    {
        $user = User::uuid($id);
        $user->detachPermission($permission);
        $user->save();

        return response()->json([
          'success' => true,
          'message' => 'Permissão revogada com sucesso.'
        ]);
    }

    public function search(Request $request)
    {
        $id = $request->get('param');

        try {

          $person = People::uuid($id);

          return response()->json([
            'success' => true,
            'message' => 'Registros retornados',
            'data' => $person
          ]);

        } catch(\Exception $e) {

          activity()
         ->causedBy($request->user())
         ->log('Erro ao buscar informações do usuário: '. $e->getMessage());

          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado',
            'data' => []
          ]);
        }

    }

    public static function getTaskPercentage($id)
    {
        $user = User::find($id);

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

    public static function getTaskPercentageProgress($id)
    {
        $porcentage = self::getTaskPercentage($id);

        $classColor = 'progress-bar-primary';

        if(0 < $porcentage && 50 >= $porcentage) {
            $classColor = 'progress-bar-warning';
        } elseif (50 < $porcentage && 100 >= $porcentage) {
            $classColor = 'progress-bar-primary';
        }

        return $classColor;
    }

    public static function getLatestTask($id)
    {
        $tasks = Task::where('user_id', $id)->where('status_id', Task::STATUS_EM_ANDAMENTO)->orderBy('id', 'DESC')->get();

        $horaAtual = new \DateTime('now');

        $lastests = $tasks->filter(function($task) use($horaAtual) {

          $horaCorte = new \DateTime($task->begin);

          $diff = $horaAtual->diff($horaCorte);
          $segundos = $diff->s + ($diff->i * 60) + ($diff->h * 60);

          $remainTime = ($task->time*60) - $segundos;

          return $task->time > $remainTime;

        });

        if($lastests->isEmpty()) {
          return '';
        }

        return 'Tarefa Atrasada';
    }

    public static function getTodayLogs($id)
    {
        $logs = TaskLogs::where('user_id', $id)
        ->where('created_at', '>', (new \DateTime('now'))->format('Y-m-d') . ' 00:00:00')
        ->orderBy('id', 'DESC')
        ->take(3);

        return $logs->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Helper::roles();
        $departments = Helper::departments();
        $occupations = Helper::occupation($departments->first()->id);
        $units = Helper::units();

        return view('users.create', compact('roles', 'departments', 'occupations', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->request->all();;

        $validator = \Illuminate\Support\Facades\Validator::make($data, [
          'name' => 'required|string|max:255',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6',
          'roles' => 'required',
        ]);

        $permissions = Permission::pluck('id');

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $roleUser = Role::where("name", $data['roles'])->first();

        $department = Department::uuid($data['department_id']);
        $occupation = Occupation::uuid($data['occupation_id']);
        $unit = Unit::uuid($data['unit_id']);

        $birthday = null;
        $branch = null;
        $phone = null;
        $phoneCode = null;
        $phonePassword = null;
        $phoneCallCenterCode = null;

        if($request->has('birthday')) {
            $birthday = $data['birthday'];
            $birthday = \DateTime::createFromFormat('d/m/Y', $birthday);
        }

        if($request->has('branch')) {
            $branch = $data['branch'];
        }

        if($request->has('phone')) {
            $phone = $data['phone'];
        }

        if($request->has('phone_code')) {
            $phoneCode = $data['phone_code'];
        }

        if($request->has('phone_password')) {
            $phonePassword = $data['phone_password'];
        }

        if($request->has('phone_callcenter_code')) {
            $phoneCallCenterCode = $data['phone_callcenter_code'];
        }

        $person = People::create([
          'name' => $data['name'],
          'birthday' => $birthday,
          'department_id' => $department->id,
          'occupation_id' => $occupation->id,
          'cpf' => $data['cpf'],
          'phone' => $phone,
          'phone_callcenter_code' => $phoneCode,
          'phone_password' => $phonePassword,
          'phone_callcenter_code' => $phoneCallCenterCode,
          'branch' => $branch,
          'unit_id' => $unit->id
        ]);

        $avatar = 'defaults/avatar.jpg';

        $user = new User();
        $user->email = $data['email'];
        $user->nick = str_slug($data['name'], '.');
        $user->password = bcrypt($data['password']);
        $user->person_id = $person->id;
        $user->avatar_type = 'upload';
        $user->avatar = $avatar;
        $user->change_password = true;
        $user->password_email = $data['password_email'];

        $user->save();
        $user->roles()->attach($roleUser);

        $permissionForRole = RoleDefaultPermissions::where('role_id', $roleUser->id)
        ->pluck('permission_id');

        $user->syncPermissions($permissionForRole);

        $user->save();

        //Notification::send(User::whereNot('id', $user->id)->get(), new NewUserNotification($user));

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Novo usuário adicionado com sucesso.'
        ]);

        return redirect()->route('user', ['id' => $user->uuid]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = $request->user();

        if($request->has('id') && $request->user()->isAdmin()) {
          $user = User::uuid($request->get('id'));
        }

        $users = Helper::users();
        $person = $user->person;
        $departments = Helper::departments();
        $departamentoAtual = $user->person->department;
        $occupations = Helper::occupation($departamentoAtual->id);
        $activities = $user->activities->sortByDesc('id')->take(6);
        $roles = Helper::roles();
        $permissions = Helper::permissions();
        $modules = Helper::modules();
        $units = Helper::units();

        return view('users.show', compact('user', 'occupations', 'departments', 'activities', 'roles', 'person', 'modules', 'units'));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAvatar($id)
    {
        return view('admin.users.avatar')->with('user', User::find($id));
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
        $data = $request->request->all();

        $user = User::uuid($id);

        $person = $user->person;

        if($request->has('birthday')) {
            $birthday = $data['birthday'];
            $person->birthday = \DateTime::createFromFormat('d/m/Y', $birthday);
        }

        $person->name = $data['name'];
        $person->cpf = $data['cpf'];

        if($request->has('department_id')) {
          $department = Department::uuid($data['department_id']);
          $person->department_id = $department->id;
        }

        if($request->has('occupation_id')) {
          $occupation = Occupation::uuid($data['occupation_id']);
          $person->occupation_id = $occupation->id;
        }

        if($request->has('unit_id')) {
          $unit = Unit::uuid($data['unit_id']);
          $person->unit_id = $unit->id;
        }

        if($request->filled('branch')) {
            $person->branch = $data['branch'];
        }

        if($request->filled('phone')) {
            $person->phone = $data['phone'];
        }



        $person->save();

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {

            $file = $request->file('avatar');

            $path = $file->hashName('avatar');

            $image = Image::make($file);

            $image->fit(250, 250, function ($constraint) {
               $constraint->aspectRatio();
            });

            Storage::put($path, (string) $image->encode());

            if(Storage::exists($user->avatar) && $user->avatar != 'defaults/avatar.jpg') {
                Storage::delete($user->avatar);
            }

            $user->avatar = $path;
            $user->avatar_type = 'upload';
        }

        if(auth()->user()->isAdmin()) {
            $user->active = $request->has('active');
            $user->person->active = $request->has('active');
            $user->do_task = $request->has('do_task');
        }

        $user->save();

        Helper::drop('users');

        notify()->flash('Sucesso', 'success', [
          'text' => 'As informações do usuário foram alteradas com sucesso.'
        ]);

        return redirect()->route('user', ['id' => $user->uuid]);
    }

    public function updateConfigs(Request $request, $id)
    {
        $data = $request->request->all();

        $validator = \Illuminate\Support\Facades\Validator::make($data, [
          'roles' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::uuid($id);


          /*
        $user->start_day = $data['begin'];
        $user->lunch = $data['lunch'];
        $user->lunch_return = $data['lunch_return'];
        $user->end_day = $data['end'];

        $user->weekly_workload = $data['weekly_workload'];
          */
        $user->login_soc = $data['login_soc'];
        $user->password_soc = $data['password_soc'];
        $user->id_soc = $data['id_soc'];

        if($request->filled('password_email') && $user->password_email != $data['password_email']) {
            $user->password_email = $data['password_email'];
        }

        if($request->has('phone_code')) {
            $user->person->phone_code = $data['phone_code'];
        }

        if($request->has('phone_password')) {
            $user->person->phone_password = $data['phone_password'];
        }

        if($request->has('phone_callcenter_code')) {
            $user->person->phone_callcenter_code = $data['phone_callcenter_code'];
        }

        if($request->has('roles')) {
            $roleUser = Role::where("name", $data['roles'])->first();
            $user->person->save();
            $user->detachAllPermissions();
            $user->detachAllRoles();
            $user->attachRole($roleUser);
            $permissionForRole = RoleDefaultPermissions::where('role_id', $roleUser->id)
            ->pluck('permission_id');
            $user->syncPermissions($permissionForRole);
        }

        $user->save();

        notify()->flash('Sucesso!', 'success', [
          'text' => 'As configurações foram alteradas com sucesso.'
        ]);

        return redirect()->route('user', ['id' => $id]);
    }

    public function password()
    {
        return view('users.password');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->request->all();

        $validator = \Illuminate\Support\Facades\Validator::make($data, [
          'password' => ['required', 'string', 'min:6', 'dumbpwd', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if(!$request->has('user') && !$request->user()->isAdmin()) {

          notify()->flash('Erro!', 'success', [
            'text' => 'A senha do usuário foi alterada com sucesso.'
          ]);

          return back();

        }

        if($request->user()->isAdmin()) {

          $user = $request->user();

        } else {

          $userCode = $request->get('user');
          $user = User::uuid($userCode);

        }

        $password = $data['password'];

        if (!empty($password)) {
            $user->password = bcrypt($password);
        }

        $user->change_password = false;

        $user->save();

        notify()->flash('Sucesso!', 'success', [
          'text' => 'A senha foi atualizada com sucesso.'
        ]);

        return redirect()->route('user', ['id' => $user->uuid]);
    }

    public function updatePasswordFirstAccess(Request $request, $id)
    {
        $data = $request->request->all();

        $user = User::findOrFail($id);

        $password = $data['password'];

        if (!empty($password)) {
            $user->password = bcrypt($password);
            $user->change_password = false;
        }

        $user->save();

        //flash('A sua senha foi alterada com sucesso.')->success()->important();

        notify()->flash('Sucesso!', 'success', [
          'text' => 'A senha do usuário foi alterada com sucesso.'
        ]);

        return redirect()->back();
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadAvatar($id, $avatar)
    {
        $user = User::find($id);

        $src = 'admin/avatars/'.$user->avatar;

        if ($user->avatar) {
            if (file_exists($src)) {
                unlink($src);
            }
        }

        $user->avatar = $avatar;

        $user->save();

        return redirect()->route('user', ['id' => $id]);
    }

    public function localization(Request $request)
    {
        $data = $request->request->all();

        $user = $request->user();

        $userlocalizations = Localization::where('user_id', $user->id)->get();

        if($userlocalizations->isNotEmpty()) {

            $lastlocalization = $userlocalizations->last();

            if($lastlocalization->lat == $data['lat'] && $lastlocalization->long == $data['lng']) {

              return response()->json([
                'success' => true,
                'message' => 'Localização salva com sucesso.'
              ]);

            }

        }

        Localization::create([
          'lat' => $data['lat'],
          'long' => $data['lng'],
          'user_id' => $user->id,
        ]);

        return response()->json([
          'success' => true,
          'message' => 'Localização salva com sucesso.'
        ]);

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
