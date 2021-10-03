<?php

namespace App\Http\Controllers;

use App\Models\ProjectTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProTeamController extends Controller
{
    //
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_id' => 'required|max:20',
            'project_id' => 'required|max:20',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(), 'status' => 400
            ]);
        }else{
            try{
                $pro = new ProjectTeam();
                $pro->project_id = $request->input('project_id');
                $pro->team_id = $request->input('team_id');
                $pro->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Record Added Successfully'
                ]);
            }catch (\Exception $exception){
                return response()->json([
                    'message'=>'You cannot assign This project with team!.',
                    'status'=>403
                ]);
            }

        }
    }


}
