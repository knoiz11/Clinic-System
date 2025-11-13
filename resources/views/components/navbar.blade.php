@php
    use Illuminate\Support\Facades\Auth;
    Auth::shouldUse('web');
@endphp


<nav class="navbar navbar-expand-lg fixed-top shadow-lg">
    <div class="container">
        <!-- Logo for small screens -->
        <a class="navbar-brand mx-auto d-lg-none" href="#">
            <img src="{{ asset('admin/images/logos/ccp.svg') }}" style="max-width: 120px;" alt="CCP logo">
        </a>

        <!-- Navbar toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <a class="navbar-brand d-none d-lg-block" href="#">
                    <img src="{{ asset('admin/images/logos/ccp.svg') }}" style="max-width: 120px;" alt="CCP logo">
                </a>
                <li class="nav-item active">
                    <a class="nav-link" href="#hero">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
            </ul>

            <!-- Account / User Info -->
            <ul class="navbar-nav ms-auto">
                @if (Auth::check())
                    <li class="nav-item d-flex align-items-center me-3 text-white">
                        {{ Auth::user()->username }}
                        <small class="text-light ms-1">
                            ({{ ucfirst(Auth::user()->role) }})
                        </small>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                class="btn btn-outline-light"
                                style="background-color: maroon; border-color: maroon;">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" 
                           class="btn btn-outline-light" 
                           style="background-color: maroon; border-color: maroon;">
                            <i class="bi bi-person-circle"></i> Account
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
