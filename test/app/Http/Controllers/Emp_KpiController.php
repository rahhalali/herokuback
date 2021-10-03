<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee_Kpi;
use Illuminate\Support\Facades\Validator;

class Emp_KpiController extends Controller
{
    //
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kpi_id' => 'required',
            'employee_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(), 'status' => 400
            ]);
        }else{
            $emp_kpi = new Employee_Kpi();
            $emp_kpi->kpi_id = $request->input('kpi_id');
            $emp_kpi->employee_id = $request->input('employee_id');
            $emp_kpi->kpi_number = $request->input('kpi_number');
            $emp_kpi->save();

            return response()->json([
                'status' => 200,
                'message' => 'Record Added Successfully'
            ]);
        }
    }
    public function GetAll()
    {
        return Employee_Kpi::with('kpis','employee')->get();
    }
}
