<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendTestMailController extends Controller
{
    //
    public function sendTestMail(){
        Mail::raw('This is a text mail', function($message){
            $message->to('tatis80540@cironex.com')->subject('Tesxt Mail');
        });
    }
}
