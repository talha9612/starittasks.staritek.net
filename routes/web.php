<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admin\AdminControler;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['admin']],function(){
    Route::get('/admin/', 'Admin\AdminController@index');
    Route::get('/admin/manager', 'Admin\ManagerController@index');
    Route::post('/admin/add-manager', 'Admin\ManagerController@AddManager');
    Route::post('/admin/edit-manager', 'Admin\ManagerController@EditManager');
    Route::post('/admin/update-manager', 'Admin\ManagerController@UpdateManager');
    Route::post('/admin/delete-manager', 'Admin\ManagerController@DeleteUser');
    Route::get('/admin/projects', 'Admin\ProjectController@index');
    Route::post('/admin/project-edit', 'Admin\ProjectController@ProjectEdit');
    Route::post('/admin/update-project', 'Admin\ProjectController@UpdateProject');
    Route::post('/admin/project-delete', 'Admin\ProjectController@ProjectDelete');
    Route::post('/admin/save-catagory', 'Admin\ProCatagoryController@SaveCatagory');
    Route::post('/admin/add-project', 'Admin\ProjectController@AddProject');
    Route::get('/admin/tasks', 'Admin\TasksController@index');
    Route::post('/admin/add-task', 'Admin\TasksController@AddTask');
    Route::post('/admin/edit-task', 'Admin\TasksController@EditTask');
    Route::post('/admin/update-task', 'Admin\TasksController@UpdateTask');
    Route::post('/admin/task-delete', 'Admin\TasksController@DeleteTask');
    Route::get('/admin/setting/', 'Admin\SettingController@index');
    Route::get('/admin/logout/', 'Admin\AdminController@Logout');
    
    


    // Ajax Links
    Route::get('/admin/prjectheads', 'Admin\AdminController@ProjectHeads');
    Route::get('/admin/admin-change-status-user', 'Admin\ManagerController@ChangeStatus');
    Route::get('/admin/catagory', 'Admin\ProCatagoryController@index');
    Route::post('/admin/delete-project-catagory/', 'Admin\ProCatagoryController@DelProCategory'); 
    Route::get('/admin/task-catagory', 'Admin\TaskCataController@TaskCatagory');
    Route::post('/admin/add-task-catagory', 'Admin\TaskCataController@AddTaskCatagory');
    Route::post('/admin/delete-task-catagory/', 'Admin\TaskCataController@DeleteTaskCatagory');
    Route::post('/admin/select-head/', 'Admin\TasksController@SelectHead');
    Route::get('/admin/select-team-managers/', 'Admin\ManagerController@SelectTeamManager');
    // For Theme Setting
    Route::get('/admin/admin-change-theme-setting', 'Admin\ThemeSettingController@index');
    Route::get('/admin/admin-change-topheader-setting', 'Admin\ThemeSettingController@TopHeader');
    Route::get('/admin/admin-change-minsidebar-setting', 'Admin\ThemeSettingController@MinSideBar');
    Route::get('/admin/admin-change-sidebar-setting', 'Admin\ThemeSettingController@SideBar');
    Route::get('/admin/admin-change-boxshadow-setting', 'Admin\ThemeSettingController@BoxShadow');

    
});
Route::group(['middleware' => ['manager']],function(){
    Route::get('/manager/', 'Manager\ManagerController@index');
    Route::get('/manager/projects', 'Manager\projectController@index');
    Route::get('/manager/users', 'Manager\ManagerController@Team');
    Route::post('/manager/add-user', 'Manager\ManagerController@AddTeam');
    Route::post('/manager/edit-manager', 'Manager\ManagerController@EditTeam');
    Route::post('/manager/update-manager', 'Manager\ManagerController@UpdateTeam');
    Route::post('/manager/delete-manager', 'Manager\ManagerController@DeleteTeam');
    Route::post('/manager/assign-project', 'Manager\ProjectController@AssignProject');
    Route::post('/manager/add-project', 'Manager\ProjectController@AddProject');
    Route::post('/manager/project-edit', 'Manager\ProjectController@EditProject');
    Route::post('/manager/update-project', 'Manager\ProjectController@UpdatedProject');
    Route::post('/manager/project-delete', 'Manager\ProjectController@DeleteProject');
    Route::get('/manager/tasks', 'Manager\TaskController@index');
    Route::post('/manager/add-task', 'Manager\TaskController@AddTask');
    Route::post('/manager/edit-task', 'Manager\TaskController@EditTask');
    Route::post('/manager/update-task', 'Manager\TaskController@UpdateTask');
    Route::post('/manager/delete-task', 'Manager\TaskController@DeleteTask');


    // Ajax Links 
    Route::get('/manager/prjectheads', 'Manager\ManagerController@ProjectHeads');
    Route::get('/manager/catagory', 'Manager\ProCatagoryController@index');
    Route::get('/manager/manager-approved-task', 'Manager\TaskController@TaskApproved');
    // For Department
    Route::get('/manager/department', 'Manager\ProDepartmentController@index');
    Route::post('/manager/save-department', 'Manager\ProDepartmentController@SaveDepartment');
    Route::post('/manager/delete-project-department/', 'Manager\ProDepartmentController@DelProDepartment');
    // For Skill
    Route::get('/manager/skill', 'Manager\ProSkillController@index');
    Route::post('/manager/save-skill', 'Manager\ProSkillController@SaveSkill');
    Route::post('/manager/delete-project-skill/', 'Manager\ProSkillController@DelProSkill'); 
    // For Theme Setting
    Route::get('/manager/manager-change-theme-setting', 'Manager\ThemeSettingController@index');
    Route::get('/manager/manager-change-topheader-setting', 'Manager\ThemeSettingController@TopHeader');
    Route::get('/manager/manager-change-minsidebar-setting', 'Manager\ThemeSettingController@MinSideBar');
    Route::get('/manager/manager-change-sidebar-setting', 'Manager\ThemeSettingController@SideBar');
    Route::get('/manager/manager-change-boxshadow-setting', 'Manager\ThemeSettingController@BoxShadow');
   
});

Route::group(['middleware' => ['user']],function(){
    Route::get('/user/', 'User\UserController@index');
    Route::post('/user/project', 'User\ProjectController@index');


    // Ajax Links
    Route::post('/user/single-task-model/', 'User\TaskController@SingleTaskModel');
    Route::post('/user/single-task-model-complete/', 'User\TaskController@SingleTaskComplete');
     // For Theme Setting
     Route::get('/user/user-change-theme-setting', 'User\ThemeSettingController@index');
     Route::get('/user/user-change-topheader-setting', 'User\ThemeSettingController@TopHeader');
     Route::get('/user/user-change-minsidebar-setting', 'User\ThemeSettingController@MinSideBar');
     Route::get('/user/user-change-sidebar-setting', 'User\ThemeSettingController@SideBar');
     Route::get('/user/user-change-boxshadow-setting', 'User\ThemeSettingController@BoxShadow');
});