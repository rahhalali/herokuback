<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\KPI;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPUnit\TextUI\Exception;

class EmployeeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:191',
            'lastname' => 'required|max:191',
            'email' => 'required|max:191',
            'file_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'team_id' => 'required|max:20',
            'role_id' => 'required|max:20',
            'phone' => 'required|max:20'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(), 'status' => 400
            ]);
        } else {
            $employee = new Employee();
            $check = Employee::where('email', $request->email)->first();
            if ($check) {
                return response()->json([
                    'message' => 'This email is already taken'
                    , 'status' => 401]);
            } else {
                $employee->firstname = $request->input('firstname');
                $employee->lastname = $request->input('lastname');
                $employee->phone_number = $request->input('phone');
                $employee->email = $request->input('email');
                $employee->team_id = $request->input('team_id');
                $employee->role_id = $request->input('role_id');

                if ($request->hasFile('file_path')) {
                    $file = $request->file('file_path');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('upload/product/', $filename);
                    $employee->file_path = 'upload/product/' . $filename;
                }
                $employee->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Record Added Successfully'
                ]);
            }
        }
    }

    public function index()
    {
        return Employee::all();
    }
    public function getOne($id)
    {
        return Employee::find($id);
    }
    public function Delete($id)
    {
        $news = Employee::findOrFail($id)->pluck('firstname');
        $result = Employee::where("id", $id)->delete();
        if ($result)
            return ["results" => "the Employee $news has been deleted", 'status' => 200];
    }
    public function Update(Request $request, $id)
    {
        $employee = Employee::find($id);
            try{
                if($request->has('firstname')) {
                    $employee->firstname = $request->input('firstname');
                }
                if($request->has('lastname')){
                    $employee->lastname = $request->input('lastname');
                }
                if($request->has('phone')){
                    $employee->phone_number = $request->input('phone');
                }
                if($request->has('email')){
                    $check = Employee::where('email', $request->email)->first();
                    if ($check) {
                        return response()->json([
                            'message' => 'This email is already taken'
                            , 'status' => 401]);
                    }else{
                        $employee->email = $request->input('email');
                    }
                }

                if ($request->has('team_id')) {
                    $employee->team_id = $request->input('team_id');
                }
                if ($request->has('role_id')) {
                    $employee->role_id = $request->input('role_id');
                }
                if ($request->hasFile('file_path')) {
                    $file = $request->file('file_path');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('upload/product/', $filename);
                    $employee->file_path = 'upload/product/' . $filename;
                }

                $employee->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Record Added Successfully'
                ]);
            }catch (\Exception $exception) {
                return \response()->json([
                    'status' => 403,
                    'message' => 'You have to Update the remaining fields'
                ]);
            }

    }
    public function GetAll()
    {
        $employee = Employee::with('team','role','team.project')->get();
        return $employee;
    }

    public function filter($id,$Id)
    {
        try {
            if ($Id > 0 && $id > 0) {
                $Employee = DB::table('employees')
                    ->join('teams', 'team_id', '=', 'teams.id')
                    ->join('project_teams', 'teams.id', '=', 'project_teams.team_id')->where('project_teams.team_id', '=', $id)
                    ->join('projects', 'project_teams.project_id', '=', 'projects.id')->where('projects.id', '=', $Id)
                    ->get();
                return response()->json([
                    'message' => $Employee,
                    'status' => 200
                ]);
            } else {
                $Employee = Employee::all();
                return response()->json([
                    'message' => $Employee
                ]);
            }

        } catch (\Exception $exception) {
                return response()->json([
                    'message'=>"error"
                ]);
        }
    }
    public function GetKpi($id)
    {
        $Employee =DB::table('kpis')
            ->join('employee_kpis','kpis.id','=','employee_kpis.kpi_id')
            ->join('employees','employee_kpis.employee_id','=','employees.id')
            ->where('employees.id','=',$id)
            ->select('kpis.kpi_name','kpis.id')->distinct()
            ->get();
        return $Employee;
    }
    public function GetKpiNumber($id,$Id)
    {
        $Employee =DB::table('kpis')
            ->join('employee_kpis','kpis.id','=','employee_kpis.kpi_id')->where('kpis.id',$Id)
            ->join('employees','employee_kpis.employee_id','=','employees.id')
            ->where('employees.id','=',$id)
            ->select('kpis.kpi_name','employee_kpis.kpi_number','employee_kpis.created_at')
            ->get();
        return $Employee;
    }
    public function last_price($id)
    {
        $rate =  Employee::with('KPI','KPI.last_price')->where('id','=',$id)->get();
        return $rate;
    }


}
