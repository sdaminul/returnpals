<!doctype html>
<html lang="en">
    <head>
        <!-- Title Meta -->
        <meta charset="utf-8" />
        <title>@yield('title', 'Dashboard') | ReturnPal</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('dashboard/assets/images/favicon.ico') }}" />
        <!-- Theme Config js -->
        <script src="{{ asset('dashboard/assets/js/config.min.js') }}"></script>
        <!-- Vendor css -->
        <link href="{{ asset('dashboard/assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons css -->
        <link href="{{ asset('dashboard/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App css -->
        <link href="{{ asset('dashboard/assets/css/style.css') }}" rel="stylesheet" type="text/css" />
        @yield('styles')
    </head>

    <body>
        <!-- START Wrapper -->
        <div class="wrapper">
            <!-- ========== Topbar Start ========== -->
            <header class="">
                <div class="topbar">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <div class="d-flex align-items-center gap-2">
                                <!-- Menu Toggle Button -->
                                <div class="topbar-item">
                                    <button type="button" class="button-toggle-menu topbar-button">
                                        <i class="ri-menu-2-line fs-24"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-1">
                                <!-- Category -->
                                <div class="dropdown topbar-item d-none d-lg-flex">
                                    <button type="button" class="topbar-button" data-toggle="fullscreen">
                                        <i class="ri-fullscreen-line fs-24 fullscreen"></i>
                                        <i class="ri-fullscreen-exit-line fs-24 quit-fullscreen"></i>
                                    </button>
                                </div>
                                <!-- Theme Color (Light/Dark) -->
                                <div class="topbar-item">
                                    <button type="button" class="topbar-button" id="light-dark-mode">
                                        <i class="ri-moon-line fs-24 light-mode"></i>
                                        <i class="ri-sun-line fs-24 dark-mode"></i>
                                    </button>
                                </div>
                                <!-- User -->
                                <div class="dropdown topbar-item">
                                    <a
                                        type="button"
                                        class="topbar-button"
                                        id="page-header-user-dropdown"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        <span class="d-flex align-items-center">
                                            <img
                                                class="rounded-circle"
                                                width="32"
                                                src="{{ asset('dashboard/assets/images/users/dummy-avatar.jpg') }}"
                                                alt="avatar"
                                            />
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <h6 class="dropdown-header">Welcome {{ \Illuminate\Support\Facades\Auth::user()->name ?? "User" }}!</h6>
                                        <a class="dropdown-item" href="{{ route('dashboard.settings') }}">
                                            <i class="ri-settings-3-line align-middle me-1 fs-18"></i>
                                            <span class="align-middle">Settings</span>
                                        </a>
                                        <div class="dropdown-divider my-1"></div>
                                        <form method="POST" action="{{ route('logout') }}" class="px-3 py-1">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger px-0 border-0 bg-transparent w-100 text-start">
                                                <i class="ri-logout-circle-line align-middle me-1 fs-18"></i>
                                                <span class="align-middle">Logout</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- ========== App Menu Start ========== -->
            <div class="main-nav">
                <!-- Sidebar Logo -->
                <div class="logo-box">
                    <a href="{{ route('dashboard.overview') }}" class="logo-dark">
                        <img src="{{ asset('dashboard/assets/images/logo-sm-dark.png') }}" class="logo-sm" alt="logo sm" />
                        <img src="{{ asset('dashboard/assets/images/logo-dark.png') }}" class="logo-lg" alt="logo dark" />
                    </a>

                    <a href="{{ route('dashboard.overview') }}" class="logo-light">
                        <img src="{{ asset('dashboard/assets/images/logo-sm-light.png') }}" class="logo-sm" alt="logo sm" />
                        <img src="{{ asset('dashboard/assets/images/logo-light.png') }}" class="logo-lg" alt="logo light" />
                    </a>
                </div>

                <!-- Menu Toggle Button (sm-hover) -->
                <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
                    <i class="ri-menu-2-line fs-24 button-sm-hover-icon"></i>
                </button>

                <div class="scrollbar" data-simplebar>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title">Menu</li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard.overview') ? 'active' : '' }}" href="{{ route('dashboard.overview') }}">
                                <span class="nav-icon">
                                    <i class="ri-box-3-line"></i>
                                </span>
                                <span class="nav-text">Packages Sent</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard.received') ? 'active' : '' }}" href="{{ route('dashboard.received') }}">
                                <span class="nav-icon">
                                    <i class="ri-import-line"></i>
                                </span>
                                <span class="nav-text">Received</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard.sold-items') ? 'active' : '' }}" href="{{ route('dashboard.sold-items') }}">
                                <span class="nav-icon">
                                    <i class="ri-list-view"></i>
                                </span>
                                <span class="nav-text">Sold Items</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard.item-pending') ? 'active' : '' }}" href="{{ route('dashboard.item-pending') }}">
                                <span class="nav-icon">
                                    <i class="ri-time-line"></i>
                                </span>
                                <span class="nav-text">Items Pending </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard.invoices') ? 'active' : '' }}" href="{{ route('dashboard.invoices') }}">
                                <span class="nav-icon">
                                    <i class="ri-receipt-line"></i>
                                </span>
                                <span class="nav-text">Invoices</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard.settings') ? 'active' : '' }}" href="{{ route('dashboard.settings') }}">
                                <span class="nav-icon">
                                    <i class="ri-settings-3-line"></i>
                                </span>
                                <span class="nav-text">Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- ========== App Menu End ========== -->

            <!-- ==================================================== -->
            <!-- Start right Content here -->
            <!-- ==================================================== -->
            <div class="page-content">
                <!-- Start Container Fluid -->
                <div class="container-fluid">
                    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@yield('content')
                </div>

                <!-- ========== Footer Start ========== -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 text-center">
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                &copy; ReturnPal.
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- ========== Footer End ========== -->
            </div>
            <!-- ==================================================== -->
            <!-- End Page Content -->
            <!-- ==================================================== -->
        </div>
        <!-- END Wrapper -->

        <!-- Vendor Javascript -->
        <script src="{{ asset('dashboard/assets/js/vendor.js') }}"></script>
        <!-- App Javascript -->
        <script src="{{ asset('dashboard/assets/js/app.js') }}"></script>
        <!-- Custom Js -->
        <script src="{{ asset('dashboard/assets/js/custom.js') }}"></script>
        @yield('scripts')
    </body>
</html>
