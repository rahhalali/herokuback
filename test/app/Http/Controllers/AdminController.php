<?php

namespace App\Http\Controllers;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Admin[]|Collection
     */
    public function index()
    {
        return Admin::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:191',
            'email' => 'required|max:191',
            'password' => 'required|max:191'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(), 'status' => 400
            ]);
        } else {
            $admin = new Admin();
            $admin->Username = $request->input('username');
            $admin->Email = $request->input('email');
            $admin->Password = Hash::make($request->input('password'));
            $admin->save();
            return response()->json(['message' => 'Added Successfully', 'status' => 201]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return string
     */
   public function login(Request $req){
        $admin = Admin::where('email',$req->email)->first();
        if(!$admin || !Hash::check($req->password,$admin->Password)){
            return response(['message'=>['these credentials do not match or records.'] ,'status'=> 404]);
        }
        $token =$admin->createToken('my-app-token')->plainTextToken;
        $response =[
            'admin' => $admin,
            'token'=>$token,
            'status'=>200
        ];
        return response(['message'=>$response,'status'=> 201]);

    }

}
