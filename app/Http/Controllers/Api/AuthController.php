<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Inicio de sesión y creación de token
     */
    public function login(Request $request){
        
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)){
            return response()->json([
                'message'=> 'Invalid email or password'
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('Access Token');
 
        $user->access_token = $token->accessToken;
 
        return response()->json([
            "user"=>$user
        ], 200);
    }

    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request){
        
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'User logged out successfully'
        ], 200);
    }

    /**
     * Obtener el objeto User como json
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function index(){
        echo "Hello World";
    }
}
