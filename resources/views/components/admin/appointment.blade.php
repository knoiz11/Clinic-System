@extends('layout.admin')

@section('appointment')
<div class="container-fluid">
    <div class="card shadow-sm rounded-4 p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    Clinic Appointments
                </h4>
                <p class="text-muted mb-0">Manage and view employee appointment schedules</p>
            </div>
            <button class="btn btn-success text-white fw-bold px-4" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                <i class="bi bi-plus-circle me-2"></i>New Appointment
            </button>
        </div>

        <!-- Filter Form -->
        <form action="{{ route('appointment.create') }}" method="GET" class="mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <input type="date" name="date" class="form-control" value="{{ $filters['date'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <input type="text" name="employee_name" class="form-control" placeholder="Search by Employee Name" value="{{ $filters['employee_name'] ?? '' }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                    <a href="{{ route('appointment.create') }}" class="btn btn-secondary w-100">Clear</a>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-3 mt-3">
                <input type="hidden" name="status" id="status_filter" value="{{ $filters['status'] ?? 'all' }}">
                <button type="button" class="btn btn-outline-success filter-btn @if(($filters['status'] ?? 'all') == 'all') active @endif" data-status="all">All</button>
                <button type="button" class="btn btn-outline-warning filter-btn @if(($filters['status'] ?? '') == 'scheduled') active @endif" data-status="scheduled">Scheduled</button>
                <button type="button" class="btn btn-outline-primary filter-btn @if(($filters['status'] ?? '') == 'completed') active @endif" data-status="completed">Completed</button>
                <button type="button" class="btn btn-outline-danger filter-btn @if(($filters['status'] ?? '') == 'cancelled') active @endif" data-status="cancelled">Cancelled</button>
            </div>
        </form>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Appointment List -->
        @if($appointments->isEmpty())
            <p class="text-muted text-center my-4">No appointments scheduled yet.</p>
        @else
            <div class="row gy-3" id="appointmentList">
                @foreach($appointments as $appointment)
                    <div class="col-md-6 col-lg-4 appointment-card" data-status="{{ strtolower($appointment->status ?? 'scheduled') }}">
                        <div class="card border-1 shadow-sm rounded-4 p-3" style="background-color: var(--ccp-white);" >
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span style="border-radius: 22px;" class="badge px-3 py-2
                                    @if(($appointment->status ?? 'Scheduled') == 'Completed') bg-primary
                                    @elseif(($appointment->status ?? 'Scheduled') == 'Cancelled') bg-danger 
                                    @elseif(($appointment->status ?? 'Scheduled') == 'Scheduled') bg-warning text-dark
                                    @else bg-success @endif">
                                    {{ ucfirst($appointment->status ?? 'Scheduled') }}
                                </span>

                                @if(($appointment->status ?? 'Scheduled') === 'Scheduled')
    <form action="{{ route('appointment.destroy', $appointment->id) }}"
          method="POST"
          onsubmit="return confirm('Are you sure you want to delete this appointment?');"
          class="ms-2">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="btn fw-bold py-2 px-3 d-flex align-items-center justify-content-center"
            style="background: url('{{ asset('images/gallery/delete.png') }}') center/contain no-repeat; 
                   height: 30px; 
                   width: 60px;" 
            title="Delete Appointment">
        </button>
    </form>
@endif


                                <form action="{{ route('appointment.updateStatus', $appointment->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="Scheduled" {{ $appointment->status == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        <option value="Completed" {{ $appointment->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="Cancelled" {{ $appointment->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </div>

                            <div class="d-flex align-items-center mb-3">
                                <h5 class="mb-0 fw-bold">
                                    {{ $appointment->employee->name ?? $appointment->employee_name ?? 'Unassigned' }}

                                </h5>
                            </div>

                            <div class="text-muted small mb-2">
                                <i class="bi bi-calendar-event me-2"></i>
                                <span>{{ \Carbon\Carbon::parse($appointment->date)->format('F d, Y') }}</span>
                            </div>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-clock me-2"></i>
                                <span>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</span>
                            </div>

                            @if(!empty($appointment->reason))
                                <div class="mt-2 p-2 rounded comment">
                                    <small class="fw-bold d-block mb-1">Reason for Visit:</small>
                                    <p class="mb-0">{{ $appointment->reason }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Add Appointment Modal -->
    <div class="modal fade appointment-modal" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-lg">
                <div class="modal-header bg-success text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="addAppointmentModalLabel">
                        <i class="bi bi-plus-circle me-2"></i> New Appointment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('appointment.store') }}" method="POST" id="addAppointmentForm">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="date" class="form-label fw-bold">Date</label>
                            <input type="date" name="date" id="date" class="form-control" min="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="time" class="form-label fw-bold">Time</label>
                            <input type="time" name="time" id="time" class="form-control" required>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="employee_search" class="form-label fw-bold">Employee</label>

                            <input type="text" id="employee_search" class="form-control" placeholder="Search employee..." required autocomplete="off" aria-autocomplete="list" aria-controls="employee_results">
                            <input type="hidden" name="employee_id" id="employee_id">
                            <div id="employee_results" class="border rounded mt-1 bg-white shadow-sm" 
                                style="display:none; max-height:150px; overflow-y:auto; position:absolute; width:100%; z-index:20;">
                            </div>

                            <!-- Employee Search Script (AJAX-only) -->
                            <script src="{{ asset('js/appointmentemployeename.js') }}"></script>

                        </div>

                        <div class="mb-3">
                            <label for="reason" class="form-label fw-bold">Reason for Visit</label>
                            <textarea name="reason" id="reason" class="form-control" rows="3" placeholder="Enter the reason for visit..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                            Save Appointment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  JS SECTION — FIXED AND CLEANED -->

<!-- JS: Filter Function -->
<script>
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('status_filter').value = this.dataset.status;
        // Find the closest form element and submit it
        this.closest('form').submit();
    });
});
</script>




@endsection
