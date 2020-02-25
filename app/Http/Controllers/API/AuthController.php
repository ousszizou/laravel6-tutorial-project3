<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Validator;

class AuthController extends Controller
{
    // register
    public function register(Request $request)
    {

        $v = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        if ($v->fails()) {
            return response()->json([
                "status" => "error",
                "errors" => $v->errors()
            ], 422);
        }

        $user = new User([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);
        $user->save();
        return response()->json([
            "message" => "Successfully created user."
        ], 201);
    }

    // login user & create token
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = $request->only("email", "password");
        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }
        return response()->json(["error" => "Your Email/Password is wrong"], 401);
    }

    // refresh JWT token
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    // get authenticated user
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json(['data' => $user]);
    }

    // logout user form application
    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            "status" => "success",
            "msg" => "Logged out successfully."
        ], 200);
    }

    private function guard()
    {
        return Auth::guard();
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }
}
