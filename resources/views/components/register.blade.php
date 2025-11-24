<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
  <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
      <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-4">
          <div class="card mb-0" style="background-color: rgba(255,255,255,0.95);">
            <div class="card-body">
              <div class="text-center mb-4">
                <a href="{{ url('/') }}" class="logo-img d-block mb-3">
                  <img src="{{ asset('admin/images/logos/ccp.svg') }}" alt="CCP Logo" width="100">
                </a>
                <h2 style="color: var(--ccp-primary-color-maroon)">Clinic System</h2>
              </div>

              <form action="{{ route('register') }}" method="POST" onsubmit="return validateForm()">
                @csrf

                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Email Address</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                </div>

                <div class="mb-3">
                  <label for="password_confirmation" class="form-label">Confirm Password</label>
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3 fs-6 mb-4">Sign Up</button>

                <div class="d-flex align-items-center justify-content-center">
                  <p class="mb-0 text-muted" style="font-size: 0.95rem; margin-right: .5rem;">Already have an Account?</p>
                  <a class="text-primary fw-bold" style="text-decoration: underline" href="{{ route('login') }}">Sign In</a>
                </div>
              </form>

              <script>
                function validateForm() {
                  const password = document.getElementById("password").value;
                  const confirm = document.getElementById("password_confirmation").value;
                  if (password.length < 8) {
                    alert("Password must be at least 8 characters long.");
                    return false;
                  }
                  if (password !== confirm) {
                    alert("Passwords do not match.");
                    return false;
                  }
                  return true;
                }
              </script>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <link rel="stylesheet" href="{{ asset('css/ccp-gold-theme.css') }}">
</div>
