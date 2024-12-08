<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('login');
    }

    public function actionLogin(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Get the credentials from the request
        $credentials = $request->only('email', 'password');

        // Attempt to log the user in with the provided credentials
        if (Auth::attempt($credentials)) {
            // If login is successful, return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => Auth::user(),
                'redirect_url' => route('home'),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Email or Password is incorrect',
        ], 401);
    }

    public function actionLogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
