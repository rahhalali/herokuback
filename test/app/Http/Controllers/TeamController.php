<?php

namespace App\Http\Controllers;



use App\Models\Employee;

use App\Models\Project;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class TeamController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(), 'status' => 400
            ]);
        } else {
            $check = Team::where('name', $request->name)->first();
            if ($check) {
                return response()->json([
                    'message' => 'This Team name is already taken'
                    , 'status' => 401]);
            }else{
                $team = new Team();
                $team->name = $request->input('name');
                $team->save();
                return response()->json([
                    'message' => 'Team added successfully', 'status' => 200
                ]);
            }
        }
    }

    public function index()
    {
        return Team::all();
    }
    public function getOne($id)
    {
        return Team::find($id);
    }
    public function Delete($id)
    {
        try {
            $news = Team::findOrFail($id)->pluck('name');
            if (Team::where("id", $id)->delete()) {
                return response()->json(["results" => "The Team $news has been deleted", 'status' => 200]);
                    }
                        } catch (Exception $exception){
                            return response()->json(['results' => 'This Team is assigned to employee, cannot be deleted', 'status' => 401]);
                    }
                 }
     public function Update(Request $request,$id): JsonResponse
     {
         $team = Team::find($id);
         $team->name = $request->input('name');
         $team->save();
         return response()->json([
             'message' => 'Updated Successfully', 'status' => 200
         ]);
     }
     public function Teams()
     {
         $Projects = Team::with('project')->get();
         return $Projects;
     }
     public function getOneMany($id)
     {
         $projects = Team::with('project')->where('id',$id)->get();
         return $projects;
     }
     public function DeleteOne($id,$Id)
     {
            $Name=Team::find($id)->name;
            $team = Team::find($id);
            $team->project()->detach($Id);
            return response()->json([
                'message'=>'In Team '.$Name.' 1 project has been deleted',
                'status'=>200
            ]);
     }
     public function CountProject()
     {
        $team =Team::with('project')->get();
        foreach ($team as $teams){
            $teams->count=sizeof($teams['project']);
        }
         return $team;
     }
}
