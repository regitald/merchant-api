<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false,'code' => 400,'message' => $validator->errors()],400);
        }

        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['status' => false,'code' => 400,'message' => 'Invalid credentials'],400);
            }
        } catch (JWTException $e) {
            return response()->json(['status' => false,'code' => 500,'message' => 'Cant create token'],500);
        }
        $user = User::with('merchant')->where('email',$request->email)->first();
        
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Success',
            'data' => [
                'users' => $user,
                'token' => $token,
            ],
        ]);
    }
    public function profile()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['status' => false,'code' => 404,'message' => 'User not found!'],404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['status' => false,'code' => $e->getStatusCode(),'message' => 'Token expired'],$e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['status' => false,'code' => $e->getStatusCode(),'message' => 'Token invalid'],$e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['status' => false,'code' => $e->getStatusCode(),'message' => 'Token errors'],$e->getStatusCode());

        }
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Success',
            'data' => [
                'users' => $user
            ]
        ]);
    }
    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        try {
            JWTAuth::parseToken()->invalidate( $token );
            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Success'
            ]);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['status' => false,'code' => $e->getStatusCode(),'message' => 'Token errors'],$e->getStatusCode());
        }
    }


}
