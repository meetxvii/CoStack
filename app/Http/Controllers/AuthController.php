<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Mail\Signup;
use App\Models\Tokens;
use Lcobucci\JWT\Token;

class AuthController extends Controller
{
    public function register(Request $request){
        $user =  User::create([
            "username"=>$request->input('username'),
            "email"=>$request->input('email'),
            "password"=>Hash::make($request->input('password')),
            "is_active"=>true,
            "is_verified"=>false,
            "info"=>false,
        ]);
        $token = Tokens::create([
            'token'=>bin2hex(random_bytes(40)),
            'user_id'=>$user->id,
        ]);
        Mail::to($user->email)->send(new Signup($token->token));
        return $user;
    }
    
    public function login(Request $request){
        if(!Auth::attempt($request->only('username','email','password','role'))){
            return response([
                'message'=>'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = Auth::user();
        if($user->role=='admin'){
            return response([
                'message'=>'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }
        if($user->is_active=='0'){
            return response([
                'message'=>'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }
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

    public function resetPassword(Request $request){

        $user = User::where('email',$request->email)->first();
        if(!$user){
            return response([
                'message'=>'Email not found'
            ],Response::HTTP_NOT_FOUND);
        }

        //create token for reset password
        $token = Tokens::create([
            'token'=>bin2hex(random_bytes(40)),
            'user_id'=>$user->id,
        ]);

        
        return response()->json(Mail::to($request->email)->send(new ResetPassword($token->token)));
    }

    function checkToken(Request $request){
        $token = Tokens::where('token',$request->token)->where('is_active', 1)->first();
        if(!$token){
            return response([
                'message'=>'Invalid token'
            ],Response::HTTP_NOT_FOUND);
        }
        // $token->is_active = 0;
        // $token->save();
        return response([
            'token'=>$token,
        ]);
    }

    function changePassword(Request $request){
        $user = User::where('id',$request->user_id)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(["message"=>"success"]);
    }

    function verify(Request $request){
        $token = Tokens::where('token',$request->token)->where('is_active', 1)->first();
        if(!$token){
            return response([
                'message'=>'Invalid token'
            ],Response::HTTP_NOT_FOUND);
        }
        $user = User::where('id',$token->user_id)->first();
        $user->is_verified = 1;
        $user->save();
        $token->is_active = 0;
        $token->save();
        return response([
            'message'=>'success'
        ]);
    }

}
