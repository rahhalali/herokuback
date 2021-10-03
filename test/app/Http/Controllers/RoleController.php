<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    //
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request ->all(),[
            'role_name'=>'required|max:191'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->messages() , 'status'=>400
            ]);
        }else
        {
            $check = Role::where('role_name', $request->role_name)->first();
            if ($check) {
                return response()->json([
                    'message' => 'This Role name is already taken'
                    , 'status' => 401]);
            }else{
                $project =new Role();
                $project-> role_name = $request->input('role_name');
                $project->save();
                return response()->json([
                    'message'=>'Role added successfully','status'=>200
                ]);
            }
        }
    }
    public function index(){
        return Role::all();
    }
    public function Delete($id)
    {
        $news = Role::findOrFail($id)->pluck('role_name');
        $result = Role::where("id", $id)->delete();
        if ($result)
            return response()->json(["results" => "The role $news has been deleted",'status'=>200]);
    }
    public function Update(Request $request,$id): JsonResponse
    {
        $team=Role::find($id);
        $team->role_name = $request->input('role_name');
        $team->save();
        return response()->json([
            'message'=>'Updated Successfully','status'=>200
        ]);
    }
    public function getOne($id)
    {
        return Role::find($id);
    }
}
