<!doctype html>
<html lang="en">

<head>
    <!-- Meta & Title -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, initial-scale=1">
    <title>Clinic Management System - Admin Panel</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('admin/images/logos/seodashlogo.png') }}" />

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/employee.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/dashboard-theme.css') }}" />

    <!-- Fonts or Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- bootstrap -->
<link href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<!-- your theme override (load after bootstrap) -->
<link href="{{ asset('admin/css/theme.css') }}" rel="stylesheet">

</head>


<body>
  <main>
    {{-- Laravel Section Yields for Dynamic Pages --}}
    @yield('login')
    @yield('register')
    @yield('dashboard')
    @yield('employee')
    @yield('create')
    @yield('appointment')
    @yield('reports')
    @yield('view')
    @yield('consultation')
  </main>
  

  <!-- JS Libraries -->
  <script src="{{ asset('admin/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('admin/libs/simplebar/dist/simplebar.js') }}"></script>

  <!-- Custom Scripts -->
  <script src="{{ asset('admin/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('admin/js/app.min.js') }}"></script>
  <script src="{{ asset('admin/js/dashboard.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="{{ asset('admin/js/searchemployee.js') }}"></script>
  <script src="{{ asset('admin/js/viewemployee.js') }}"></script>
</body>

</html>
