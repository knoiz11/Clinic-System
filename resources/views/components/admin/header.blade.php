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
      <li class="nav-item dropdown">
        <a class="nav-link nav-icon-hover" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" href="#">
          <i class="ti ti-bell-ringing"></i>
          @php
            $unreadCount = \App\Models\Notification::where('user_id', Auth::id())
                            ->where('is_read', false)
                            ->count();
          @endphp
          @if($unreadCount > 0)
            <div class="notification bg-primary rounded-circle"></div>
          @endif
        </a>

        <!-- Notification Dropdown -->
        <div class="dropdown-menu dropdown-menu-animate-up notifications-dropdown" aria-labelledby="notificationDropdown" style="width: 300px;">
          <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Notifications</h6>
            <a href="{{ route('notifications.markAllRead') }}" class="small text-primary text-decoration-none">Mark all as read</a>
          </div>

          <div class="list-group" style="max-height: 300px; overflow-y: auto;">
            @php
              $notifications = \App\Models\Notification::where('user_id', Auth::id())
                              ->orderBy('created_at', 'desc')
                              ->take(10)
                              ->get();
            @endphp

            @forelse ($notifications as $notification)
              <a href="javascript:void(0)" 
                 class="list-group-item list-group-item-action {{ $notification->is_read ? '' : 'bg-light' }}">
                <div class="d-flex justify-content-between align-items-center">
                  <p class="mb-1">{{ $notification->message }}</p>
                  <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                </div>
              </a>
            @empty
              <p class="text-center m-2 text-muted">No notifications</p>
            @endforelse
          </div>
        </div>
      </li>
    </ul>

    <!-- Right User Menu -->
    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
      <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
        <li class="nav-item dropdown">
          <!-- User Avatar -->
          <a class="nav-link nav-icon-hover" id="drop2" data-bs-toggle="dropdown">
            <img src="{{ asset('admin/images/profile/user.jpg') }}" alt="User" width="35" height="35" class="rounded-circle">
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
<!-- =================== END HEADER =================== -->