<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\Permission\Traits\HasRoles;
use Yadahan\AuthenticationLog\AuthenticationLogable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Models\{Department, Task, MessageBoard};

use Lab404\Impersonate\Models\Impersonate;

class User extends Authenticatable
{
    use Notifiable, AuthenticationLogable, Impersonate;
    use HasRoleAndPermission;

    use Uuids;
    //use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'login_soc', 'password_soc', 'id_soc', 'password_email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //protected static $logAttributes = ['name', 'email', 'password', 'login_soc', 'password_soc', 'id_soc'];

    public function messages()
    {
      return $this->hasMany('App\Models\Message');
    }

    public function activities()
    {
        return $this->hasMany('App\Models\Activity', 'causer_id');
    }

    public function person()
    {
        return $this->belongsTo('App\Models\People', 'person_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'sponsor_id');
    }

    public function logs()
    {
        return $this->hasMany('App\Models\Task\Log');
    }

    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }

    public function vehicleSchedules()
    {
        return $this->hasMany('App\Models\Fleet\Schedule');
    }

    public function guest()
    {
        return $this->hasMany('App\Models\Schedule\Guest');
    }

    public function vehicleScheduleGuest()
    {
        return $this->hasMany('App\Models\Fleet\Schedule\Guest');
    }

    public function messageBoard()
    {
        return $this->hasMany('App\Models\MessageBoard\User');
    }

    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket');
    }

    public function folders()
    {
       return $this->hasManyThrough('App\Models\Folder', 'App\Models\Folder\User\Permission', 'user_id', 'user_id');
    }

    public function foldersPermissions()
    {
        return $this->hasMany('App\Models\Folder\User\Permission', 'user_id');
    }

    /**
    * @param string|array $roles
    */
    public function authorizeRoles($roles)
    {
      if (is_array($roles)) {
          return $this->hasAnyRole($roles) ||
                 abort(401, 'This action is unauthorized.');
      }
      return $this->hasRole($roles) ||
             abort(401, 'This action is unauthorized.');
    }
    /**
    * Check multiple roles
    * @param array $roles
    */
    public function hasAnyRole($roles)
    {
      return null !== $this->roles()->whereIn('name', $roles)->first();
    }
    /**
    * Check one role
    * @param string $role
    */
    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    /**
    *
    */
    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }
/*
    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Usuário atualizado";
        } elseif ($eventName == 'deleted') {
            return "Usuário Removido";
        }

        return "Usuário Adicionado";
    }
*/
    /**
     * @return bool
     */
    public function canImpersonate()
    {
        return true;
    }
}
