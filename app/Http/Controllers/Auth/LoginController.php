<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // 👇 Add this method
    protected function username()
    {
        return 'username'; // use "username" column instead of email
    }

    public function showLoginForm()
    {
        return view('auth.login'); // make sure you have this blade
    }

    public function login(Request $request)
    {
    $credentials = $request->validate([
        'name' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }


        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
