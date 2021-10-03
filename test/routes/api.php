<?php

use App\Http\Controllers\Emp_KpiController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\KPIController;
use App\Http\Controllers\ProTeamController;
use App\Http\Controllers\TeamController;
use App\Models\Employee;
use App\Models\Employee_Kpi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get("/getadmins",[AdminController::class,'index']);

    //add employee add teams
    Route::post('/add-employee',[EmployeeController::class,'store']);
    Route::post('/teams',[TeamController::class,'store']);
    Route::post("/admins",[AdminController::class,'store']);
    Route::post("/projects",[ProjectController::class,'store']);
    Route::post("/roles",[RoleController::class,'store']);
    Route::post("/proteams",[ProTeamController::class,'store']);
    Route::post('/kpis',[KPIController::class,'store']);
    Route::post('/emp_kpi',[Emp_KpiController::class,'store']);

    //get all projects and all teams and all roles
    Route::get('/get/reports',[EmployeeController::class,'GetAll']);
    Route::get('/get/emp_kpi',[KPIController::class,'index']);
    Route::get('/get/project-team-one/{id}',[TeamController::class,'getOneMany']);
    //get single record
    Route::get('/get/employee-one/{id}',[EmployeeController::class,'getOne']);
    Route::get('/get/team-one/{id}',[TeamController::class,'getOne']);
    Route::get('/get/project-one/{id}',[ProjectController::class,'getOne']);
    Route::get('/get/role-one/{id}',[RoleController::class,'getOne']);
    Route::get('/get/employee-kpi/{id}',[EmployeeController::class,'GetKpi']);

    //Delete Records
    Route::delete('/delete-employee/{id}',[EmployeeController::class,'Delete']);
    Route::delete('/delete-team/{id}',[TeamController::class,'Delete']);
    Route::delete('/delete-project/{id}',[ProjectController::class,'Delete']);
    Route::delete('/delete-role/{id}',[RoleController::class,'Delete']);
    //Update Records
    Route::put('/update-employee/{id}',[EmployeeController::class,'Update']);
    Route::put('/update-team/{id}',[TeamController::class,'Update']);
    Route::put('/update-project/{id}',[ProjectController::class,'Update']);
    Route::put('/update-role/{id}',[RoleController::class,'Update']);

    Route::delete('/delete-project-from-team/{id}/project/{Id}',[TeamController::class,'DeleteOne']);
    Route::get('/get/teams',[TeamController::class,'index']);
    Route::get('/get/projects',[ProjectController::class,'index']);
    // get the filter
    Route::get('/get/filter/{team}/project/{project}',[EmployeeController::class,'filter']);
    //get all reports

    Route::get('/get/roles',[RoleController::class,'index']);
    Route::get('/get/project-teams',[TeamController::class,'Teams']);



    Route::get('/get/getall',[Emp_KpiController::class,'GetAll']);

    Route::get('/get/employeeee-kpi-number/{id}',[EmployeeController::class,'last_price']);
    Route::get('/get/employee-list',[EmployeeController::class,'index']);
});
    Route::post('/login',[AdminController::class,'login']);
    Route::get('/get/count-projects',[TeamController::class,'CountProject']);
    Route::get('/get/count-employees',[ProjectController::class,'CountEmployee']);


Route::get('/get/employee-kpi-number/{id}/kpi/{Id}',[EmployeeController::class,'GetKpiNumber']);



