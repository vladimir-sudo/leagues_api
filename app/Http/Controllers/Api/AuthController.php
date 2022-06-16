<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createUser(Request $request)
    {
        User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User created',
            'success' => true
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateToken(Request $request)
    {
        if (Auth::attempt($request->all())) {
            Auth::user()->api_token = Str::random(60);
            Auth::user()->save();

            return response()->json([
                'api_token' => Auth::user()->api_token,
                'success' => true
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials',
            'success' => false
        ], 422);
    }
}
