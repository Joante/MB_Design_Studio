<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>mb. design studio @yield('title')</title>
    <link rel="shortcut icon" href="{{ Helper::viteAsset('images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ Helper::viteAsset('css/plugins.css') }}" />
    <link rel="stylesheet" href="{{ Helper::viteAsset('css/style.css') }}" />
    @yield('page-style')
    <script src="https://kit.fontawesome.com/c77e6f3bca.js" crossorigin="anonymous"></script>
</head>

<body data-logo-white="{{ Helper::viteAsset('images/logo_white.png') }}">
    <div id="preloader"></div>
    <div class="progress-wrap cursor-pointer">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="logo" href="{{ route('home') }}">
                <img src="{{ Helper::viteAsset('images/logo_white.png') }}" style="width: 80%;" alt="mb. design studio">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar"><i class="ti-line-double"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('services') ? 'active' : '' }}" href="{{ route('services_index') }}">Servicios</a></li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle {{ request()->is('art') ? 'active' : '' }}" href="{{ route('art_index') }}" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">Arte <i class="ti-angle-down"></i></a>
                        <ul class="dropdown-menu last">
                            <li class="dropdown-item {{ request()->is('art/collections') ? 'active' : '' }}"><a href="{{ route('paint_index') }}">Colecciones</a></li>
                            <li class="dropdown-item {{ request()->is('art/exhibitions') ? 'active' : '' }}"><a href="{{ route('exhibition_index') }}">Exhibiciones</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown"><a class="nav-link {{ request()->is('projects') ? 'active' : '' }}" href="{{ route('projects_index') }}">Proyectos</a></li>
                    <li class="nav-item dropdown"><a class="nav-link {{ request()->is('blog') ? 'active' : '' }}" href="{{ route('blog_index') }}">Blog</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="content-wrapper">
        <section class="content-lines-wrapper">
            <div class="content-lines-inner">
                <div class="content-lines"></div>
            </div>
        </section>

        <div class="content-body">
            @yield('content')
        </div>

        <section class="testimonials">
            <div class="background bg-img bg-fixed section-padding pb-0" data-background="{{ Helper::viteAsset('images/1920x1128.jpg') }}" data-overlay-dark="3">
                <div class="container">
                    <div class="row justify-content-center"></div>
                </div>
            </div>
        </section>
        <footer class="main-footer dark">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-30 animate-box" data-animate-effect="fadeInUp">
                        <div class="about-img">
                            <div class="img"><img src="{{ Helper::viteAsset('images/logo_2.png') }}" class="img-logo" alt="mb. design studio"></div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-30 justify-content-center" style="display: flex;">
                        <div class="item fotcont">
                            <div class="fothead">
                                <h4>CONTACTO</h4>
                            </div>
                            <div class="fotbody">
                                @if ($mbAcounts != null)
                                    @if ($mbAcounts->phone_formatted != null)
                                        <h6>Telefono: </h6>
                                        <p style="font-size: 18px;">{{ $mbAcounts->phone_formatted }}</p>
                                    @endif
                                    @if($mbAcounts->email != null)
                                        <h6>Email: </h6>
                                        <p style="font-size: 18px;">{{ $mbAcounts->email }}</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-30">
                        <div class="item fotcont">
                            <div class="fothead">
                                <div class="abot">
                                    <div class="social-icon">
                                        @if ($mbAcounts != null)
                                            @if($mbAcounts->facebook != null)
                                                <a href="https://www.facebook.com/{{ $mbAcounts->facebook }}" target="_blank"><i class="ti-facebook"></i></a>
                                            @endif
                                            @if($mbAcounts->whats_app != null)
                                                <a href="https://wa.me/{{ $mbAcounts->whats_app }}?text=Hola!,%20necesitaria%20asesoramiento%20especializado." target="_blank"><i class="fa fa-whatsapp"></i></a>
                                            @endif
                                            @if ($mbAcounts->instagram != null)
                                                <a href="https://www.instagram.com/{{ $mbAcounts->instagram }}" target="_blank"><i class="ti-instagram"></i></a>
                                            @endif
                                            @if ($mbAcounts->twitter != null)
                                                <a href="https://www.twitter.com/{{ $mbAcounts->twitter }}" target="_blank"><i class="ti-twitter"></i></a>
                                            @endif
                                            @if ($mbAcounts->linkedin != null)
                                                <a href="https://www.linkedin.com/company/{{ $mbAcounts->linkedin }}" target="_blank"><i class="ti-linkedin"></i></a>
                                            @endif
                                            @if ($mbAcounts->pinterest != null)
                                                <a href="https://www.pinterest.com/{{ $mbAcounts->pinterest }}" target="_blank"><i class="ti-pinterest"></i></a>
                                            @endif
                                        @endif
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
                            <div class="text-start">
                                <p>&copy; 2024 mb. design studio. All rights reserved.</p>
                            </div>
                        </div>
                        <div class="col-md-8 float-end">
                            <p class="right"><a href="#">Terminos &amp; Condiciones</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="{{ Helper::viteAsset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ Helper::viteAsset('js/jquery-migrate-3.0.0.min.js') }}"></script>
    <script src="{{ Helper::viteAsset('js/modernizr-2.6.2.min.js') }}"></script>
    <script src="{{ Helper::viteAsset('js/pace.js') }}"></script>
    <script src="{{ Helper::viteAsset('js/popper.min.js') }}"></script>
    <script src="{{ Helper::viteAsset('js/bootstrap.min.js') }}"></script>
    <script src="{{ Helper::viteAsset('js/scrollIt.min.js') }}"></script>
    <script src="{{ Helper::viteAsset('js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ Helper::viteAsset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ Helper::viteAsset('js/jquery.stellar.min.js') }}"></script>
    <script src="{{ Helper::viteAsset('js/jquery.magnific-popup.js') }}"></script>
    <script src="{{ Helper::viteAsset('js/YouTubePopUp.js') }}"></script>
    <script src="{{ Helper::viteAsset('js/custom.js') }}"></script>
    @yield('page-script')
</body>

</html>
