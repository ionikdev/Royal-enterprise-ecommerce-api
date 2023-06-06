<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register (RegisterUserRequest $request){
        $validatedData = $request->validated();

        $user = User::create([
            'name'=>$validatedData['name'],
            'email'=> $validatedData['email'],
            'password'=> Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('API Token of ' . $user->name)->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'User successfully registered.',
            'user' => $user,
        ], 201);
    }
    public function login (LoginUserRequest $request){
        $validatedData = $request->validated();

        // Find the user by email address
        $user = User::where('email', $validatedData['email'])->first();
       
        // Check if user exists and password is correct
        if (!Auth::attempt($validatedData)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
         if($user->role_as ==1) //admin
        {
            $role = 'admin';
            $token= $user->createToken($user->email.'AdminToken', ['server:admin'])->plainTextToken;
        }
        else{
            $role = '';
            $token = $user->createToken($user->email.'_API Token  ' ,  [''])->plainTextToken;
        }

      // Generate an API token for the user

      return response()->json([
        'message' => 'User logged in successfully.',
        'user' => $user,
        'token' => $token,
        'role'=> $role,
    ], 201);

    }

    public function logout(Request $request)
{
    $request->user()->tokens()->delete();

    return response()->json(['message' => 'User logged out successfully.']);
}
}
