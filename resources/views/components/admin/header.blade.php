<!-- =================== HEADER =================== -->
<header class="app-header">
  <nav class="navbar navbar-expand-lg navbar-light">
    <ul class="navbar-nav">
      <!-- Mobile Sidebar Toggle -->
      <li class="nav-item d-block d-xl-none">
        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
          <i class="ti ti-menu-2"></i>
        </a>
      </li>
      <!-- Notifications -->
      <li class="nav-item">
        <a class="nav-link nav-icon-hover" href="javascript:void(0)">
          <i class="ti ti-bell-ringing"></i>
          <div class="notification bg-primary rounded-circle"></div>
        </a>
      </li>
    </ul>

    <!-- Right User Menu -->
    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
      <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
        <li class="nav-item dropdown">
          <!-- User Avatar -->
          <a class="nav-link nav-icon-hover" id="drop2" data-bs-toggle="dropdown">
            <img src="../assets/images/profile/user-1.jpg" alt="User" width="35" height="35" class="rounded-circle">
          </a>
          <!-- Dropdown -->
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up">
            <div class="message-body">
              <a class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-user fs-6"></i>
                <p class="mb-0 fs-3">{{ Auth::user()->username }}</p>
              </a>
              <a class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-mail fs-6"></i>
                <p class="mb-0 fs-3">My Account</p>
              </a>
              <a class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-list-check fs-6"></i>
                <p class="mb-0 fs-3">My Task</p>
              </a>
              <!-- Logout -->
              <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="dropdown-item">Logout</button>
              </form>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</header>
