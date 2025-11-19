@extends('layout.admin')

@section('view')

<div class="container-fluid py-4">
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
                <p><span class="text-muted">Employment Status:</span> <strong>{{ $employee->employment_status ?? '-' }}</strong></p>
                <p><span class="text-muted">Designation:</span> <strong>{{ $employee->designation ?? '-' }}</strong></p>
                <p><span class="text-muted">Division:</span> <strong>{{ $employee->division ?? '-' }}</strong></p>
                <p><span class="text-muted">Department:</span> <strong>{{ $employee->department ?? '-' }}</strong></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <hr class="my-4">

      <div class="row">

        <!-- First Column -->
        <div class="col-md-8">
          <div class="mb-4" style="border: 1px solid var(--ccp-primary-color-maroon); border-radius: 5px;">
            <h6 class="fw-bold mb-2 text-center" style="background-color: var(--ccp-primary-color-maroon); padding: 10px;color: var(--ccp-light);">CONSULTATION RECORD</h6>

            <div style="padding: 1rem; overflow-y: auto; overflow-x: hidden; max-height: 300px;">
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
            </div>
          </div>
        </div>

        <!-- Second Column -->
        <div class="col-md-4">
          <div class="mb-4" style="border: 1px solid var(--ccp-primary-color-maroon); border-radius: 5px;">
            <h6 class="fw-bold text-center" style="background-color: var(--ccp-primary-color-maroon); padding: 10px; color: var(--ccp-light);">SCHEDULE OF NEXT VISIT</h6>
            <p class="text-center" style="padding: 10px;">{{ $employee->next_visit ?? 'mm/dd/yyyy 00:00:00' }}</p>

            <div class="d-flex justify-content-center">
              <button class="btn btn-success btn-sm mb-3 mx-3" style="padding: 8px">Completed</button>
              <button class="btn btn-danger btn-sm mb-3 mx-3" style="padding: 8px">No Show</button>
            </div>
          </div>

          <div class="mt-4" style="border: 1px solid var(--ccp-primary-color-maroon); border-radius: 5px;">
            <h6 class="fw-bold text-center" style="background-color: var(--ccp-primary-color-maroon); padding: 10px; color: var(--ccp-light);">Notes</h6>
            <div class="p-3">
              <textarea class="form-control" rows="3">{{ $employee->notes ?? '-' }}</textarea>
              <button class="btn btn-primary btn-sm mt-2">Save Note</button>
            </div>
          </div>
        </div>

      </div>

      <!-- SERVICES -->
      <div class="mb-4" id="services-section">
        <div class="mt-4" style="border: 1px solid var(--ccp-primary-color-maroon); border-radius: 5px;">
          <h6 class="fw-bold text-center" style="background-color: var(--ccp-primary-color-maroon); padding: 10px; color: var(--ccp-light);">SERVICES</h6>

          <div class="d-flex flex-wrap gap-3 justify-content-center p-4">
            <button id="vital-signs" class="service-btn btn-sm">Vital Signs</button>
            <button id="physical-exam" class="service-btn btn-sm">Physical Exam</button>
            <button id="laboratory" class="service-btn btn-sm">Laboratory</button>
            <button id="doctors-order" class="service-btn btn-sm">Doctor's Order</button>
          </div>

          <div id="service-form-container" class="mt-3 p-4"></div>
          <script src="{{ asset('admin/js/EmployeeServices.js') }}"></script>
        </div>
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

@endsection
