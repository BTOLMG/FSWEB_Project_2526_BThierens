<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->rol === 'administrator') {
                return redirect()->intended('/admin');
            } elseif ($user->rol === 'actorbeheerder') {
                return redirect()->intended('/account');
            }
            return redirect()->route('index');
        }

        throw ValidationException::withMessages([
            'email' => 'Onjuiste inloggegevens.',
        ]);
    }

    public function logout(Request $request = null)
    {
        Auth::logout();
        if ($request != null){
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return redirect()->route('login');
    }
}
