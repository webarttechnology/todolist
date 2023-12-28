<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthManageController extends Controller
{
    //

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $responseArr['message'] = $validator->messages()->first();;
            return response()->json(['success' => 0, 'statusCode' => 422, 'msg' => $responseArr]);
        }

        if(User::whereEmail($request->email)->exists()){
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['success' => 0, 'statusCode' => 403, 'msg' => 'You have enter wrong credentials'], 401);              
            }else{
                $user = Auth::user();
                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json(['success' => 1, 'statusCode' => 200, 'data' => $user, 'token' => $token]);
            }
        }
    }
}
