<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\Session;
use Carbon;

class SessionController extends Controller
{
    public function index(){
        $data = Session::get();
        if($data){
            return response()->json([
                'result' => true,
                'message' => 'Success get session.',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'error' => 'Something went wrong.'
            ], 404);
        }
    }

    public function getId($id){
        $data = Session::where('ID', $id)->first();
        if($data){
            return response()->json([
                'result' => true,
                'message' => 'Success get session by id '.$id,
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'error' => 'Something went wrong.'
            ], 404);
        }
    }

    public function create(Request $request){
        $this->validate($request, [
            'userid' => 'required',
            'name' => 'required',
            'description' => 'required',
            'start' => 'required',
            'duration' => 'required'
        ]);
        $existuser = User::where('ID', $request->userid)->first();
        $existsession = Session::where('userID', $request->userid)->first();
        if(!empty($existuser)){
            if(empty($existsession)){
                $data = Session::create([
                    'userID'=>$request->userid,
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'start'=>$request->start,
                    'duration'=>$request->duration,
                    'created'=>Carbon\Carbon::now()->toDateTimeString(),
                    'updated'=>Carbon\Carbon::now()->toDateTimeString(),
                ]);

                if($data){
                    return response()->json([
                        'result' => true,
                        'message' => 'Success create session',
                        'data' => $data
                    ], 201);
                }else{
                    return response()->json([
                        'error' => 'something went wrong'
                    ], 400);
                }
            }else{
                return response()->json([
                    'error' => 'User ID already exist.'
                ], 400);
            }
        }else{
            return response()->json([
                'error' => 'User ID Not Found.'
            ], 404);
        }
    }

    public function update(Request $request,$id){
        $this->validate($request, [
            'userid' => 'required',
            'name' => 'required',
            'description' => 'required',
            'start' => 'required',
            'duration' => 'required'
        ]);
        $existuser = User::where('ID', $request->userid)->first();
        $existsession = Session::where('userID', $request->userid)->first();
        if(!empty($existuser)){
            if($existsession->ID == $id){
                $data = Session::where('ID', $id)->update([
                    'userID'=>$request->userid,
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'start'=>$request->start,
                    'duration'=>$request->duration,
                    'updated'=>Carbon\Carbon::now()->toDateTimeString(),
                ]);

                if($data){
                    return response()->json([
                        'result' => true,
                        'message' => 'Success update session by id '.$id,
                        'data' => $data
                    ], 201);
                }else{
                    return response()->json([
                        'error' => 'something went wrong'
                    ], 400);
                }
            }else{
                return response()->json([
                    'error' => 'User ID already exist'
                ], 400);
            }
        }else{
            return response()->json([
                'error' => 'User ID Not Found.'
            ], 404);
        }
    }

    public function delete($id){
        $data = Session::where('ID', $id)->delete();
        if($data){
            return response()->json([
                'result' => true,
                'message' => 'Success delete session by id '.$id,
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'error' => 'Something went wrong.'
            ], 404);
        }
    }
}