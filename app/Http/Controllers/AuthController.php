<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Điều hướng dựa trên vai trò
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.index');
            }
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Show registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/admin/dashboard');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }

    // Password Reset Logic
    public function showResetForm($token = null)
    {
        return view('auth.passwords.reset')->with(['token' => $token]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Logic to send password reset link email
    }

    public function resetPassword(Request $request)
    {
        // Logic to reset password
    }
}
