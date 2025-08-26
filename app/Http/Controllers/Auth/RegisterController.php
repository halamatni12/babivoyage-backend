<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;         // ✅ Correct Request
use Illuminate\Support\Facades\Auth; // ✅ Correct Auth facade
use Illuminate\Support\Facades\Hash; // ✅ Correct Hash facade

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
     public function showForm()
    {
        return view('userside.register');
    }

    public function registerWeb(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Account created successfully!');
    }
}
