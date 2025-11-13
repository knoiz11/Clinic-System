<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DashboardController;


// -------------------------------------------------------
// PUBLIC ROUTES
// -------------------------------------------------------

Route::get('/', function () {
    return view('welcome');
})->middleware('web');


// Login page
Route::get('/login', function () {
    return view('login');
})->name('login');

// Handle login
Route::post('/login', function (Request $request) {
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::where('username', $request->username)->first();

    if (!$user) {
        return back()->withErrors(['username' => 'Username not found.']);
    }

    if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
        return back()->withErrors(['password' => 'Wrong password.']);
    }

    $request->session()->regenerate();

    // ✅ Redirect based on role
    if (Auth::user()->role === 'admin') {
        return redirect()->intended('/admin/dashboard');
    } else {
        return redirect()->intended('/');
    }
})->name('login.post');

// Logout route
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Register routes
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    User::create([
        'username' => $validated['username'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' => 'user', // default role
    ]);

    return redirect()->route('login')->with('success', 'Account created! Please log in.');
});

// -------------------------------------------------------
// ADMIN ROUTES (Protected by Auth + Admin Middleware)
// -------------------------------------------------------

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


    // Employee Routes
    Route::prefix('employee')->name('employee.')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/', [EmployeeController::class, 'store'])->name('store');
        Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
        Route::put('/{employee}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
        Route::get('/{employee}/view', [EmployeeController::class, 'show'])->name('show');
    });

    // Consultation
    Route::get('/consultation/{employee}', [ConsultationController::class, 'show'])
        ->name('consultation.show');

    // Appointment
    Route::get('/appointment', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::delete('/appointment/{id}', [AppointmentController::class, 'destroy'])->name('appointment.destroy');
    Route::patch('/appointment/{id}/status', [AppointmentController::class, 'updateStatus'])->name('appointment.updateStatus');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
    Route::get('/reports/pdf/{type}/{mode?}', [ReportController::class, 'generatePDF'])->name('reports.pdf');

    // Inventory (admin access)
    Route::get('/inventory', [InventoryController::class, 'index'])->name('admin.inventory');
});

// -------------------------------------------------------
// AUTHENTICATED USER ROUTES (Non-admin)
// -------------------------------------------------------

Route::middleware(['auth'])->group(function () {
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
});

// -------------------------------------------------------
// NOTIFICATION ROUTES
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
});


// -------------------------------------------------------





