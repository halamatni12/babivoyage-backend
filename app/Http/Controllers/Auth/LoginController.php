<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;             
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function store(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'message'    => 'Login successful',
            'user'       => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
                'phone' => $user->phone,
            ],
            'token_type' => 'Bearer',
            'token'      => $token,
        ]);
    }


    public function destroy(): JsonResponse
    {
        $token = request()->user()?->currentAccessToken();

        if ($token) {
            $token->delete();
        }

        return response()->json(['message' => 'Logged out']);
    }

  
    public function me(): JsonResponse
    {
        $u = request()->user();

        return response()->json([
            'id'    => $u->id,
            'name'  => $u->name,
            'email' => $u->email,
            'role'  => $u->role,
            'phone' => $u->phone,
        ]);
    }
         public function showForm()
    {
        return view('userside.login');
    }

    public function loginWeb(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
        ]);

        $remember = $request->boolean('remember', false);

        // ✅ Always use "web" guard for session login
        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'))
                ->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials provided.',
        ])->onlyInput('email');
    }

    public function logoutWeb(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
}
