<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordEmailController extends Controller
{
    //
    public function send_password_reset_link(Request $request){

        $response = Password::sendResetLink($request->only('email'));

        if ($response == Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Password reset link sent to your email.'], 200);
        } elseif ($response == Password::INVALID_USER) {
            return response()->json(['error' => 'No user found with that email address.'], 422);
        } else {
            // If there is an unexpected error, return a generic message
            return response()->json(['error' => trans($response)], 500);
        }
    }
}
