<?php

use App\Mail\SendTaskMail;
use App\Mail\SendMarkDownMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\register_new_company;
use App\Http\Controllers\Admin\ProDepartmentController;
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
       if(Auth::user()->role == 1 && Auth::user()->status == 1  ){
            return redirect('admin');
       }else if(Auth::user()->role == 2 && Auth::user()->status == 1 ){
            return redirect('manager');
       }else if(Auth::user()->role == 3 && Auth::user()->status == 1 ){
            return redirect('user');
       }else if(Auth::user()->role == 4 && Auth::user()->status == 1 ){
        return redirect('ceo');
        }
    }else{
        return view('auth.login');
    }
});

Route::post('/generateConfirmationCode', [CompanyController::class, 'generateConfirmationCode']);
Route::post('/register-new-company', [register_new_company::class, 'showRegisterNewCompanyForm'])->name('register_new_company');
Route::get('/login', 'CompanyController@ForLogin');
Route::get('/register-company', 'CompanyController@RegisterCompany');

Auth::routes();

Route::post('/add-company','CompanyController@AddCompanyInfo');

Route::group(['middleware' => ['CEO']],function(){
    Route::post('/ceo/single-task-model-complete/', 'CEO\TasksController@SingleTaskComplete');

    Route::get('/ceo','CEO\CeoController@index');
    Route::post('/update-task-status', 'CEO\TasksController@updateTaskStatus')->name('task/update/status');

    Route::get('/ceo/dashboardv2', 'CEO\CeoController@Dashboardv');
    Route::get('/ceo/logout/', 'CEO\CeoController@Logout');

    Route::get('/ceo/manager', 'CEO\ManagerController@index');
    Route::post('/ceo/add-manager', 'CEO\ManagerController@AddManager');
    Route::post('/ceo/add-ceo', 'CEO\ManagerController@AddCEO');
    Route::post('/ceo/edit-manager', 'CEO\ManagerController@EditManager');
    Route::post('/ceo/update-manager', 'CEO\ManagerController@UpdateManager');
    Route::post('/ceo/delete-manager', 'CEO\ManagerController@DeleteUser');

    Route::get('/ceo/projects', 'CEO\ProjectController@index');
    Route::post('/ceo/project-edit', 'CEO\ProjectController@ProjectEdit');
    Route::post('/ceo/update-project', 'CEO\ProjectController@UpdateProject');
    Route::post('/ceo/project-delete', 'CEO\ProjectController@ProjectDelete');
    Route::post('/ceo/add-project', 'CEO\ProjectController@AddProject');

    Route::get('/ceo/tasks', 'CEO\TasksController@index');
    Route::post('/ceo/add-task', 'CEO\TasksController@AddTask');
    Route::post('/ceo/edit-task', 'CEO\TasksController@EditTask');
    Route::post('/ceo/update-task', 'CEO\TasksController@UpdateTask');
    Route::post('/ceo/task-delete', 'CEO\TasksController@DeleteTask');
    Route::get('/ceo/single-task-model/', 'CEO\TasksController@SingleTaskModel');
    Route::post('/ceo/task/update', 'CEO\TasksController@updateTaskStatus')->name('task/update/status');
  
    // Admin Profile
    Route::get('/ceo/profile/', 'CEO\ProfileController@index');
    Route::post('/ceo/update-profile', 'CEO\ProfileController@UpdateProfile');
    Route::get('/ceo/check-password', 'CEO\ProfileController@CheckPassword');
    Route::post('/ceo/update-password', 'CEO\ProfileController@UpdatePassword');
    Route::get('/ceo/checkEmail', 'CEO\ProfileController@CheckEamil');
    // Admin Setting Update
    Route::get('/ceo/setting/', 'CEO\SettingController@index');
    Route::post('/ceo/update-setting', 'CEO\SettingController@UpdateSetting');

    Route::post('/ceo/projectdetails/', 'CEO\ProjectDetailController@index');
    Route::get('/ceo/save-catagory', 'CEO\ProCatagoryController@SaveCatagory');
    // Ajax Links
    Route::get('/ceo/prjectheads', 'CEO\CeoController@ProjectHeads');
    Route::get('/ceo/admin-change-status-user', 'CEO\ManagerController@ChangeStatus');
    Route::get('/ceo/catagory', 'CEO\ProCatagoryController@index');
    Route::get('/ceo/delete-project-catagory/', 'CEO\ProCatagoryController@DelProCategory');
    Route::get('/ceo/task-catagory', 'CEO\TaskCataController@TaskCatagory');
    Route::get('/ceo/add-task-catagory', 'CEO\TaskCataController@AddTaskCatagory');
    Route::get('/ceo/delete-task-catagory/', 'CEO\TaskCataController@DeleteTaskCatagory');
    Route::get('/ceo/select-head/', 'CEO\TasksController@SelectHead');
    Route::get('/ceo/select-team-managers/', 'CEO\ManagerController@SelectTeamManager');
    // For Department
    Route::get('/ceo/department', 'CEO\ProDepartmentController@index');
    Route::get('/ceo/save-department', 'CEO\ProDepartmentController@SaveDepartment');
    Route::get('/ceo/delete-project-department/', 'CEO\ProDepartmentController@DelProDepartment');
    // For Skill
    Route::get('/ceo/skill', 'CEO\ProSkillController@index');
    Route::get('/ceo/save-skill', 'CEO\ProSkillController@SaveSkill');
    Route::get('/ceo/delete-project-skill/', 'CEO\ProSkillController@DelProSkill');
    // For Theme Setting
    Route::get('/ceo/admin-change-theme-setting', 'CEO\ThemeSettingController@index');
    Route::get('/ceo/admin-change-topheader-setting', 'CEO\ThemeSettingController@TopHeader');
    Route::get('/ceo/admin-change-minsidebar-setting', 'CEO\ThemeSettingController@MinSideBar');
    Route::get('/ceo/admin-change-sidebar-setting', 'CEO\ThemeSettingController@SideBar');
    Route::get('/ceo/admin-change-boxshadow-setting', 'CEO\ThemeSettingController@BoxShadow');
    Route::get('/ceo/single-task-model/', 'CEO\TasksController@SingleTaskModel');
    Route::get('/ceo/showtaskhome/{id}', 'CEO\TasksController@ShowTaskhome');
    Route::get('/ceo/admin-change-project-assign', 'CEO\ProjectController@GetChangeProjectAssign');
    Route::post('/ceo/assign-project', 'CEO\ProjectController@AssignProject');
});
Route::group(['middleware' => ['admin']],function(){
    Route::post('/admin/single-task-model-complete/', 'Admin\TasksController@SingleTaskComplete');
    Route::get('/home', 'Admin\AdminController@index');
    Route::get('/admin/', 'Admin\AdminController@index');
    Route::get('/admin/dashboardv2', 'Admin\AdminController@Dashboardv');
    Route::get('/admin/manager', 'Admin\ManagerController@index');
    Route::post('/admin/add-manager', 'Admin\ManagerController@AddManager');

    Route::post('/admin/add-ceo', 'Admin\ManagerController@AddCEO');

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
    Route::post('/admin/delete-task', 'Admin\TasksController@DeleteTask');
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
    Route::post('/admin/save-department', 'Admin\ProDepartmentController@SaveDepartment');
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
    Route::get('/admin/showtaskdetail/{id}', 'Admin\TasksController@ShowTaskDetail');
    Route::get('/admin/admin-change-project-assign', 'Admin\ProjectController@GetChangeProjectAssign');
    Route::post('/admin/assign-project', 'Admin\ProjectController@AssignProject');
    Route::get('/admin/admin-approved-task', 'Admin\TasksController@TaskApproved');
    Route::get('/admin/admin-shows-task-ceo', 'Admin\TasksController@AdminShowsTaskCEO');
    Route::get('/admin/project-report', 'Admin\ProjectReportController@index');
    Route::post('/update-task-status', 'Admin\TasksController@updatestatustask')->name('/update/task/status');
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
    Route::get('/manager/showtaskdetail/{id}', 'Manager\TaskController@ShowTaskDetail');

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
    Route::post('/update-user-status', 'Manager\ManagerController@updateStatus');
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
Route::fallback(function () {
    dd('Route not found');
});
