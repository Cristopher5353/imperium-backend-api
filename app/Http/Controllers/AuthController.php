<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = request(['email', 'password']);

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    "status" => 400,
                    "message" => "Usuario y/o contraseña incorrecta",
                    "data" => []
                ]);
            }
        } catch (JWTException $e) {
            return response()->json([
                "status" => 500,
                "message" => "No se pudo crear el token",
                "data" => []
            ]);
        }

        $user = User::where('email', $request->email)->first();
        $tokenAuth = JWTAuth::fromUser($user, ["role" => $user->role_id]);

        return response()->json([
            "status" => 200,
            "message" => "Usuario Logueado correctamente",
            "data" => [$tokenAuth]
        ]);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'first_surname' => 'required|string|max:255',
            'last_surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(),400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'first_surname' => $request->get('first_surname'),
            'last_surname' => $request->get('last_surname'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role_id' => 2,
            'state' => 1
        ]);

        return response()->json([
            "status" => 201,
            "message" => "Usuario registrado correctamente",
            "data" => []
        ]);
    }
}
