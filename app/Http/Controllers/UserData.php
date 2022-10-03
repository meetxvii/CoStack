<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;


class UserData extends Controller
{
    public function checkUsername(Request $request){
        $username = $request->input('username');
        $user = User::where('username',$username)->first();
        if($user){
            return response([
                'message'=>'Username already exists'
            ],Response::HTTP_UNAUTHORIZED);
        }
        return response([
            'message'=>'Username is available'
        ]);
    }
    public function checkEmail(Request $request){
        $email = $request->input('email');
        $user = User::where('email',$email)->first();
        if($user){
            return response([
                'message'=>'Email already exists'
            ],Response::HTTP_UNAUTHORIZED);
        }
        return response([
            'message'=>'Email is available'
        ]);
    }
}
