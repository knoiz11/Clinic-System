<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        return view('admin.employees.consultation', compact('employee'));

    }
}
