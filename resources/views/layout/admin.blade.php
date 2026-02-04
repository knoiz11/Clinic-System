<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clinic Information System - Admin Panel</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('admin/images/logos/ccp.png') }}" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('admin/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/employee.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/dashboard-theme.css') }}" />
    <link href='https://clinicaltables.nlm.nih.gov/autocomplete-lhc-versions/19.2.4/autocomplete-lhc.min.css' rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('admin/css/theme.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.7.0/tabler-icons.min.css">

    <style>
@import url('https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap');
</style>
</head>

<body>
    <main>
        <div class="page-wrapper" id="main-wrapper"
             data-layout="vertical"
             data-navbarbg="skin6"
             data-sidebartype="full"
             data-sidebar-position="fixed"
             data-header-position="fixed">

            <!-- Sidebar -->
            @include('components.admin.sidebar')

            <div class="body-wrapper" id="dashboard">
                <!-- Header -->
                @include('components.admin.header')

                <!-- Main Content -->
                <div class="container-fluid mt-4">
                    @yield('dashboard')
                    @yield('employee')
                    @yield('create')
                    @yield('appointment')
                    @yield('reports')
                    @yield('view')
                    @yield('consultation')
                    @yield('inventory')
                </div>

                <!-- Footer -->
                @include('components.admin.footer')
            </div>
        </div>
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
