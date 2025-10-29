<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

// Handle login with specific error messages
Route::post('/login', function (Request $request) {
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::where('username', $request->username)->first();

    if (!$user) {
        return back()->withErrors([
            'username' => 'Username not found.',
        ]);
    }

    if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
        return back()->withErrors([
            'password' => 'Wrong password.',
        ]);
    }

    $request->session()->regenerate();
    return redirect()->intended('/dashboard');
})->name('login.post');

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

    User::create([
        'username' => $validated['username'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    return redirect()->route('login')->with('success', 'Account created! Please log in.');
});

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    /*
     * Employee Routes (CRUD)
     */

    Route::prefix('employee')->name('employee.')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/', [EmployeeController::class, 'store'])->name('store');
        Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
        Route::put('/{employee}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
        Route::get('/{employee}/view', [EmployeeController::class, 'show'])->name('show');
    });

    /*
     * Consultation Routes
     */
        Route::get('/consultation/{employee}', [ConsultationController::class, 'show'])
        ->name('consultation.show');
    


    /*
     * Appointment Routes
     */


    Route::get('/appointment', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::delete('/appointment/{id}', [AppointmentController::class, 'destroy'])->name('appointment.destroy');
    Route::patch('/appointment/{id}/status', [AppointmentController::class, 'updateStatus'])->name('appointment.updateStatus');



    /*
     * Reports Routes (placeholders)
     */
    Route::view('/reports', 'admin.reports')->name('reports');
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/pdf/{type}/{mode?}', [App\Http\Controllers\ReportController::class, 'generatePDF'])
    ->name('reports.pdf');

});


