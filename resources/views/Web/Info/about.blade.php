@extends('Web.Layout.master_layout')

@section('content')
    <!-- Header Banner -->
    <section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ asset('img/1920x1128.jpg') }}"></section>
    <!-- About -->
    <section class="about section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-30 animate-box" data-animate-effect="fadeInUp">
                    <h2 class="section-title">About <span>MB</span></h2>
                    <p>Somos un estudio especializado en la realización y ejecución de proyectos de arquitectura interior, exterior, residencial y comercial.</p>
                    <p>Con base en Buenos Aires. Reconocido por nuestro estilo único, elegante y contemporáneo.</p>
                    <p>Ademas ofrecemos una exclusiva colección de obras de arte para elevar el estilo de multiples y diversos ambientes. </p>
                </div>
                <div class="col-md-6 animate-box" data-animate-effect="fadeInUp">
                    <div class="about-img">
                        <div class="img"> <img src="img/logo_2.png" class="img-fluid" alt=""> </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Team -->
    <section class="team section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title">Nuestro <span>Equipo</span></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="item">
                        <div class="img"> <img src="{{ asset($location) }}" alt=""> </div>
                        <div class="info">
                            <h6>Maximiliano Bilotti</h6>
                            <p>Diseñador de Interiores</p>
                            <div class="social valign">
                                <div class="full-width">
                                    <p>Licenciado en Diseño de Interiores</p> 
                                    @if($perAcounts->facebook != null)
                                        <a href="https://www.facebook.com/{{ $perAcounts->facebook }}" target="_blank"><i class="ti-facebook"></i></a>
                                    @endif
                                    @if($perAcounts->whats_app != null)
                                        <a href="https://wa.me/549{{ $perAcounts->whats_app }}?text=Hola!,%20necesitaria%20asesoramiento%20especializado." target="_blank"><i class="fa fa-whatsapp"></i></a>
                                    @endif
                                    @if ($perAcounts->instagram != null)
                                        <a href="https://www.instagram.com/{{ $perAcounts->instagram }}" target="_blank"><i class="ti-instagram"></i></a>
                                    @endif
                                    @if ($perAcounts->twitter !=null)
                                        <a href="https://www.twitter.com/{{ $perAcounts->twitter }}" target="_blank"><i class="ti-twitter"></i></a>
                                    @endif
                                    @if ($perAcounts->linkedin !=null)
                                        <a href="https://www.linkedin.com/{{ $perAcounts->linkedin }}" target="_blank"><i class="ti-linkedin"></i></a>
                                    @endif
                                    @if ($perAcounts->pinterest !=null)
                                        <a href="https://www.pinterest.com/{{ $perAcounts->pinterest }}" target="_blank"><i class="ti-pinterest"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 ml-auto mr-3">
                    <p class="float-md-right">{{ $description }}</p>
                    <h6 class="section-title2"><span>Estudios</span></h6>
                    <ul class="list-unstyled pricing-card-list float-md-right">
                        <li class="mt-10"><i class="fas fa-university"></i></i>Licenciatura en Diseño de Interiores - Universidad del Museo Social Argentino</li>
                        <li class="mt-10"><i class="fas fa-university"></i></i>Tecnicatura Superior en Diseño de Interiores y Espacios Verdes - Escuela Argentina del Diseño</li>
                        <li class="mt-10"><i class="ti-medall"></i>Curso de Diseño de Espacios Interiores - Instituto Nacional de Servicios y Empresas / Universidad Tecnologica Nacional</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection