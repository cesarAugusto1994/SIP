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

//Auth::routes();

Auth::routes(['verify' => true]);
/*
Route::get('test', function () {
    $user = \App\User::find(1);
    //event(new \App\Events\NewUser($user));
    \Notification::send(\App\User::where('id', 2)->get(), new \App\Notifications\NewUser($user));
    return "Event has been sent!";
});
*/

Route::middleware('auth')->group(function () {

    Route::get('/image/external', 'UtilController@image')->name('image');

    Route::middleware('status')->group(function () {

        Route::get('lockscreen', 'LockAccountController@lockscreen')->name('lockscreen');
        Route::post('lockscreen', 'LockAccountController@unlock')->name('post_lockscreen');

        Route::middleware('lock')->group(function () {

        Route::get('/home', 'HomeController@index');
        Route::get('/admin', 'HomeController@index');

        Route::get('/', 'HomeController@index')->name('home');

        Route::get('messages', 'ChatsController@fetchMessages')->name('chat_user_messages');

        Route::prefix('admin')->group(function () {

          Route::get('/logs', 'LogsController@index');

          Route::impersonate();

          Route::prefix('chat')->group(function() {
            Route::get('/', 'ChatsController@index')->name('chat');
            Route::get('conversation/{id}', 'ChatsController@create')->name('chat_user');
            Route::get('conversation/{id}/messages', 'ChatsController@fetchMessages')->name('chat_messages');
            Route::post('conversation/{id}/messages', 'ChatsController@sendMessage')->name('chat_post_message');

            Route::post('message/{id}/markasread', 'ChatsController@masrkAsRead')->name('chat_post_message_markasread');

          });

          Route::get('/search', 'SearchController@search')->name('search');

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

          Route::delete('task/file/{id}/remove', 'TaskController@fileRemove')->name('task_file_remove');

          Route::post('task/{id}/update/conclusion-percente', 'TaskController@updateConclusioPercente')->name('task_update_conclusion_percente');

          # Departments
          Route::resource('departments', 'DepartmentsController');

          Route::resource('clients', 'ClientController');

          Route::prefix('clients')->group(function() {
              Route::resource('phones', 'ClientPhonesController');
              Route::resource('email', 'ClientEmailsController');
          });

          Route::resource('client-occupations', 'ClientOccupationsController');

          Route::resource('employees', 'EmployeesController');

          Route::get('employees/{id}/grant/access', 'EmployeesController@grantAccess')->name('employee_grant_access');

          Route::get('user/{id}/avatar', 'UsersController@editAvatar')->name('user_avatar');
          Route::get('users/create/form', 'UsersController@create')->name('user_create');
          Route::post('user/{id}/avatar/upload', 'UsersController@uploadAvatar')->name('user_upload_avatar');
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
          Route::post('user/localization', 'UsersController@localization')->name('user_localization');
          Route::get('user/localizations', 'UsersController@locales')->name('users_locales');
          Route::get('localizations', 'LocalizationsController@index')->name('localization');

          Route::get('profile', 'UsersController@show')->name('user');

          Route::resource('documents', 'DocumentsController');
          Route::resource('delivery-order', 'DeliveryOrderController');

          Route::get('documents/create/for-client', 'DocumentsController@createManyForOneClient')->name('documents_create_for_client');
          Route::post('documents/create/for-client/store', 'DocumentsController@createManyForOneClientStore')->name('documents_create_for_client_store');

          Route::get('delivery-order/{id}/print/tags', 'DeliveryOrderController@printTags')->name('print_tags');

          Route::get('delivery-order/print/batch/list', 'DeliveryOrderController@printBatchList')->name('print_batch_list');
          Route::post('delivery-order/print/batch', 'DeliveryOrderController@printBatch')->name('print_batch');

          Route::get('delivery-order/create/batch', 'DeliveryOrderController@createMany')->name('delivery_order_create_many');
          Route::post('delivery-order/store/batch', 'DeliveryOrderController@storeMany')->name('delivery_order_store_many');

          Route::get('delivery-order/document/{id}/status', 'DeliveryOrderController@statsByDocument')->name('delivery_status_by_document');

          Route::get('delivery-order/{id}/get-receipt', 'DeliveryOrderController@getReceipt')->name('delivery_get_receipt');

          Route::post('delivery-order/{id}/cancel', 'DeliveryOrderController@cancel')->name('delivery_cancel');
          Route::post('delivery-order/{id}/confirm', 'DeliveryOrderController@confirm')->name('delivery_confirm');

          Route::get('delivery-order/report/billing', 'DeliveryOrderController@billing')->name('delivery_billing');
          Route::get('delivery-order/report/billing/print', 'DeliveryOrderController@billingreport')->name('delivery_billing_report');
          Route::get('delivery-order/report/billing/graph', 'DeliveryOrderController@billingGraph')->name('delivery_billing_graph');

          Route::resource('message-board', 'MessageBoardController');
          Route::resource('message-types', 'MessageTypesController');

          Route::resource('roles', 'RolesController');
          Route::resource('permissions', 'PermissionsController');

          Route::resource('modules', 'ModulesController');
          Route::resource('menus', 'MenusController');

          Route::get('modules/{id}/permission/{permission}/users', 'ModulesController@permissionUsers')->name('module_permissions_users');

          Route::resource('occupations', 'OccupationController');
          Route::resource('types', 'DocumentTypesController');

          Route::resource('courses', 'CoursesController');
          Route::resource('teams', 'TeamsController');

          Route::post('teams/{id}/employee/presence', 'TeamsController@employeePresence')->name('team_employee_presence');

          Route::get('teams/employee/{id}/status-change', 'TeamsController@employeeStatus')->name('teams_employee_status');
          Route::put('teams/employee/{id}/status/update', 'TeamsController@employeeStatusUpdate')->name('teams_employee_status_update');

          Route::resource('vehicles', 'VahiclesController');
          Route::resource('vehicle-schedule', 'VahicleScheduleController');

          Route::get('vehicle-schedule/list/json', 'VahicleScheduleController@schedule')->name('vehicle_schedule_list');

          Route::resource('tickets', 'TicketsController');
          Route::resource('ticket-types', 'TicketTypesController');
          Route::resource('ticket-type-departments', 'TicketTypeDepartmentsController');
          Route::resource('ticket-type-categories', 'TicketTypeCategoryController');

          Route::get('client/{id}/employees/create/many', 'EmployeesController@createMany')->name('client_employees_create');
          Route::post('client/{id}/employees/store/many', 'EmployeesController@storeMany')->name('client_employees_store');

          Route::post('tickets/{id}/start', 'TicketsController@startTicket')->name('ticket_start');
          Route::post('tickets/{id}/conclude', 'TicketsController@concludeTicket')->name('ticket_conclude');
          Route::post('tickets/{id}/finish', 'TicketsController@finishTicket')->name('ticket_finish');
          Route::post('tickets/{id}/cancel', 'TicketsController@cancelTicket')->name('ticket_cancel');

          Route::post('tickets/{id}/comment/post', 'TicketsController@comment')->name('ticket_comment_post');

          Route::post('tickets/message/store', 'TicketMessagesController@store')->name('ticket_message_store');
          Route::delete('task/message/{id}/destroy', 'TicketMessagesController@destroy')->name('ticket_message_destroy');

          Route::get('clients/search/json', 'ClientController@search')->name('client_search');
          Route::get('clients/occupations/search/json', 'ClientOccupationsController@search')->name('client_occupations_search');

          Route::get('employees/search/json', 'EmployeesController@search')->name('employee_search');
          Route::get('addresses/search/json', 'AddressesController@search')->name('addresses_search');

          Route::get('clients/addresses/search', 'ClientController@addresses')->name('client_addresses_search');
          Route::get('clients/emails/search', 'ClientController@emails')->name('client_emails_search');
          Route::get('clients/{id}/addresses', 'AddressesController@show')->name('client_addresses');
          Route::get('clients/{id}/addresses/create', 'AddressesController@create')->name('client_addresses_create');
          Route::post('clients/{id}/addresses', 'AddressesController@store')->name('client_addresses_store');
          Route::post('clients/addresses/store', 'AddressesController@storeWithoutClientId')->name('client_addresses_store_modal');
          Route::delete('clients/{id}/addresses/destroy', 'AddressesController@destroy')->name('client_address_destroy');
          Route::get('clients/{id}/addresses/{address}/edit', 'AddressesController@edit')->name('client_addresses_edit');
          Route::put('clients/{id}/addresses/{address}/update', 'AddressesController@update')->name('client_addresses_update');

          Route::get('clients/employees/search', 'ClientController@employees')->name('client_employees_search');
          Route::get('employees/search', 'ClientController@employeeFind')->name('employees_find');

          Route::get('clients/documents/search', 'ClientController@documents')->name('client_documents_search');

          Route::resource('employees', 'EmployeesController');

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

          Route::get('training/schedules', 'TeamsController@schedule')->name('team_schedules');
          Route::get('training/schedule/list', 'TeamsController@list')->name('team_schedule_list');

          Route::post('training/team/schedule/update', 'TeamsController@updateScheduleDate')->name('team_schedule_update');

          Route::get('training/teams/{id}/employees/{employee}/certified', 'TeamsController@certified')->name('team_certified');

          Route::put('team/{id}/employees/store', 'TeamsController@addEmployes')->name('teams_add_employees');
          Route::delete('team/{id}/employees/{employee}/destroy', 'TeamsController@destroyEmployes')->name('teams_employee_destroy');

          Route::post('team/{id}/start', 'TeamsController@start')->name('team_start');
          Route::post('team/{id}/finish', 'TeamsController@finish')->name('team_finish');
          Route::post('team/{id}/employee/change-status', 'TeamsController@employeeChangeStatus')->name('team_employee_change_status');

          Route::post('team/{id}/duplicate', 'TeamsController@duplicate')->name('team_duplicate');

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

          Route::get('emails/attachment/{id}/download', 'EmailsController@downloadAttachment')->name('email_attachment_download');

          Route::post('folders/{id}/upload', 'ArchivesController@upload')->name('file_upload');
          Route::post('folders/{id}/user/{user}/permission/{type}/change', 'FoldersController@changePermission')->name('folder_user_permission_change');

          Route::resource('units', 'UnitsController');
          Route::resource('schedules', 'ScheduleController');

          Route::get('schedule/list', 'ScheduleController@schedule')->name('schedule_list');

          Route::resource('purchasing', 'PurchasingController');
          Route::resource('purchasing-item', 'PurchasingItemsController');

          Route::resource('products', 'ProductsController');
          Route::resource('product-types', 'ProductTypesController');
          Route::resource('stock', 'StockController');
          Route::resource('brands', 'BrandsController');
          Route::resource('models', 'ModelsController');
          Route::resource('vendors', 'VendorsController');

          Route::resource('transfer', 'TransferController');

          Route::get('transfer/{id}/add/items', 'TransferController@items')->name('transfer_items');
          Route::post('transfer/{id}/add/items/store', 'TransferController@itemsStore')->name('transfer_items_store');

          Route::delete('transfer/{id}/items/{item}/destroy', 'TransferController@itemsDestroy')->name('transfer_item_destroy');

          Route::get('transfer/{id}/term/signature', 'TransferController@signature')->name('transfer_term_signature');
          Route::post('transfer/{id}/oprions', 'TransferController@transfer')->name('transfer_itens_options');

          Route::get('delivery-order/{id}/delivery-status', 'DeliveryOrderController@status')->name('delivery_status');
          Route::post('delivery-order/{id}/receipt', 'DeliveryOrderController@receipt')->name('delivery_receipt');

          Route::get('delivery-order/{id}/done', 'DeliveryOrderController@done')->name('delivery_done');

          Route::get('delivery-order/{id}/start-delivery', 'DeliveryOrderController@start')->name('start_delivery');
          Route::get('delivery-order/{id}/start-delivery-client', 'DeliveryOrderController@startWithdrawal')->name('start_delivery_client');

          Route::get('training/team/{id}/presence-list', 'TeamsController@presenceList')->name('team_presence_list');

          Route::post('training/team/{id}/presence-list/upload', 'TeamsController@uploadPresenceList')->name('teams_upload_presence_list');

          Route::get('training/team/{id}/presence-list/preview', 'TeamsController@previewPresenceList')->name('teams_preview_presence_list');

          Route::resource('reports', 'ReportController');
          Route::resource('tables', 'TableController');
          Route::resource('queries', 'QueryController');

          Route::get('tables/{id}/columns/import', 'TableController@importColumns')->name('table_import_columns');

          Route::post('tables/columns/{id}/status-view', 'ColumnController@status')->name('column_status');

          Route::get('columns/formats', 'UtilController@formats')->name('column_formats');
          Route::get('tables/search/list', 'UtilController@tables')->name('tables_list');

          Route::post('columns/{id}/formats/set', 'ColumnController@setFormat')->name('column_set_format');
          Route::post('columns/{id}/label/set', 'ColumnController@setLabel')->name('column_set_label');
          Route::post('columns/{id}/label/add', 'ColumnController@addLabel')->name('column_add_label');

          Route::get('tables/{id}/execute/query', 'QueryController@executeQuery')->name('table_execute');
          Route::post('columns/{id}/table-reference/set', 'ColumnController@setTableReference')->name('column_set_table_reference');

          Route::get('tables/{id}/create/query', 'TableController@createQuery')->name('table_create_query');
          Route::post('tables/{id}/create/store', 'TableController@storeQuery')->name('table_store_query');

          Route::get('queries/{id}/execute', 'QueryController@execute')->name('query_execute');

          Route::get('tables/{id}/search/execute', 'QueryController@executeTableQuery')->name('table_query_search');

          Route::resource('services', 'ServiceController');
          Route::resource('service-order', 'ServiceOrderController');

          Route::get('service-order/{id}/contract', 'ServiceOrderController@contract')->name('service_order_contract');
          Route::get('service-order/{id}/receipt', 'ServiceOrderController@receipt')->name('service_order_receipt');

          Route::post('service-order-item/{id}/update-by-ajax', 'ServiceOrderController@updateItemByAjax')->name('service_order_item_update');
          Route::post('service-order/{id}/update-by-ajax', 'ServiceOrderController@updateByAjax')->name('service_order_update');

          Route::get('service-order/{id}/email', 'ServiceOrderController@email')->name('service_order_email');

    });

  });

  });

});

Route::get('user/{id}/online', 'UserOnlineController@online')->name('user_online');
Route::get('user/{id}/offline', 'UserOfflineController@offline')->name('user_offline');

Route::get('clients/import-json', 'ClientController@importJson')->name('clients_import_json');
Route::get('addresses/import-json', 'AddressesController@importJson')->name('adresses_import_json');
Route::get('employees/import-json', 'EmployeesController@importJson')->name('employees_import_json');

Route::get('delivery-order/{id}/start-delivery', 'DeliveryOrderController@start')->name('start_delivery_public');

Route::get('delivery-order/{id}/delivery', 'DeliveryOrderController@deliveryReceipt')->name('delivery_receipt_view');
Route::get('delivery-order/{id}/delivery/receipt/print', 'DeliveryOrderController@deliveryReceiptImage')->name('delivery_receipt_image');

Route::get('tickets/auto-search/by/email', 'TicketsController@autoSearchTicketsByEmail')->name('auto_search_tickets_by_email');
