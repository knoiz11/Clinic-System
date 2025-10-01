@extends('layout.admin')

@section('content')
<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" 
  data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

  @include('components.admin.sidebar')

  <!--  Main wrapper -->
  <div class="body-wrapper">
    <!--  Header -->
    @include('components.admin.header')

    <div class="container-fluid">
      <div class="card shadow-sm rounded-3">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title fw-bold mb-0">Employee Details</h5>
            <a href="{{ route('employees.index') }}" class="btn btn-sm btn-secondary">← Back</a>

          </div>

          <div class="row g-4">
            <!-- Profile Info -->
            <div class="col-md-4">
              <div class="text-center">
                <img src="https://via.placeholder.com/150" class="rounded-circle mb-3" alt="Employee Photo">
                <h5 class="fw-bold mb-0">John Doe</h5>
                <p class="text-muted">Software Engineer</p>
                <span class="badge bg-success">Active</span>
              </div>
            </div>

            <!-- Details -->
            <div class="col-md-8">
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <th scope="row" style="width: 30%">Name:</th>
                    <td>John Doe</td>
                  </tr>
                  <tr>
                    <th scope="row">Department:</th>
                    <td>IT</td>
                  </tr>
                  <tr>
                    <th scope="row">Age:</th>
                    <td>28</td>
                  </tr>
                  <tr>
                    <th scope="row">Gender:</th>
                    <td>Male</td>
                  </tr>
                  <tr>
                    <th scope="row">Medical History:</th>
                    <td>None</td>
                  </tr>
                  <tr>
                    <th scope="row">Contact:</th>
                    <td>09171234567</td>
                  </tr>
                  <tr>
                    <th scope="row">Email:</th>
                    <td>john@example.com</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Footer -->
    @include('components.admin.footer')
  </div>
</div>
@endsection
