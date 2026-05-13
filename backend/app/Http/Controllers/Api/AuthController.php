<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $r)
    {
        $data = $r->validate([
            'name'     => 'required|string|max:120',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        $user = User::create($data);
        $token = $user->createToken('api')->plainTextToken;
        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $r)
    {
        $data = $r->validate(['email' => 'required|email', 'password' => 'required']);
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages(['email' => ['Invalid credentials.']]);
        }
        $token = $user->createToken('api')->plainTextToken;
        return response()->json(compact('user', 'token'));
    }

    public function logout(Request $r)
    {
        $r->user()->currentAccessToken()->delete();
        return response()->json(['ok' => true]);
    }

    public function me(Request $r)
    {
        return response()->json($r->user());
    }
}
