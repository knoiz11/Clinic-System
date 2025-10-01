<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User; // 👈 add this

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

// 👇 Handle login with specific error messages
Route::post('/login', function (Request $request) {
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    // Check if username exists
    $user = User::where('username', $request->username)->first();

    if (!$user) {
        return back()->withErrors([
            'username' => 'Username not found.',
        ]);
    }

    // Check if password is wrong
    if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
        return back()->withErrors([
            'password' => 'Wrong password.',
        ]);
    }

    // Successful login
    $request->session()->regenerate();
    return redirect()->intended('/dashboard');
})->name('login.post');

    // 👇 Logout route
    Route::post('/logout', function (Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed', 
    ]);

    $user = \App\Models\User::create([
        'username' => $validated['username'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    return redirect()->route('login')->with('success', 'Account created! Please log in.');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

route::get('/employee', function () {
    return view('employee');
})->middleware('auth');

route::get('/appointment', function () {
    return view('appointment');
})->middleware('auth');

route::get('/reports', function () {
    return view('reports');
})->middleware('auth');

use App\Http\Controllers\AppointmentController;

Route::get('/appointment', [AppointmentController::class, 'create'])->middleware('auth')->name('appointment.create');
Route::post('/appointment', [AppointmentController::class, 'store'])->middleware('auth')->name('appointment.store');


/*
Route::view('/employees/view', 'admin.employees.view')->name('employees.view');
Route::view('/employees/consultation', 'admin.employees.consultation')->name('employees.consultation');

Route::view('/reports/employee', 'admin.reports.employees')->name('reports.employees');
Route::view('/reports/illnesses', 'admin.reports.illnesses')->name('reports.illnesses');
Route::view('/reports/visits', 'admin.reports.visits')->name('reports.visits');
*/
