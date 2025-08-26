<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InlineAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
        ]);

        $remember = (bool) $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            // Return to the same page (booking form)
            return back()->with('login_ok', 'Welcome back! You can complete your booking now.');
        }

        return back()->withErrors(['login' => 'Invalid credentials'])->withInput();
    }
}
