<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
class AuthController extends Controller
{
    public  function register(Request $request){
        return User::create([
            "username"=>$request->input('username'),
            "email"=>$request->input('email'),
            "password"=>Hash::make($request->input('password')),
            "status"=>true,
            "email_verified"=>false,
            "info"=>false,
        ]);
    }
    
    public function login(Request $request){
        if(!Auth::attempt($request->only('username','email','password'))){
            return response([
                'message'=>'Invalid credentials'
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

    public function user()
    {
        return Auth::user();
    }

    public function logout(){
        $cookie = Cookie::forget('jwt');
        return response([
            'message'=>'success'
        ])->withCookie($cookie);
    }
}
