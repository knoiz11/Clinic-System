<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SeoDash Free Bootstrap Admin Template by Adminmart</title>


  <link rel="shortcut icon" type="image/png" href="admin/images/logos/seodashlogo.png" />
  <link rel="stylesheet" href="admin/css/styles.min.css" />
  <link rel="stylesheet" href="admin/css/employee.css" />


</head>

<body>
<main>
    @yield('login')
    @yield('register')
    @yield('dashboard')
    @yield('employee')
    @yield('appointment')
    @yield('reports')
    @yield('view')
    @yield('consultation')
    </main>

    <!-- JAVASCRIPT -->
  <script src="admin/libs/jquery/dist/jquery.min.js"></script>
  <script src="admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="admin/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="admin/libs/simplebar/dist/simplebar.js"></script>
  <script src="admin/js/sidebarmenu.js"></script>
  <script src="admin/js/app.min.js"></script>
  <script src="admin/js/dashboard.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>"
  <script src="admin/js/searchemployee.js"></script>
  <script src="admin/js/viewemployee.js"></script>
</body>

</html>
