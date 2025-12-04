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
use App\Http\Controllers\DoctorStatusController;


// -------------------------------------------------------
// PUBLIC ROUTES
// -------------------------------------------------------

Route::get('/', function () {
    return view('welcome');
})->middleware('web');

// Login
Route::get('/login', function () {
    return view('login');
})->name('login');

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

    return redirect()->intended(Auth::user()->role === 'admin' ? '/admin/dashboard' : '/');
})->name('login.post');

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Register
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
        'role' => 'user',
    ]);

    return redirect()->route('login')->with('success', 'Account created! Please log in.');
});

// -------------------------------------------------------
// ADMIN ROUTES
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
    Route::get('/appointment/search/employees', [AppointmentController::class, 'searchEmployees'])->name('appointment.searchEmployees');
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::delete('/appointment/{id}', [AppointmentController::class, 'destroy'])->name('appointment.destroy');
    Route::patch('/appointment/{id}/status', [AppointmentController::class, 'updateStatus'])->name('appointment.updateStatus');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
    Route::get('/reports/pdf/{type}/{mode?}', [ReportController::class, 'generatePDF'])->name('reports.pdf');

    // Inventory (Admin)
    Route::get('/inventory/ajax', [InventoryController::class, 'ajax'])->name('admin.inventory.ajax');
    Route::get('/inventory', [InventoryController::class, 'index'])->name('admin.inventory');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('admin.inventory.store');
    Route::get('/inventory/{inventory}/edit', [InventoryController::class, 'edit'])->name('admin.inventory.edit');
    // Page-based edit view
    Route::get('/inventory/{inventory}/edit-page', [InventoryController::class, 'editPage'])->name('admin.inventory.editPage');
    Route::patch('/inventory/{inventory}', [InventoryController::class, 'update'])->name('admin.inventory.update');
    Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy'])->name('admin.inventory.destroy');
});


// -------------------------------------------------------
// Notifications
// -------------------------------------------------------

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
});

// Public route
Route::get('/doctor-status', [DoctorStatusController::class, 'getStatus'])->name('doctor.status');

// Admin route
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::post('/doctor-status/toggle', [DoctorStatusController::class, 'toggle'])->name('doctor.status.toggle');
    // ... existing admin routes
});

// Update welcome route
Route::get('/', function () {
    $doctorStatus = \App\Models\DoctorStatus::getCurrentStatus();
    return view('welcome', compact('doctorStatus'));
})->middleware('web');