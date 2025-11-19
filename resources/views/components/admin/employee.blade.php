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
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr data-bs-toggle="collapse" data-bs-target="#employee-{{ $employee->id }}" class="accordion-toggle">
                    <td><i class="bi bi-caret-down-fill"></i></td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->designation ?? '-' }}</td>
                    <td>{{ $employee->department ?? '-' }}</td>
                    <td>{{ $employee->status ?? '-' }}</td>
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
