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
            <h2 class="text-2xl font-bold">Employee Details</h2>
            <a href="{{ route('employee.index') }}" class="btn btn-secondary">Back to List</a>
        </div>

        <div class="bg-white shadow p-4 rounded">
            <div class="mb-3">
                <h5 class="fw-bold">Name:</h5>
                <p>{{ $employee->name }}</p>
            </div>

            <div class="mb-3">
                <h5 class="fw-bold">Designation:</h5>
                <p>{{ $employee->designation ?? '-' }}</p>
            </div>

            <div class="mb-3">
                <h5 class="fw-bold">Department:</h5>
                <p>{{ $employee->department ?? '-' }}</p>
            </div>

            <div class="mb-3">
                <h5 class="fw-bold">Status:</h5>
                <p>{{ $employee->status ?? '-' }}</p>
            </div>

            <div class="mt-4 d-flex gap-2">
                <!-- Edit Button -->
                <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <!-- Delete Button -->
                <form action="{{ route('employee.destroy', $employee->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete this employee?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- End Page Content -->

    <!-- Footer -->
    @include('components.admin.footer')

  </div>
  <!-- End Main wrapper -->
</div>
<!-- End Body Wrapper -->
@extends('layout.admin')
