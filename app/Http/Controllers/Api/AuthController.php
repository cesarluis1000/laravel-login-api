<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Registro de Usuario
     */
    public function signup(Request $request){

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = new User([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)            
        ]);

        $user->save();

        return response()->json([
            "message" => "User registered successfully"
        ], 201);

    }

    public function login(){
        echo "Login Endpoint Requested";
    }

    public function index(){
        echo "Hello World";
    }
}