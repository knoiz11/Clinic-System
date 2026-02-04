@extends('layout.admin')

@section('employee')
<div class="container-fluid mt-4">

    <div class="content-box" style="gap: 10px; flex-wrap: wrap; padding: 2rem; border-radius: 8px;">
    <!-- Header + Add Employee Button + Search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
        <h3>Employees</h3>
        <p class="text-muted mb-0">Manage and view employee information</p>
        </div>
        <div class="d-flex gap-2">
            <div class="d-flex gap-2 align-items-center">

    <!-- Status Filter -->
    <select id="statusFilter" class="form-select bg-white" style="width: 160px;">
        <option value="">All Status</option>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
        <option value="On Leave">On Leave</option>
    </select>

    <!-- Search Input -->
    <div class="input-group" style="width: 300px;">
        <span class="input-group-text">
            <i class="bi bi-search text-black"></i>
        </span>
        <input type="text" 
               id="employeeTableSearch" 
               class="form-control bg-white" 
               placeholder="Search employees...">
    </div>

            </div>
            <a href="{{ route('employee.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add Employee</a>
        </div>
    </div>
    <br>
    <!-- Employee Table -->
    <div class="table-responsive">
        <table class="table text-wrap align-middle mb-0">
            <thead>
                <tr class="text-center">
                    <th></th>
                    <th class="text-center">Employee ID</th>
                    <th class="text-center">Last Name</th>
                    <th class="text-center">First Name</th>
                    <th class="text-center">Middle Name</th>
                    <th class="text-center">Sex</th>
                    <th class="text-center">Birthdate</th>
                    <th class="text-center">Age</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Designation</th>
                    <th class="text-center">Division</th>
                    <th class="text-center">Department</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr data-bs-toggle="collapse"data-bs-target="#employee-{{ $employee->id }}"class="accordion-toggle employee-row"data-status="{{ $employee->status }}">
                    <td></td>
                    <td class="text-center">{{ $employee->employee_id ?? '-' }}</td>
                    <td class="text-center">{{ $employee->last_name ?? '-' }}</td>
                    <td class="text-center">{{ $employee->first_name ?? '-' }}</td>
                    <td class="text-center">{{ $employee->middle_name ?? '-' }}</td>
                    <td class="text-center">{{ $employee->sex ?? '-' }}</td>
                    <td class="text-center">{{ optional($employee->birthdate)->format('m/d/Y') ?? '-' }}</td>
                    <td class="text-center">{{ $employee->age ?? '-' }}</td>
                    <td class="text-center">{{ $employee->status ?? '-' }}</td>
                    <td class="text-center">{{ $employee->designation ?? '-' }}</td>
                    <td class="text-center">{{ $employee->division ?? '-' }}</td>
                    <td class="text-center">{{ $employee->department ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="12" class="hiddenRow p-0">
                        <div class="collapse" id="employee-{{ $employee->id }}">
                            <div class="p-3 border d-flex gap-2" style="background-color: #EFF0F2;">
                                <a href="{{ route('employee.show', $employee->id) }}" class="btn btn-info btn-md">View</a>
                                <a href="{{ route('consultation.show', $employee->id) }}" class="btn btn-secondary btn-md">Consultation</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

<!-- Add the search script -->
<script src="{{ asset('admin/js/employeeTableSearch.js') }}"></script>
<script src="{{ asset('admin/js/employeeStatusFilter.js') }}"></script>

@endsection