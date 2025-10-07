<!-- =================== SIDEBAR =================== -->
<aside class="left-sidebar">
  <div>
    <!-- Logo Section -->
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="{{ url('/dashboard') }}" class="text-nowrap logo-img">
        <img src="../admin/images/logos/ccp.png" alt="Logo" class="img-fluid" width="40"/>
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div> 
    </div>

    <!-- Sidebar Navigation -->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        <!-- Home Section -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
          <span class="hide-menu">Home</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ url('/dashboard') }}">
            <span><iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon></span>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>

        <!-- Modules Section -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
          <span class="hide-menu">MODULES</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ url('/employee') }}">
            <span><iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6"></iconify-icon></span>
            <span class="hide-menu">Employee</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ url('/appointment') }}">
            <span><iconify-icon icon="solar:bookmark-square-minimalistic-bold-duotone" class="fs-6"></iconify-icon></span>
            <span class="hide-menu">Appointments</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ url('/reports') }}">
            <span><iconify-icon icon="solar:file-text-bold-duotone" class="fs-6"></iconify-icon></span>
            <span class="hide-menu">Reports</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
