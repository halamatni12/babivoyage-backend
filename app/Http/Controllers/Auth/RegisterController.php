<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],                // hashed via cast
            'phone'    => $data['phone'] ?? null,
            'role'     => $data['role']  ?? 'customer',
        ]);

        // Personal Access Token (Sanctum)
        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'message'    => 'Registration successful',
            'user'       => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
                'phone' => $user->phone,
            ],
            'token_type' => 'Bearer',
            'token'      => $token,
        ], 201);
    }
}
