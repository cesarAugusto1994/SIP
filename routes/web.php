<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

if (\App::environment('production')) {
    //\URL::forceScheme('https');
}

Auth::routes();

Route::get('test', function () {
    $user = \App\User::find(1);
    //event(new \App\Events\NewUser($user));
    \Notification::send(\App\User::where('id', 2)->get(), new \App\Notifications\NewUser($user));
    return "Event has been sent!";
});

Route::get('/home', function() {
  return redirect()->route('home');
})->middleware('lock');

Route::get('/admin', function() {
  return redirect()->route('home');
})->middleware('lock');

Route::middleware('auth')->middleware('status')->group(function () {

  Route::get('lockscreen', 'LockAccountController@lockscreen')->name('lockscreen');
  Route::post('lockscreen', 'LockAccountController@unlock')->name('post_lockscreen');
  Route::get('/image/external', 'UtilController@image')->name('image');

  Route::middleware('lock')->group(function () {

  Route::get('/', 'HomeController@index')->name('home');

  Route::get('messages', 'ChatsController@fetchMessages')->name('chat_user_messages');

  Route::prefix('admin')->group(function () {



    Route::impersonate();

    Route::prefix('chat')->group(function() {
      Route::get('/', 'ChatsController@index')->name('chat');
      Route::get('conversation/{id}', 'ChatsController@create')->name('chat_user');
      Route::get('conversation/{id}/messages', 'ChatsController@fetchMessages')->name('chat_messages');
      Route::post('conversation/{id}/messages', 'ChatsController@sendMessage')->name('chat_post_message');

      Route::post('message/{id}/markasread', 'ChatsController@masrkAsRead')->name('chat_post_message_markasread');

    });

    Route::resource('configurations', 'ConfigurationsController');
    Route::resource('tasks', 'TaskController');

    //Route::get('tasks', 'TaskController@index')->name('tasks');
    Route::get('board', 'TaskController@showBoard')->name('board');
    //Route::get('task/{id}', 'TaskController@show')->name('task');
    //Route::get('task/create/form', 'TaskController@create')->name('task_create');
    //Route::get('task/{id}/edit', 'TaskController@edit')->name('task_edit');
    Route::get('task/calendar/list', 'TaskController@calendar')->name('task_calendar');
    Route::get('task/to-json', 'TaskController@getTasks')->name('tasks_json');
    Route::get('task/{id}/start', 'TaskController@startTask')->name('task_initiate');
    Route::get('task/{id}/finish', 'TaskController@finish')->name('task_finish');

    //Route::post('task/store', 'TaskController@store')->name('task_store');
    //Route::post('task/{id}/update', 'TaskController@update')->name('task_update');
    Route::post('task/{id}/pause', 'TaskController@pause')->name('task_pause');

    Route::post('task/{id}/start', 'TaskController@unPause')->name('task_start');

    Route::post('task/{id}/status', 'TaskController@status')->name('task_status');

    Route::post('task/{id}/duplicate', 'TaskController@duplicate')->name('task_duplicate');

    Route::post('task/message/store', 'TaskMessagesController@store')->name('task_message_store');
    Route::post('task/{id}/delay', 'TaskController@delay')->name('task_delay');

    Route::post('task/{id}/upload', 'TaskController@upload')->name('task_upload');

    Route::get('task/{id}/download', 'TaskController@download')->name('task_download');
    Route::get('task/{id}/preview', 'TaskController@preview')->name('task_preview');

    # Departments
    Route::resource('departments', 'DepartmentsController');

    Route::resource('clients', 'ClientController');
    Route::resource('employees', 'EmployeesController');

    Route::get('user/{id}/avatar', 'UsersController@editAvatar')->name('user_avatar');
    Route::get('users/create/form', 'UsersController@create')->name('user_create');
    Route::get('user/{id}/avatar/{avatar}/upload', 'UsersController@uploadAvatar')->name('user_upload_avatar');
    Route::post('users/create/store', 'UsersController@store')->name('user_store');
    Route::post('user/{id}/update', 'UsersController@update')->name('user_update');
    Route::post('user/{id}/update/configs', 'UsersController@updateConfigs')->name('user_update_configurations');

    Route::get('/password', 'UsersController@password')->name('change_password');
    Route::post('/password/update', 'UsersController@updatePassword')->name('update_password');

    Route::post('user/{id}/update/password/first-access', 'UsersController@updatePasswordFirstAccess')->name('user_update_password_home');
    Route::get('boards', 'BoardController@index')->name('boards');

    Route::get('mappings', 'MapperController@index')->name('mappings');
    Route::get('mapping/{id}/edit', 'MapperController@edit')->name('mapping_edit');
    Route::get('mapping/{id}', 'MapperController@show')->name('mapping');
    Route::get('mapping/create/form', 'MapperController@create')->name('mapping_create');
    Route::get('mapping/{id}/tasks', 'MapperController@taskToDo')->name('mapping_tasks_to_do');
    Route::post('mapping/store', 'MapperController@store')->name('mapping_store');
    Route::get('mapping/{id}/add-task', 'MapperController@addTask')->name('mapping_tasks');
    Route::post('mapping/{id}/add-task-store', 'MapperController@addTaskStore')->name('mapping_tasks_store');
    Route::get('mapping/{id}/task/{task}/remove', 'MapperController@removeTaskStore')->name('mapper_remove_task');
    Route::post('mapping/{id}/start', 'MapperController@start')->name('mapping_start');

    Route::resource('users', 'UsersController');

    Route::get('users', 'UsersController@index')->name('users');
    Route::get('profile', 'UsersController@show')->name('user');

    Route::resource('documents', 'DocumentsController');
    Route::resource('delivery-order', 'DeliveryOrderController');

    Route::get('delivery-order/{id}/print/tags', 'DeliveryOrderController@printTags')->name('print_tags');
    Route::get('delivery-order/document/{id}/status', 'DeliveryOrderController@statsByDocument')->name('delivery_status_by_document');


    Route::resource('message-board', 'MessageBoardController');
    Route::resource('message-types', 'MessageTypesController');

    Route::resource('roles', 'RolesController');
    Route::resource('permissions', 'PermissionsController');

    Route::resource('occupations', 'OccupationController');
    Route::resource('types', 'DocumentTypesController');

    Route::resource('courses', 'CoursesController');
    Route::resource('students', 'StudentsController');
    Route::resource('teams', 'TeamsController');

    Route::resource('tickets', 'TicketsController');
    Route::resource('ticket-types', 'TicketTypesController');
    Route::resource('ticket-type-departments', 'TicketTypeDepartmentsController');

    Route::post('tickets/{id}/start', 'TicketsController@startTicket')->name('ticket_start');
    Route::post('tickets/{id}/conclude', 'TicketsController@concludeTicket')->name('ticket_conclude');
    Route::post('tickets/{id}/finish', 'TicketsController@finishTicket')->name('ticket_finish');
    Route::post('tickets/{id}/cancel', 'TicketsController@cancelTicket')->name('ticket_cancel');

    Route::get('clients/addresses/search', 'ClientController@addresses')->name('client_addresses_search');
    Route::get('clients/{id}/addresses', 'AddressesController@show')->name('client_addresses');
    Route::get('clients/{id}/addresses/create', 'AddressesController@create')->name('client_addresses_create');
    Route::post('clients/{id}/addresses', 'AddressesController@store')->name('client_addresses_store');
    Route::delete('clients/{id}/addresses/destroy', 'AddressesController@destroy')->name('client_address_destroy');
    Route::get('clients/{id}/addresses/{address}/edit', 'AddressesController@edit')->name('client_addresses_edit');
    Route::put('clients/{id}/addresses/{address}/update', 'AddressesController@update')->name('client_addresses_update');

    Route::get('clients/employees/search', 'ClientController@employees')->name('client_employees_search');
    Route::get('employees/search', 'ClientController@employeeFind')->name('employees_find');

    Route::get('clients/documents/search', 'ClientController@documents')->name('client_documents_search');


    Route::get('clients/{id}/employees', 'EmployeesController@show')->name('client_employees');
    Route::get('clients/{id}/employees/create', 'EmployeesController@create')->name('client_employee_create');
    Route::post('clients/{id}/employees', 'EmployeesController@store')->name('client_employee_store');
    Route::delete('clients/{id}/employees/destroy', 'EmployeesController@destroy')->name('client_employee_destroy');
    Route::get('clients/{id}/employees/{employee}/edit', 'EmployeesController@edit')->name('client_employee_edit');
    Route::put('clients/{id}/employees/{employee}/update', 'EmployeesController@update')->name('client_employee_update');

    Route::get('delivery-order/conference/documents', 'DeliveryOrderController@conference')->name('delivery_order_conference');

    Route::get('/department/occupations/search', 'OccupationController@search')->name('occupation_search');

    Route::get('cep', 'UtilController@cep')->name('cep');
    Route::get('departments/search/users', 'UtilController@usersByDepartment')->name('departments_users_search');

    Route::get('users/search', 'UsersController@search')->name('user_search');

    Route::get('user/{id}/permissions', 'UsersController@permissions')->name('user_permissions');

    Route::post('user/{id}/permissions/{permission}/revoke', 'UsersController@revoke')->name('user_permissions_revoke');
    Route::post('user/{id}/permissions/{permission}/grant', 'UsersController@grant')->name('user_permissions_grant');

    Route::post('role/{id}/permissions/{permission}/revoke', 'RolesController@revoke')->name('role_permissions_revoke');
    Route::post('role/{id}/permissions/{permission}/grant', 'RolesController@grant')->name('role_permissions_grant');

    Route::resource('notifications', 'NotificationsController');
    Route::resource('activities', 'ActivitiesController');

    Route::get('notifications-read', 'NotificationsController@markAsRead')->name('notifications_markasread');

    Route::get('team/{id}/schedules', 'TeamsController@schedule')->name('team_schedules');
    Route::put('team/{id}/employees/store', 'TeamsController@addEmployes')->name('teams_add_employees');
    Route::delete('team/{id}/employees/{employee}/destroy', 'TeamsController@destroyEmployes')->name('teams_employee_destroy');

    Route::post('team/{id}/start', 'TeamsController@start')->name('team_start');
    Route::post('team/{id}/employee/change-status', 'TeamsController@employeeChangeStatus')->name('team_employee_change_status');

    Route::post('clients/{id}/documents/upload', 'ClientController@uploadDocuments')->name('client_documents_upload');

    Route::get('client/documents/{id}/preview', 'ClientController@previewDocument')->name('document_preview');
    Route::get('client/documents/{id}/download', 'ClientController@downloadDocument')->name('document_download');
    Route::delete('client/documents/{id}/delete', 'ClientController@deleteDocument')->name('document_delete');

    Route::get('contacts', 'UsersController@contacts')->name('contacts');

    Route::resource('folders', 'FoldersController');
    Route::resource('archives', 'ArchivesController');

    Route::get('archives/{id}/download', 'ArchivesController@download')->name('archives_download');
    Route::get('archives/{id}/preview', 'ArchivesController@preview')->name('archive_preview');

    Route::get('folders/{id}/compresss/download', 'FoldersController@downloadAsZip')->name('folders_download');

    Route::resource('emails', 'EmailsController');
    Route::get('emails-search', 'EmailsController@search')->name('emails_search');
    Route::get('emails-template/{id}', 'EmailsController@html')->name('emails_template');

    Route::post('folders/{id}/upload', 'ArchivesController@upload')->name('file_upload');
    Route::post('folders/{id}/user/{user}/permission/{type}/change', 'FoldersController@changePermission')->name('folder_user_permission_change');

    Route::resource('units', 'UnitsController');
    Route::resource('schedules', 'ScheduleController');

    Route::get('schedule/list', 'ScheduleController@schedule')->name('schedule_list');

  });

  });

});

Route::get('user/{id}/online', 'UserOnlineController@online')->name('user_online');
Route::get('user/{id}/offline', 'UserOfflineController@offline')->name('user_offline');

Route::get('delivery-order/{id}/start-delivery', 'DeliveryOrderController@start')->name('start_delivery');
Route::get('delivery-order/{id}/delivery-status', 'DeliveryOrderController@status')->name('delivery_status');
