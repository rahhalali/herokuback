<?php

namespace App\Http\Controllers;


use App\Models\Employee_Kpi;
use App\Models\KPI;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KPIController extends Controller
{
    //
    public function store(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'kpi_name' => 'required|max:191']);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(), 'status' => 400
            ]);
        }else{
            try{
                $employee_kpi=new KPI();
                $employee_kpi->kpi_name =$request->input('kpi_name');
                $employee_kpi->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Record Added Successfully'
                ]);
            }catch (\Exception $exception){
                    return response()->json([
                        'message'=>'cannot added again',
                        'status'=>403
                    ]);
            }

        }

    }
    public function index()
    {
        return KPI::all();
    }
    public function index1()
    {
        return KPI::with('employee_kpi')->get();
    }
    public function GetKpiNumber($id)
    {
//        $Employee =DB::table('kpis')
//            ->join('employee_kpis','kpis.id','=','employee_kpis.kpi_id')
//            ->select(['kpis.kpi_name','employee_kpis.created_at'])->distinct()
//            ->select('employee_kpis.kpi_number')
//            ->join('kpis','employee_kpis.id','=','kpis.id')
//            ->get();
//

//        return $em;
    }





}
