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

    // Consultation (existing route)
    Route::get('/consultation/{employee}', [ConsultationController::class, 'show'])
        ->name('consultation.show');

    // ============================================
    // CONSULTATION RECORDS ROUTES (NEW)
    // ============================================
    Route::prefix('employee/{employeeId}/consultation')->group(function () {
        
        // Get all records at once (for page load)
        Route::get('/all', [ConsultationController::class, 'getAllRecords'])->name('consultation.all');
        
        // Vital Signs
        Route::get('/vital-signs', [ConsultationController::class, 'getVitalSigns'])->name('consultation.vital-signs.index');
        Route::post('/vital-signs', [ConsultationController::class, 'storeVitalSign'])->name('consultation.vital-signs.store');
        Route::put('/vital-signs/{id}', [ConsultationController::class, 'updateVitalSign'])->name('consultation.vital-signs.update');
        Route::delete('/vital-signs/{id}', [ConsultationController::class, 'deleteVitalSign'])->name('consultation.vital-signs.delete');
        
        // Physical Exam
        Route::get('/physical-exams', [ConsultationController::class, 'getPhysicalExams'])->name('consultation.physical-exams.index');
        Route::post('/physical-exams', [ConsultationController::class, 'storePhysicalExam'])->name('consultation.physical-exams.store');
        Route::put('/physical-exams/{id}', [ConsultationController::class, 'updatePhysicalExam'])->name('consultation.physical-exams.update');
        Route::delete('/physical-exams/{id}', [ConsultationController::class, 'deletePhysicalExam'])->name('consultation.physical-exams.delete');
        
        // Consultation
        Route::get('/consultations', [ConsultationController::class, 'getConsultations'])->name('consultation.consultations.index');
        Route::post('/consultations', [ConsultationController::class, 'storeConsultation'])->name('consultation.consultations.store');
        Route::put('/consultations/{id}', [ConsultationController::class, 'updateConsultation'])->name('consultation.consultations.update');
        Route::delete('/consultations/{id}', [ConsultationController::class, 'deleteConsultation'])->name('consultation.consultations.delete');
        
        // Doctor's Order
        Route::get('/doctor-orders', [ConsultationController::class, 'getDoctorOrders'])->name('consultation.doctor-orders.index');
        Route::post('/doctor-orders', [ConsultationController::class, 'storeDoctorOrder'])->name('consultation.doctor-orders.store');
        Route::put('/doctor-orders/{id}', [ConsultationController::class, 'updateDoctorOrder'])->name('consultation.doctor-orders.update');
        Route::delete('/doctor-orders/{id}', [ConsultationController::class, 'deleteDoctorOrder'])->name('consultation.doctor-orders.delete');
        
        // Laboratory
        Route::get('/laboratories', [ConsultationController::class, 'getLaboratories'])->name('consultation.laboratories.index');
        Route::post('/laboratories', [ConsultationController::class, 'storeLaboratory'])->name('consultation.laboratories.store');
        Route::put('/laboratories/{id}', [ConsultationController::class, 'updateLaboratory'])->name('consultation.laboratories.update');
        Route::delete('/laboratories/{id}', [ConsultationController::class, 'deleteLaboratory'])->name('consultation.laboratories.delete');
    });

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