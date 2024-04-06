@extends('Web.Layout.master_layout')

@section('content')
    <!-- Header Banner -->
    <section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ asset('img/1920x1128.jpg') }}"></section>
    <!-- About -->
    <section class="about section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-30 animate-box" data-animate-effect="fadeInUp">
                    <h2 class="section-title-about">About <span>MB</span></h2>
                    <div>{!! $about !!}</div>
                </div>
                <div class="col-md-6 animate-box" data-animate-effect="fadeInUp">
                    <div class="about-img">
                        <div class="img"> <img src="img/logo_2.png" class="img-logo" alt=""> </div>
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
                <div class="col-md-4" style="margin-left: 6%;">
                    <div class="item">
                        <div class="img"> <img src="{{ asset($location) }}" alt=""> </div>
                        <div class="info">
                            <h6>Maximiliano Bilotti</h6>
                            <p>Diseñador de Interiores</p>
                            <div class="social valign">
                                <div class="full-width">
                                    <p>Licenciado en Diseño de Interiores</p> 
                                    @if(isset($perAcounts->facebook) && $perAcounts->facebook != null)
                                        <a href="https://www.facebook.com/{{ $perAcounts->facebook }}" target="_blank"><i class="ti-facebook"></i></a>
                                    @endif
                                    @if(isset($perAcounts->facebook) && $perAcounts->whats_app != null)
                                        <a href="https://wa.me/549{{ $perAcounts->whats_app }}?text=Hola!,%20necesitaria%20asesoramiento%20especializado." target="_blank"><i class="fa fa-whatsapp"></i></a>
                                    @endif
                                    @if (isset($perAcounts->facebook) && $perAcounts->instagram != null)
                                        <a href="https://www.instagram.com/{{ $perAcounts->instagram }}" target="_blank"><i class="ti-instagram"></i></a>
                                    @endif
                                    @if (isset($perAcounts->facebook) && $perAcounts->twitter !=null)
                                        <a href="https://www.twitter.com/{{ $perAcounts->twitter }}" target="_blank"><i class="ti-twitter"></i></a>
                                    @endif
                                    @if (isset($perAcounts->facebook) && $perAcounts->linkedin !=null)
                                        <a href="https://www.linkedin.com/{{ $perAcounts->linkedin }}" target="_blank"><i class="ti-linkedin"></i></a>
                                    @endif
                                    @if (isset($perAcounts->facebook) && $perAcounts->pinterest !=null)
                                        <a href="https://www.pinterest.com/{{ $perAcounts->pinterest }}" target="_blank"><i class="ti-pinterest"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection