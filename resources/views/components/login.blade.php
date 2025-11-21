<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0" style="background-color: #EDEDED">
              <div class="card-body">

               <!-- Logo + Clinic System Title -->
              <div class="text-center mb-4">
                <a href="{{ url('/') }}" class="logo-img d-block mb-3">
               <img src="{{ asset('admin/images/logos/ccp.svg') }}" alt="CCP Logo" width="100">
                </a>
                <h2 style="color:#8d4925;">Clinic System</h2>
              </div>


                {{-- Success message --}}
                @if(session('success'))
                  <div class="alert alert-success text-center">
                      {{ session('success') }}
                  </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="mb-3">
                      <label for="username" class="form-label">Username</label>
                      <input type="text" class="form-control" id="username" name="username" required>
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                      <label class="form-check-label text-dark" for="flexCheckChecked">
                        Remember passowrd 
                      </label>

                    </div>
                    <a class="text-primary fw-bold" href="./index.html">Forgot Password?</a>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4">Sign In</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-5 mb-0 fw-bold" style="color: #a89f92">New to Site?</p>
                    <a class="text-primary fw-bold ms-2" style="text-decoration: underline" href="{{ route('register') }}">Create an account</a>
                  </div>
                </form>
              </div>
<link rel="stylesheet" href="{{ asset('css/ccp-gold-theme.css') }}">
