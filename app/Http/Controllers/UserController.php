<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if($validate->fails()){
            return response()->json($validate->errors()->toJson(), 400);
        }

        $data = [
            "username" => $request->username,
            "password" => Hash::make($request->password)
        ];

        $newUser = User::create($data);

        $token = JWTAuth::fromUser($newUser);

        return response()->json(data:compact('newUser','token'), status:201);
    }

    public function login(Request $request)
    {
        $credentials = [
            "username" => $request->username,
            "password" => $request->password
        ];

        if ( $user = User::where('username', '=', $credentials['username'])->first() ) {
            if ( !Hash::check($credentials['password'], $user->password ) ) {
                return [ 'error' => true ];
            } else {
                try {
                    $token = JWTAuth::fromUser($user);
                    return response()->json(['token' => $token], 200);
                } catch (JWTException $e) {
                    return response()->json(['error' => 'could_not_create_token'], 500);
                }
            }
        }
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }
}
