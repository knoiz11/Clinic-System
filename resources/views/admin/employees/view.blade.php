@extends('layout.admin')

@section('view')
<!-- Body Wrapper -->
<div class="page-wrapper" id="main-wrapper"
     data-layout="vertical"
     data-navbarbg="skin6"
     data-sidebartype="full"
     data-sidebar-position="fixed"
     data-header-position="fixed">

  <!-- Sidebar -->
  @include('components.admin.sidebar')

  <!-- Main Wrapper -->
  <div class="body-wrapper">

    <!-- Header -->
    @include('components.admin.header')

    <!-- Page Content -->
    <div class="container-fluid py-4">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

          <div class="row">
            <!-- Employee Info -->
            <div class="col-md-8">
              <h5 class="fw-bold mb-3">PATIENT INFORMATION</h5>

              <p><strong>PHILHEALTH No:</strong> {{ $employee->philhealth_no ?? 'N/A' }}</p>
              <p><strong>Last Name:</strong> {{ $employee->last_name }}</p>
              <p><strong>First Name:</strong> {{ $employee->first_name }}</p>
              <p><strong>Middle Name:</strong> {{ $employee->middle_name ?? '-' }}</p>
              <p><strong>Sex:</strong> {{ $employee->sex ?? '-' }}</p>
              <p><strong>Birthdate:</strong> {{ $employee->birthdate ?? 'mm/dd/yyyy' }} 
                 <strong>Age:</strong> {{ $employee->age ?? '00' }}</p>
              <p><strong>Employment Status:</strong> {{ $employee->employment_status ?? '-' }}</p>
              <p><strong>Designation:</strong> {{ $employee->designation ?? '-' }}</p>
              <p><strong>Division:</strong> {{ $employee->division ?? '-' }}</p>
              <p><strong>Department:</strong> {{ $employee->department ?? '-' }}</p>
            </div>

            <!-- Profile Picture -->
            <div class="col-md-4 text-center">
              <div class="border p-3 rounded bg-light">
                <img src="{{ $employee->photo ? asset('storage/' . $employee->photo) : asset('admin/images/profile/user.jpg') }}" 
                     alt="Profile" 
                     class="img-fluid rounded"
                     style="max-width: 150px;">
              </div>
            </div>
          </div>

          <hr class="my-4">

          <!-- Consultation Record -->
          <h6 class="fw-bold mb-2">CONSULTATION RECORD</h6>
          <table class="table table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th>Consultation Date</th>
                <th>Nature of Visit</th>
                <th>Diagnosis</th>
                <th>Condition</th>
              </tr>
            </thead>
            <tbody>
              @forelse($employee->consultations ?? [] as $consultation)
                <tr>
                  <td>{{ $consultation->consultation_date }}</td>
                  <td>{{ $consultation->nature_of_visit }}</td>
                  <td>{{ $consultation->diagnosis }}</td>
                  <td>{{ $consultation->condition }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-muted">No consultation records found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>

          <div class="mt-4">
            <h6 class="fw-bold">Schedule of Next Visit:</h6>
            <p>{{ $employee->next_visit ?? 'mm/dd/yyyy' }}</p>
          </div>

          <hr class="my-4">

          <!-- Action Buttons -->
          <div class="d-flex gap-2">
            <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('employee.destroy', $employee->id) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('Are you sure you want to delete this employee?')">
                Delete
              </button>
            </form>

            <a href="{{ route('employee.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
          </div>

        </div>
      </div>
    </div>

    <!-- Footer -->
    @include('components.admin.footer')

  </div>
</div>
@endsection