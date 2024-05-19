<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function login()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * This function will handle the login process.
     * It will first validate the input, then check if the user exists in the database,
     * then check if the password is correct and if the user is active.
     * If all checks pass, then the user is logged in and redirected to the dashboard page.
     */
    public function loginPost(Request $request)
    {
        //validation
        $validation = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        //login
        $user = User::where('email', $request->email)
            ->where('status', 1)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($validation)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    public function profile()
    {
        $user = Auth::user();

        return view('admin.auth.profile', compact('user'));
    }

    public function resetPassword()
    {
        return view('admin.auth.reset-password');
    }

    public function forgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    public function dashboard()
    {
        $user = Auth::user();

        return view('admin.auth.dashboard', compact('user'));
    }

    public function register()
    {
        return view('admin.auth.register');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * This function will log the user out of the application.
     * It will first log the user out using the Auth facade,
     * then it will invalidate the session, regenerate the token and redirect the user to the login page.
     */
    public function logout(Request $request)
    {
        // Log the user out
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token
        $request->session()->regenerateToken();

        // Redirect the user to the login page with a success message
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    }
}
