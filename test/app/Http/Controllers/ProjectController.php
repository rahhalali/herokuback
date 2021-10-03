<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    //
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request ->all(),[
            'project_name'=>'required|max:191'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->messages() , 'status'=>400
            ]);
        }else{
            $check = Project::where('project_name', $request->project_name)->first();
            if ($check) {
                return response()->json([
                    'message' => 'This Project name is already taken'
                    , 'status' => 401]);
            }else{
                $project =new Project();
                $project-> project_name = $request->input('project_name');
                $project->save();
                return response()->json([
                    'message'=>'Project added successfully','status'=>200
                ]);
            }
        }
    }
    public function index(){
        return Project::all();
    }
    public function Delete($id)
    {
        $news = Project::findOrFail($id)->pluck('project_name');
        $result = Project::where("id", $id)->delete();
        if ($result)
            return response()->json(["results" => "The project $news has been deleted",'status'=>200]);
    }
    public function getOne($id)
    {
        return Project::find($id);
    }
    public function Update(Request $request,$id): JsonResponse
    {
        $team=Project::find($id);
        $team->project_name = $request->input('project_name');
        $team->save();
        return response()->json([
            'message'=>'Updated Successfully','status'=>200
        ]);

    }
    public function CountEmployee()
    {
        $projects = Project::with('team','team.employees')->get();
        foreach ($projects as $project){
            foreach ($project['team'] as $team){
                $team->counts = sizeof($team['employees']);
            }
        }
        return $projects;
    }
}
