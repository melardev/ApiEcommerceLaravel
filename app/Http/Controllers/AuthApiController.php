<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends BaseController
{


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            # code...
            return $this->sendError('errors', $validator->errors());
        }
        /*

                $credentials = $Request->only('email', 'password');
                try {
                    // if(failed to authenticate using jwt token provided by user)
                    if (!$token = JWTAuth::attempt($credentials))
                        return response()->json(['error' => 'invalid username and password'], 401);

                } catch (JWTException $e) {
                    return response()->json(['error' => 'could not create token'], 500);
                }

                */
        // Success login! return the token
        $credentials = $request->only('username', 'password');
        $user = User::where('username', $credentials['username'])->first();
        if ($user == null)
            return response()->json(['error' => 'invalid username'], 401);
        $hasher = app('hash');
        //Hash::make($Request->get('password'))
        $valid = $hasher->check($credentials['password'], $user->getAuthPassword());

        try {
            // if(failed to authenticate using jwt token provided by user)
            // $jwt = JWTAuth::attemp($Request->only('email', 'password')); // Tymon\JWTAuth::attempt()

            //if (!$token = JWTAuth::attempt($credentials))
            if (!$valid)
                return response()->json(['error' => 'invalid username and password'], 401);

            $token = JWTAuth::fromUser($user);

        } catch (JWTException $e) {
            return response()->json(['success' => false, 'error' => 'could not create token'], 500);
        }

        // Success login! return the token
        // return response()->json(compact($token));
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'roles' => array_map(function ($role) {
                    return $role['name'];
                    // other way: $user->roles()->get()->toArray()
                }, $user->roles->toArray()), // array_map takes an array, so we convert a Laravel Collection to a php array
            ],

        ]);

    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
        ]);
        // Check if validation fails
        if ($validator->fails())
            // Return error message if failure
            return $this->sendError('errors', $validator->errors());

        // Register the user
        $user = User::create([
            'username' => $request->get('username'),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);

        // generate the jwt token
        $token = JWTAuth::fromUser($user);
        return $this->sendSuccessResponse(null, "User registered successfully");
    }
}
        