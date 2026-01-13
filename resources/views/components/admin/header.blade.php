<header class="app-header">
  <nav class="navbar navbar-expand-lg navbar-light px-3">

    <!-- LEFT SIDE -->
    <ul class="navbar-nav">
      <!-- Mobile Sidebar Toggle -->
      <li class="nav-item d-block d-xl-none">
        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
          <i class="ti ti-menu-2"></i>
        </a>
      </li>
    </ul>

    <!-- RIGHT SIDE (PUSHED FULL RIGHT) -->
    <ul class="navbar-nav ms-auto align-items-center">
      @auth
      <li class="nav-item dropdown">
        <a class="nav-link nav-icon-hover" id="drop2" data-bs-toggle="dropdown">
          <img
            src="{{ Auth::user()->photo
                ? asset('storage/' . Auth::user()->photo)
                : asset('admin/images/profile/user.jpg') }}"
            alt="User"
            width="35"
            height="35"
            class="rounded-circle">
        </a>

        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" href="#">
          <div class="message-body">
            <a class="d-flex align-items-center gap-2 dropdown-item">
              <i class="ti ti-user fs-6 rounded-circle p-2" style="background-color: var(--ccp-g3);"></i>
              <p class="mb-0 fs-3">{{ Auth::user()->username }}</p>
            </a>

            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="dropdown-item">Logout</button>
            </form>
          </div>
        </div>
      </li>
      @else
      <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">Login</a>
      </li>
      @endauth
    </ul>

  </nav>
</header>
