<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
class AdminAuth extends Controller
{
    public function login(Request $request){
        if(!Auth::attempt($request->only('username','email','password', 'role'))){
            return response([
                'message'=>'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt',$token,60*24*30);
        return response([
            'message'=>'success',
            'user'=>$user
        ])->withCookie($cookie);

    }
    public function admin()
    {
        return Auth::user();
    }
    public function logout(Request $request){
        $cookie = Cookie::forget('jwt');
        return response([
            'message'=>'success'
        ])->withCookie($cookie);
    }

}
