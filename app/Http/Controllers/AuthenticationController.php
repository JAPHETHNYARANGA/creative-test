<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);

            $email = $request['email'];
            $user = User::where('email', $email)->firstOrFail();

            $credentials = $request->only('email', 'password');

            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }


            if (Auth::attempt($credentials)) {

                if ($user) {
                    $token = $user->createToken('UserAuthentication')->plainTextToken;
                    return response([
                        'success' => true,
                        'message' => 'User logged in successfully',
                        'token' => $token,
                        'user' => $user
                    ], 200);
                } else {
                    Auth::logout(); 
                    return response([
                        'success' => false,
                        'message' => 'Failed to login'
                    ], 401);
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function register(Request $request)
    {
        try {
            $request->validate([
                'firstName' => 'required',
                'lastName' => 'required',
                'password' => 'required',              
                'email' => 'required|unique:users,email', // Ensure email uniqueness
            ]);

            $user = new User();

            $user->password = Hash::make($request->password);
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;

            $res = $user->save();

            if ($res) {
       
                return response()->json([
                    'success' => true,
                    'message' => 'User registered successfully. ',
                    'user' => $user
                ], 200);
            } else {
                return response([
                    'success' => false,
                    'message' => 'Failed to register user'
                ], 201);
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            // Check if the error is due to duplicate email
            if ($exception->errorInfo[1] === 1062) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email already used'
                ], 400);
            }

            // Other database-related errors
            return response()->json([
                'status' => false,
                'message' => 'Database error'
            ], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}



