@extends('layout.admin')

@section('employee')
<div class="container mx-auto p-6">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-2xl font-bold">Edit Employee</h2>
        <a href="{{ route('employee.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="bg-white shadow p-4 rounded">
        <form action="{{ route('employee.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="fw-bold">Employee ID:</label>
                        <input type="text" name="employee_id" value="{{ old('employee_id', $employee->employee_id) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Last Name:</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $employee->last_name) }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">First Name:</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $employee->first_name) }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Middle Name:</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name', $employee->middle_name) }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="fw-bold">Designation:</label>
                        <input type="text" name="designation" value="{{ old('designation', $employee->designation) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Division:</label>
                        <input type="text" name="division" value="{{ old('division', $employee->division) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Department:</label>
                        <input type="text" name="department" value="{{ old('department', $employee->department) }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="fw-bold">Status:</label>
                        <select name="status" class="form-select">
                            <option value="Active" {{ old('status', $employee->status) == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $employee->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="On Leave" {{ old('status', $employee->status) == 'On Leave' ? 'selected' : '' }}>On Leave</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Profile Photo:</label>
                        @if($employee->photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $employee->photo) }}" alt="Current Photo" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                            </div>
                        @endif
                        <input type="file" name="photo" class="form-control" accept="image/*" id="photoInputEdit">
                        <small class="text-muted">Leave empty to keep current photo. Max: 2MB</small>
                    </div>
                    <div class="mb-3">
                        <img id="photoPreviewEdit" src="" alt="Preview" class="img-thumbnail" style="display: none; max-width: 200px; max-height: 200px;">
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Contact:</label>
                        <input type="text" name="contact" value="{{ old('contact', $employee->contact) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Alternate Contact:</label>
                        <input type="text" name="contact_no" value="{{ old('contact_no', $employee->contact_no) }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Email:</label>
                <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="form-control">
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="fw-bold">PHILHEALTH No:</label>
                        <input type="text" name="philhealth_no" value="{{ old('philhealth_no', $employee->philhealth_no) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Birthdate:</label>
                        <input type="date" name="birthdate" value="{{ old('birthdate', optional($employee->birthdate)->format('Y-m-d')) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Age:</label>
                        <input type="text" class="form-control" value="{{ $employee->age ?? '-' }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="fw-bold">Sex:</label>
                        <select name="sex" class="form-select">
                            <option value="">Select</option>
                            <option value="Male" {{ old('sex', $employee->sex) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('sex', $employee->sex) == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Religion:</label>
                        <input type="text" name="religion" value="{{ old('religion', $employee->religion) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Blood Type:</label>
                        <input type="text" name="blood_type" value="{{ old('blood_type', $employee->blood_type) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Civil Status:</label>
                        <select name="civil_status" class="form-select">
                            <option value="">Select</option>
                            <option value="Single" {{ old('civil_status', $employee->civil_status) == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('civil_status', $employee->civil_status) == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Divorced" {{ old('civil_status', $employee->civil_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="Widowed" {{ old('civil_status', $employee->civil_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="fw-bold">Notes:</label>
                        <textarea name="notes" class="form-control">{{ old('notes', $employee->notes) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                <a href="{{ route('employee.show', $employee->id) }}" class="btn btn-secondary btn-sm">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('photoInputEdit').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('photoPreviewEdit');

    if (!file) {
        preview.style.display = 'none';
        return;
    }

    const reader = new FileReader();
    reader.onload = () => {
        preview.src = reader.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
});
</script>
@endpush
@endsection