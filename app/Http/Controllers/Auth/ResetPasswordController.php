<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    //
    public function resetPassword(Request $request){

        try{

            $validation = $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:8|confirmed',
                'token' => 'required',
            ]);

        }catch(ValidationException $e){
            return response()->json(['errors' => $e->errors()], 422);
        }

        $response = Password::broker()->reset($validation, function($user, $password){
            $user->password = Hash::make($password);
            $user->save();
        });

        // return response()->json(['message' => 'User password updated successfully']);

        if($response === Password::PASSWORD_RESET) return response()->json(['message' => 'User password updated successfully']);
        else return response()->json(['error' => trans($response)]);

    }
}
