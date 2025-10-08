@extends('layout.admin')

<!-- Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" 
     data-layout="vertical" 
     data-navbarbg="skin6" 
     data-sidebartype="full"
     data-sidebar-position="fixed" 
     data-header-position="fixed">

  <!-- Sidebar -->
  @include('components.admin.sidebar')

  <!-- Main wrapper -->
  <div class="body-wrapper">
    
    <!-- Header -->
    @include('components.admin.header')

    <!-- Page Content -->
    <div class="container mx-auto p-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-2xl font-bold">Edit Employee</h2>
            <a href="{{ route('employee.index') }}" class="btn btn-secondary">Back to List</a>
        </div>

        <div class="bg-white shadow p-4 rounded">
            <form action="{{ route('employee.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="fw-bold">Name:</label>
                    <input type="text" name="name" value="{{ old('name', $employee->name) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Designation:</label>
                    <input type="text" name="designation" value="{{ old('designation', $employee->designation) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Department:</label>
                    <input type="text" name="department" value="{{ old('department', $employee->department) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Status:</label>
                    <select name="status" class="form-select">
                        <option value="Active" {{ old('status', $employee->status) == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status', $employee->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Contact:</label>
                    <input type="text" name="contact" value="{{ old('contact', $employee->contact) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Email:</label>
                    <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="form-control">
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                    <a href="{{ route('employee.show', $employee->id) }}" class="btn btn-secondary btn-sm">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <!-- End Page Content -->

    <!-- Footer -->
    @include('components.admin.footer')

  </div>
  <!-- End Main wrapper -->
</div>
<!-- End Body Wrapper -->
