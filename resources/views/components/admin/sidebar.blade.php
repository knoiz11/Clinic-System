<!-- =================== SIDEBAR =================== -->
<aside class="left-sidebar">
  <style>
    .left-sidebar .sidebar-nav #sidebarnav .sidebar-item .sidebar-link,
    .left-sidebar .sidebar-nav #sidebarnav .sidebar-link {
      transition: background-color .12s ease, color .12s ease;
    }
    .left-sidebar .sidebar-nav #sidebarnav .sidebar-link:hover,
    .left-sidebar .sidebar-nav #sidebarnav .sidebar-item:hover > .sidebar-link {
      background-color: #f2f4f6 !important;
      color: var(--ccp-primary-color-maroon) !important;
      border-radius: 30px !important;
    }
    .left-sidebar .sidebar-nav #sidebarnav .sidebar-link.active,
    .left-sidebar .sidebar-nav #sidebarnav .sidebar-item .sidebar-link.active,
    .left-sidebar .sidebar-nav #sidebarnav .sidebar-item.show > .sidebar-link,
    .left-sidebar .sidebar-nav #sidebarnav .sidebar-item > .sidebar-link[aria-expanded="true"] {
      background-color: var(--ccp-primary-color-maroon) !important;
      color: var(--ccp-light) !important;
      border-radius: 30px !important;
    }
    .left-sidebar .sidebar-nav #sidebarnav .sidebar-link .iconify-icon,
    .left-sidebar .sidebar-nav #sidebarnav .sidebar-link i,
    .left-sidebar .sidebar-nav #sidebarnav .sidebar-link .ti {
      color: inherit !important;
      opacity: 1 !important;
    }
  </style>
  <div>
    <!-- Logo Section -->
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="{{ route('admin.dashboard') }}" class="text-nowrap logo-img">
        <img src="{{ asset('/../admin/images/logos/ccp.png') }}" alt="Logo" class="img-fluid" width="40"/>
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
          <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
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
          <a class="sidebar-link" href="{{ route('employee.index') }}">
            <span><iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6"></iconify-icon></span>
            <span class="hide-menu">Employee</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('appointment.create') }}">
            <span><iconify-icon icon="solar:bookmark-square-minimalistic-bold-duotone" class="fs-6"></iconify-icon></span>
            <span class="hide-menu">Appointments</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('admin.inventory') }}">
            <span><iconify-icon icon="solar:box-bold-duotone" class="fs-6"></iconify-icon></span>
            <span class="hide-menu">Inventory</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('admin.reports') }}">
            <span><iconify-icon icon="solar:file-text-bold-duotone" class="fs-6"></iconify-icon></span>
            <span class="hide-menu">Reports</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
