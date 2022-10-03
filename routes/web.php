<?php

use App\Mail\SendTaskMail;
use App\Mail\SendMarkDownMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;
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

Route::get('/', function(){
    if (Auth::check()) {
       if(Auth::user()->role == 1){
            return redirect('admin');
       }else if(Auth::user()->role == 2){
            return redirect('manager');
       }else if(Auth::user()->role == 3){
            return redirect('user');
       }
    }else{
        return view('auth.login');
    }
    
});
Route::get('/login', 'CompanyController@ForLogin');
Route::get('/register-company', 'CompanyController@RegisterCompany');

Auth::routes();

Route::post('/add-company','CompanyController@AddCompanyInfo');
Route::group(['middleware' => ['admin']],function(){
    Route::get('/home', 'Admin\AdminController@index');
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
    Route::get('/admin/save-catagory', 'Admin\ProCatagoryController@SaveCatagory');
    Route::post('/admin/add-project', 'Admin\ProjectController@AddProject');
    Route::get('/admin/tasks', 'Admin\TasksController@index');
    Route::post('/admin/add-task', 'Admin\TasksController@AddTask');
    Route::post('/admin/edit-task', 'Admin\TasksController@EditTask');
    Route::post('/admin/update-task', 'Admin\TasksController@UpdateTask');
    Route::post('/admin/task-delete', 'Admin\TasksController@DeleteTask');
    Route::get('/admin/setting/', 'Admin\SettingController@index');
    Route::get('/admin/logout/', 'Admin\AdminController@Logout');
    // Admin Profile 
    Route::get('/admin/profile/', 'Admin\ProfileController@index');
    Route::post('/admin/update-profile', 'Admin\ProfileController@UpdateProfile');
    Route::get('/admin/check-password', 'Admin\ProfileController@CheckPassword');
    Route::post('/admin/update-password', 'Admin\ProfileController@UpdatePassword');
    // Admin Setting Update
    Route::post('/admin/update-setting', 'Admin\SettingController@UpdateSetting');

    // Admin Check Email
    Route::get('/admin/checkEmail', 'Admin\ProfileController@CheckEamil');
    Route::get('/admin/single-task-model/', 'Admin\TasksController@SingleTaskModel');
    Route::post('/admin/projectdetails/', 'Admin\ProjectDetailController@index');


    // Ajax Links
    Route::get('/admin/prjectheads', 'Admin\AdminController@ProjectHeads');
    Route::get('/admin/admin-change-status-user', 'Admin\ManagerController@ChangeStatus');
    Route::get('/admin/catagory', 'Admin\ProCatagoryController@index');
    Route::get('/admin/delete-project-catagory/', 'Admin\ProCatagoryController@DelProCategory'); 
    Route::get('/admin/task-catagory', 'Admin\TaskCataController@TaskCatagory');
    Route::get('/admin/add-task-catagory', 'Admin\TaskCataController@AddTaskCatagory');
    Route::get('/admin/delete-task-catagory/', 'Admin\TaskCataController@DeleteTaskCatagory');
    Route::get('/admin/select-head/', 'Admin\TasksController@SelectHead');
    Route::get('/admin/select-team-managers/', 'Admin\ManagerController@SelectTeamManager');
    // For Department
    Route::get('/admin/department', 'Admin\ProDepartmentController@index');
    Route::get('/admin/save-department', 'Admin\ProDepartmentController@SaveDepartment');
    Route::get('/admin/delete-project-department/', 'Admin\ProDepartmentController@DelProDepartment');
    // For Skill
    Route::get('/admin/skill', 'Admin\ProSkillController@index');
    Route::get('/admin/save-skill', 'Admin\ProSkillController@SaveSkill');
    Route::get('/admin/delete-project-skill/', 'Admin\ProSkillController@DelProSkill');
    // For Theme Setting
    Route::get('/admin/admin-change-theme-setting', 'Admin\ThemeSettingController@index');
    Route::get('/admin/admin-change-topheader-setting', 'Admin\ThemeSettingController@TopHeader');
    Route::get('/admin/admin-change-minsidebar-setting', 'Admin\ThemeSettingController@MinSideBar');
    Route::get('/admin/admin-change-sidebar-setting', 'Admin\ThemeSettingController@SideBar');
    Route::get('/admin/admin-change-boxshadow-setting', 'Admin\ThemeSettingController@BoxShadow');
    Route::get('/admin/single-task-model/', 'Admin\TasksController@SingleTaskModel');
    
});
Route::group(['middleware' => ['manager']],function(){
    Route::get('/home', 'Manager\ManagerController@index');
    Route::get('/manager/', 'Manager\ManagerController@index');
    Route::get('/manager/projects', 'Manager\ProjectController@index');
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
    // Manager Profile 
    Route::get('/manager/profile/', 'Manager\ProfileController@index');
    Route::post('/manager/update-profile', 'Manager\ProfileController@UpdateProfile');
    Route::get('/manager/setting', 'Manager\SettingController@index');
    Route::get('/manager/check-password', 'Manager\ProfileController@CheckPassword');
    Route::post('/manager/update-password', 'Manager\ProfileController@UpdatePassword');

    Route::post('/manager/projectdetails/', 'Manager\ProjectDetailController@index');
    Route::post('/manager/privous-add-user', 'Manager\ManagerController@OtherTeamMember');

    // Ajax Links 
    Route::get('/manager/prjectheads', 'Manager\ManagerController@ProjectHeads');
    Route::get('/manager/catagory', 'Manager\ProCatagoryController@index');
    Route::get('/manager/save-catagory', 'Manager\ProCatagoryController@SaveCategory');
    Route::get('/manager/delete-project-catagory', 'Manager\ProCatagoryController@DelProCategory');
    Route::get('/manager/manager-approved-task', 'Manager\TaskController@TaskApproved');
    // For Department
    Route::get('/manager/department', 'Manager\ProDepartmentController@index');
    Route::get('/manager/save-department', 'Manager\ProDepartmentController@SaveDepartment');
    Route::get('/manager/delete-project-department/', 'Manager\ProDepartmentController@DelProDepartment');
    // For Skill
    Route::get('/manager/skill', 'Manager\ProSkillController@index');
    Route::get('/manager/save-skill', 'Manager\ProSkillController@SaveSkill');
    Route::get('/manager/delete-project-skill/', 'Manager\ProSkillController@DelProSkill');
    // Task Category
    Route::get('/manager/task-catagory', 'Manager\TaskCategoryController@index');
    Route::get('/manager/add-catagory', 'Manager\TaskCategoryController@AddCategory');
    Route::get('/manager/delete-task-catagory', 'Manager\TaskCategoryController@DelProCategory');

    // For Theme Setting
    Route::get('/manager/manager-change-theme-setting', 'Manager\ThemeSettingController@index');
    Route::get('/manager/manager-change-topheader-setting', 'Manager\ThemeSettingController@TopHeader');
    Route::get('/manager/manager-change-minsidebar-setting', 'Manager\ThemeSettingController@MinSideBar');
    Route::get('/manager/manager-change-sidebar-setting', 'Manager\ThemeSettingController@SideBar');
    Route::get('/manager/manager-change-boxshadow-setting', 'Manager\ThemeSettingController@BoxShadow');
    Route::get('/manager/single-task-model/', 'Manager\TaskController@SingleTaskModel');
});

