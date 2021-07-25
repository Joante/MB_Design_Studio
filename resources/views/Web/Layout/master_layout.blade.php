<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>MB Design Studio @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="stylesheet" href="/css/plugins.css" />
    <link rel="stylesheet" href="/css/style.css" />
    @yield('page-style')
    <script src="https://kit.fontawesome.com/c77e6f3bca.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Preloader -->
    <div id="preloader"></div>
    <!-- Progress scroll totop -->
    <div class="progress-wrap cursor-pointer">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo -->
            <a class="logo" href="{{ route('home') }}"> <img src="{{ asset('/img/logo_white.png') }}" style="width: 250px;"> </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="icon-bar"><i class="ti-line-double"></i></span> </button>
            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link {{ (request()->is('/')) ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ (request()->is('about')) ? 'active' : '' }}" href="{{ route('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link {{ (request()->is('services')) ? 'active' : '' }}" href="{{ route('services_index') }}">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="art.html">Arte</a></li>
                    <li class="nav-item dropdown"><a class="nav-link" href="projects.html">Proyectos <i class="ti-angle-down"></i></a>
                        <ul class="dropdown-menu last">
                            <li class="dropdown-item"><a href="interior-design-projects.html">Interiorismo</a></li>
                            <li class="dropdown-item"><a href="landscaping-projects.html">Paisajismo</a></li>
                            <li class="dropdown-item"><a href="collections-projects.html">Colecciones</a></li>
                            <li class="dropdown-item"><a href="planing-projects.html">Planing</a></li>
                            <li class="dropdown-item active"><a href="3d-modelling-projects.html">Modelado 3D</a></li>
                            <li class="dropdown-item"><a href="decor-plan-projects.html">Decor Plan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown"><a class="nav-link" href="blog.html">Blog <i class="ti-angle-down"></i></a>
                        <ul class="dropdown-menu last">
                            <li class="dropdown-item"><a href="interior-design-blog.html">Diseño</a></li>
                            <li class="dropdown-item"><a href="art-blog.html">Arte</a></li>
                            <li class="dropdown-item"><a href="personal-blog.html">Personal</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link {{ (request()->is('contact')) ? 'active' : '' }}" href="{{ route('contact') }}">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Content -->
    <div class="content-wrapper">
        <!-- Lines -->
        <section class="content-lines-wrapper">
            <div class="content-lines-inner">
                <div class="content-lines"></div>
            </div>
        </section>

        <div class="content-body">
            {{-- Include Page Content --}}
            @yield('content')
        </div>

        <!-- Footer -->
        <section class="testimonials">
            <div class="background bg-img bg-fixed section-padding pb-0" data-background="/img/1920x1128.jpg" data-overlay-dark="3">
                <div class="container">
                    <div class="row justify-content-center">
                    </div>
                </div>
            </div>
        </section>
        <footer class="main-footer dark">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-30 animate-box" data-animate-effect="fadeInUp">
                        <div class="about-img">
                            <div class="img"> <img src="/img/logo_2.png" class="img-fluid" alt=""> </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-30">
                        <div class="item fotcont">
                            <div class="fothead">
                                <h4>CONTACTO</h4>
                            </div>
                            <div class="fotbody">
                                <h6>Telefono: </h6>
                                <p style="font-size: 14px;">+54 9 11-1234-5678</p>
                                <h6>Email: </h6>
                                <p style="font-size: 14px;">maxbilotti.designstudio@gmail.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-30">
                        <div class="item fotcont">
                            <div class="fothead">
                                <div class="abot">
                                    <div class="social-icon">
                                        <a href="https://www.facebook.com/maxbilottidesignstudio" target="_blank"><i class="ti-facebook"></i></a>
                                        <a href="https://wa.me/5491134392501?text=Hola!,%20necesitaria%20asesoramiento%20especializado." target="_blank"><i class="fa fa-whatsapp"></i></a>
                                        <a href="https://www.instagram.com/mb.designstudio/" target="_blank"><i class="ti-instagram"></i></a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="sub-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-left">
                                <p>© 2021 MB Design Studio. All right reserved.</p>
                            </div>
                        </div>
                        <div class="col-md-8 float-right">
                            <p class="right"><a href="#">Terminos &amp; Condiciones</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- jQuery -->
    <script src="/js/jquery-3.5.1.min.js"></script>
    <script src="/js/jquery-migrate-3.0.0.min.js"></script>
    <script src="/js/modernizr-2.6.2.min.js"></script>
    <script src="/js/pace.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/scrollIt.min.js"></script>
    <script src="/js/jquery.waypoints.min.js"></script>
    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/jquery.stellar.min.js"></script>
    <script src="/js/jquery.magnific-popup.js"></script>
    <script src="/js/YouTubePopUp.js"></script>
    <script src="/js/custom.js"></script>
    @yield('page-script')
</body>

</html>