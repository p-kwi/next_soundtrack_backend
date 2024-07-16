<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller {
  public function login(LoginRequest $request) {
    $credentials = $request->validated();

    $user = User::where('email', $credentials['email'])->first();

    if (!auth()->attempt($credentials) || !$user) {
      return response()->json([
        'errors' => ['incorrect' => ['Email or password is incorrect.']]
      ], 401);
    }


    $token = $user->createToken('authToken_' . $user->name)->plainTextToken;

    $data = array_merge($user->toArray(), ['token' => $token]);

    return response()->json([
      'message' => 'Login successfully.',
      'user' => $data,
      'status' => '200'
    ]);
  }


  public function register(RegisterRequest $request) {

    $data = $request->validated();
    $data['email_verified_at'] = now();

    $user = User::create($data);
    $token = $user->createToken('authToken_' . $user->name)->plainTextToken;

    $userInfo = array_merge($user->toArray(), ['token' => $token]);


    if ($user) {
      return response()->json([
        'user' => $userInfo,
        'message' => 'Register user successfully.',
        'status' => 201
      ], 201);
    }
  }


  public function logout(Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json([
      'message' => 'Logout successfully.',
      'status' => 200
    ], 200);
  }
}
