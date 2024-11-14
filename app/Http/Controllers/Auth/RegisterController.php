<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    //method to register a new user
    public function signup(Request $request){

        try{
            $validation = $request->validate([
                'full_name' => 'string|max:255',
                'email' => 'required|string|email|unique:users,email|max:255',
                'phone_number' => 'required|string|unique:users,phone_number|max:255',
                'password' => 'required|string|min:8|confirmed',
            ]);

        }catch(ValidationException $e){
            return response()->json(['errors' => $e->errors()], 422);
        }

        $user = User::create([
            'email' => $validation['email'],
            'phone_number' => $validation['phone_number'],
            'full_name' => $validation['full_name'],
            'password' => Hash::make($validation['password']),
        ]);

        if($user) return response()->json(['Message' => 'User created successfully'], 201);
        else return response()->json(['Error' => 'Failed to create user'], 500);
    }
}
