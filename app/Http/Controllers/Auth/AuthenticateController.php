<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateController extends Controller
{
    //login method to authenticate user and issue JWT
    public function login(Request $request){

        $credentials = $request->only('email', 'password');

        //Attempt to verify the credentials and create a token for the user
        try{
            if(! $token = JWTAuth::attempt($credentials)){
                return response()->json([ 'Error' => 'Incorrect login credentials'], 401);
            }
        }catch(JWTException $e){
            return response()->json(['Error' => 'Could not create token'], 500);
        }

        return response()->json(compact('token'));
    }

    //logout method to invalidate the token
    public function logout(){

        try{

            $user = JWTAuth::parseToken()->authenticate();
            JWTAuth::invalidate(JWTAuth::getToken());
        }
        catch(JWTException $e){
            return response()->json(['error' => 'Token is invalid or expired'], 401);
        }


        return response()->json(['message' => 'Logout successful']);
    }
}
