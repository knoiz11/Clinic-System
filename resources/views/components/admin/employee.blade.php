@extends('layout.admin')

@section('employee')
<div class="container-fluid mt-4">

    <!-- Header + Add Employee Button -->
    <div class="d-flex justify-content-between mb-3">
        <h3>Employees</h3>
        <a href="{{ route('employee.create') }}" class="btn btn-primary">Add Employee</a>
    </div>
    
    <!-- Employee Table -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:50px;"></th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Sex</th>
                    <th>Birthdate</th>
                    <th>Age</th>
                    <th>Civil Status</th>
                    <th>Religion</th>
                    <th>Blood Type</th>
                    <th>Employee ID</th>
                    <th>PHILHEALTH No.</th>
                    <th>Status</th>
                    <th>Designation</th>
                    <th>Division</th>
                    <th>Department</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr data-bs-toggle="collapse" data-bs-target="#employee-{{ $employee->id }}" class="accordion-toggle">
                    <td><i class="bi bi-caret-down-fill"></i></td>
                    <td>{{ $employee->last_name ?? '-' }}</td>
                    <td>{{ $employee->first_name ?? '-' }}</td>
                    <td>{{ $employee->middle_name ?? '-' }}</td>
                    <td>{{ $employee->sex ?? '-' }}</td>
                    <td>{{ optional($employee->birthdate)->format('m/d/Y') ?? '-' }}</td>
                    <td>{{ $employee->age ?? '-' }}</td>
                    <td>{{ $employee->civil_status ?? '-' }}</td>
                    <td>{{ $employee->religion ?? '-' }}</td>
                    <td>{{ $employee->blood_type ?? '-' }}</td>
                    <td>{{ $employee->employee_id ?? '-' }}</td>
                    <td>{{ $employee->philhealth_no ?? '-' }}</td>
                    <td>{{ $employee->status ?? '-' }}</td>
                    <td>{{ $employee->designation ?? '-' }}</td>
                    <td>{{ $employee->division ?? '-' }}</td>
                    <td>{{ $employee->department ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="hiddenRow p-0">
                        <div class="collapse" id="employee-{{ $employee->id }}">
                            <div class="p-3 bg-light border d-flex gap-2">
                                <a href="{{ route('employee.show', $employee->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('consultation.show', $employee->id) }}" class="btn btn-secondary btn-sm">Consultation</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
