@extends('layout.admin')

@section('view')

<div class="container-fluid content-box py-2 p-2">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
      <div class="row">

        <!-- Profile Picture -->
        <div class="col-12 col-md-3 col-lg-2 text-center mb-4">
          <div class="border bg-light rounded-4" style="padding: 1rem; border-radius: 10px; max-width: 200px; max-height: 200px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
            <img src="{{ $employee->photo ? asset('storage/' . $employee->photo) : asset('admin/images/profile/user.jpg') }}" 
            alt="Profile" 
            class="img-fluid rounded-4"
            style="max-width: 160px; max-height: 160px; object-fit: cover;">
          </div>
        </div>

        <!-- Employee Info -->
        <div class="col-12 col-md-9 col-lg-10">
          <div class="mb-4 ps-3">
            <h4 class="fw-bold mb-4">PATIENT INFORMATION</h4>
            <div class="row">
              <div class="col-md-6">
                <p><span class="text-muted">PHILHEALTH No:</span> <strong>{{ $employee->philhealth_no ?? 'N/A' }}</strong></p>
                <p><span class="text-muted">Last Name:</span> <strong>{{ $employee->last_name }}</strong></p>
                <p><span class="text-muted">First Name:</span> <strong>{{ $employee->first_name }}</strong></p>
                <p><span class="text-muted">Middle Name:</span> <strong>{{ $employee->middle_name ?? '-' }}</strong></p>
                <p><span class="text-muted">Sex:</span> <strong>{{ $employee->sex ?? '-' }}</strong></p>
                <p><span class="text-muted">Birthdate:</span> <strong>{{ $employee->birthdate ?? 'mm/dd/yyyy' }}</strong></p>
                <p><span class="text-muted">Civil Status:</span> <strong>{{ $employee->civil_status ?? '-' }}</strong></p>
              </div>
              <div class="col-md-6">
                <p><span class="text-muted">Religion:</span> <strong>{{ $employee->religion ?? '-' }}</strong></p>
                <p><span class="text-muted">Age:</span> <strong>{{ $employee->age ?? '00' }}</strong></p>
                <p><span class="text-muted">Contact Number:</span> <strong>{{ $employee->contact_no ?? '-' }}</strong></p>
                <p><span class="text-muted">Status:</span> <strong>{{ $employee->status ?? '-' }}</strong></p>
                <p><span class="text-muted">Designation:</span> <strong>{{ $employee->designation ?? '-' }}</strong></p>
                <p><span class="text-muted">Division:</span> <strong>{{ $employee->division ?? '-' }}</strong></p>
                <p><span class="text-muted">Department:</span> <strong>{{ $employee->department ?? '-' }}</strong></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- Action Buttons -->
      <div class="d-flex gap-2">
        <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-warning btn-md">Edit</a>

        <form action="{{ route('employee.destroy', $employee->id) }}" method="POST" class="d-inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger btn-md"
          onclick="return confirm('Are you sure you want to delete this employee?')">
            Delete
          </button>
        </form>

        <a href="{{ route('employee.index') }}" class="btn btn-secondary btn-md">Back to List</a>
      </div>

    </div>
  </div>
</div>

@endsection
