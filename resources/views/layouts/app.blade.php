<!doctype html>
<html lang="en">
    <head>
        <!-- meta tags -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <!-- title -->
        <title>@yield('title', 'ReturnPal')</title>
        <!-- favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/favicon.png') }}" />
        <!-- css -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/all-fontawesome.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
        @yield('styles')
    </head>

    <body>
        <!-- preloader -->
        <div class="preloader">
            <div class="loader-ripple">
                <div></div>
                <div></div>
            </div>
        </div>
        <!-- preloader end -->

        <div class="ticker-title">
            <span>Each month your most expensive item is processed with absolutely zero fees. You keep 100%</span>
            <span>Each month your most expensive item is processed with absolutely zero fees. You keep 100%</span>
            <span>Each month your most expensive item is processed with absolutely zero fees. You keep 100%</span>
            <span>Each month your most expensive item is processed with absolutely zero fees. You keep 100%</span>
            <span>Each month your most expensive item is processed with absolutely zero fees. You keep 100%</span>
        </div>

        <!-- header area -->
        <header class="header">
            <!-- navbar -->
            <div class="main-navigation">
                <nav class="navbar navbar-expand-lg">
                    <div class="container position-relative">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo" />
                        </a>
                        <div class="mobile-menu-right">
                            <button
                                class="navbar-toggler"
                                type="button"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasNavbar"
                                aria-controls="offcanvasNavbar"
                                aria-label="Toggle navigation"
                            >
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
                            <div class="offcanvas-header">
                                <a href="{{ url('/') }}" class="offcanvas-brand" id="offcanvasNavbarLabel">
                                    <img src="{{ asset('assets/img/logo/logo.png') }}" alt="" />
                                </a>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                                    <i class="far fa-xmark"></i>
                                </button>
                            </div>
                            <div class="offcanvas-body">
                                <ul class="navbar-nav justify-content-end flex-grow-1">
                                    <li class="nav-item"><a class="nav-link" href="{{ url('/#our-solution') }}">How It Works</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ url('/#features') }}">Features</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ url('/#pricing') }}">Pricing</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ url('/#contact') }}">Contact</a></li>
                                </ul>
                                <!-- nav-right -->
                                <div class="nav-right">
                                    <div class="nav-btn">
                                        <a href="{{ route('login') }}" class="theme-btn">Get Started Free</a>
                                    </div>
                                    <button
                                        type="button"
                                        class="sidebar-btn nav-right-link"
                                        data-bs-toggle="offcanvas"
                                        data-bs-target="#sidebarPopup"
                                    >
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <!-- navbar end-->
        </header>
        <!-- header area end -->

        <!-- sidebar-popup -->
        <div class="sidebar-popup offcanvas offcanvas-end" tabindex="-1" id="sidebarPopup">
            <div class="offcanvas-header">
                <a href="{{ url('/') }}" class="sidebar-popup-logo">
                    <img src="{{ asset('assets/img/logo/logo.png') }}" alt="" />
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <i class="far fa-xmark"></i>
                </button>
            </div>
            <div class="sidebar-popup-wrap offcanvas-body">
                <div class="sidebar-popup-content">
                    <div class="sidebar-popup-about">
                        <h4>About Us</h4>
                        <p>
                            With no upfront costs and performance-based pricing, our team maximizes recovery value while
                            providing real-time tracking and dedicated support.
                        </p>
                    </div>
                    <div class="sidebar-popup-contact">
                        <h4>Contact Info</h4>
                        <ul>
                            <li>
                                <div class="icon">
                                    <i class="far fa-envelope"></i>
                                </div>
                                <div class="content">
                                    <h5>Email</h5>
                                    <a href="mailto:contact@ReturnPal.com">contact@ReturnPal.com</a>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <i class="far fa-phone"></i>
                                </div>
                                <div class="content">
                                    <h5>Phone</h5>
                                    <a href="tel:+447305057852">+44 7305 057852</a>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <i class="far fa-location-dot"></i>
                                </div>
                                <div class="content">
                                    <h5>Address</h5>
                                    <a href="#">25/B Milford Road, New York</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="sidebar-popup-social">
                        <h4>Follow Us</h4>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-x-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- sidebar-popup end -->

        <main class="main">
            @yield('content')
        </main>

        <!-- footer area -->
        <footer class="footer-area">
            <div class="footer-shape">
                <img src="{{ asset('assets/img/shape/05.png') }}" alt="" />
            </div>
            <div class="footer-widget">
                <div class="container">
                    <div class="footer-widget-wrap pt-100 pb-50">
                        <div class="row g-4">
                            <div class="col-lg-5">
                                <div class="footer-widget-box about-us">
                                    <a href="#" class="footer-logo">
                                        <img src="{{ asset('assets/img/logo/logo-light.png') }}" alt="" />
                                    </a>
                                    <p>
                                        With no upfront costs and performance-based pricing, our team maximizes recovery
                                        value while providing real-time tracking and dedicated support.
                                    </p>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <div class="footer-widget-box list ms-lg-5">
                                    <h4 class="footer-widget-title">Company</h4>
                                    <ul class="footer-list">
                                        <li>
                                            <a href="{{ url('/#our-solution') }}"
                                                ><i class="far fa-angle-double-right"></i>Our Solution</a
                                            >
                                        </li>
                                        <li>
                                            <a href="{{ url('/#features') }}"><i class="far fa-angle-double-right"></i>Features</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/#pricing') }}"><i class="far fa-angle-double-right"></i>Pricing</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/#contact') }}"><i class="far fa-angle-double-right"></i>Contact Us</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="footer-widget-box">
                                    <h4 class="footer-widget-title">Get In Touch</h4>
                                    <ul class="footer-contact">
                                        <li>
                                            <div class="icon">
                                                <i class="far fa-phone"></i>
                                            </div>
                                            <div class="content">
                                                <h5>Call Us</h5>
                                                <a href="tel:+447305057852">+44 7305 057852</a>
                                            </div>
                                        </li>
                                        <li class="mt-4">
                                            <div class="icon">
                                                <i class="far fa-envelope"></i>
                                            </div>
                                            <div class="content">
                                                <h5>Mail Us</h5>
                                                <a href="mailto:contact@ReturnPal.com">contact@ReturnPal.com</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 align-self-center">
                            <p class="copyright-text">
                                &copy; Copyright <span id="date"></span> <a href="#"> ReturnPal </a> All Rights
                                Reserved.
                            </p>
                        </div>
                        <div class="col-md-6 align-self-center">
                            <ul class="footer-social">
                                <li>
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-x-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-youtube"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer area end -->

        <!-- scroll-top -->
        <a href="#" id="scroll-top"><i class="far fa-arrow-up"></i></a>
        <!-- scroll-top end -->

        <!-- js -->
        <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/wow.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        @yield('scripts')
    </body>
</html>
