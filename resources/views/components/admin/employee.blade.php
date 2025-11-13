<!--  Body Wrapper -->
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
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-3">
            <h3>Employees</h3>
            <a href="{{ route('employee.create') }}" class="btn btn-primary">Add Employee</a>
        </div>

        <table class="table table-bordered">
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
                    <td>
                        <i class="bi bi-caret-down-fill"></i>
                    </td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->designation ?? '-' }}</td>
                    <td>{{ $employee->department ?? '-' }}</td>
                    <td>{{ $employee->status ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="hiddenRow p-0">
                        <div class="collapse" id="employee-{{ $employee->id }}">
                            <div class="p-3 bg-light border">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('employee.show', $employee->id) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('consultation.show', $employee->id) }}" class="btn btn-secondary btn-sm">Consultation</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- End Page Content -->

    <!-- Footer -->
    @include('components.admin.footer')
  </div>
  <!-- End Main wrapper -->

</div>
<!-- End Body Wrapper -->