Route::group(['middleware' => ['user']],function(){
    Route::get('/home', 'User\UserController@index');
    Route::get('/user/', 'User\UserController@index');
    Route::post('/user/project', 'User\ProjectController@index');
    // Manager Profile 
    Route::get('/user/profile/', 'User\ProfileController@index');
    Route::post('/user/update-profile', 'User\ProfileController@UpdateProfile');
    Route::get('/user/setting', 'User\SettingController@index');
    Route::get('/user/check-password', 'User\ProfileController@CheckPassword');
    Route::post('/user/update-password', 'User\ProfileController@UpdatePassword');

    // Ajax Links
    Route::get('/user/single-task-model/', 'User\TaskController@SingleTaskModel');
    Route::post('/user/single-task-model-complete/', 'User\TaskController@SingleTaskComplete');
     // For Theme Setting
     Route::get('/user/user-change-theme-setting', 'User\ThemeSettingController@index');
     Route::get('/user/user-change-topheader-setting', 'User\ThemeSettingController@TopHeader');
     Route::get('/user/user-change-minsidebar-setting', 'User\ThemeSettingController@MinSideBar');
     Route::get('/user/user-change-sidebar-setting', 'User\ThemeSettingController@SideBar');
     Route::get('/user/user-change-boxshadow-setting', 'User\ThemeSettingController@BoxShadow');
});
Route::get('checkEmail','CompanyController@CheckEamil');
Route::get('sendEmail',function(){
    $task = []; 
    $user = [];
    Mail::to("abidijaz280@gmail.com")->send( new SendMarkDownMail($task,$user)); 
    echo "send Email";
});
Route::get("/active", function(){
    return Activity::where('subject_id',17)->get();
});