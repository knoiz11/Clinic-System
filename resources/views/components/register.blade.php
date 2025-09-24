  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0"> 
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="../assets/images/logos/logo-light.svg" alt="">
                </a>
                <p class="text-center">Welcome to Clinic</p>


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

  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4">Sign Up</button>
  <div class="d-flex align-items-center justify-content-center">
    <p class="fs-4 mb-0 fw-bold" style="color: #a89f92">Already have an Account?</p>
    <a class="text-primary fw-bold ms-2"style="text-decoration: underline" href="{{ route('login') }}">Sign In</a>
  </div>
</form>

<script>
function validateForm() {
    let password = document.getElementById("password").value;
    let confirm = document.getElementById("password_confirmation").value;

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
<link rel="stylesheet" href="{{ asset('css/ccp-gold-theme.css') }}">
