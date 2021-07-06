@extends('Web.Layout.master_layout')

@section('content')
    <!-- Content -->
    <div class="content-wrapper">
        <!-- Lines -->
        <section class="content-lines-wrapper">
            <div class="content-lines-inner">
                <div class="content-lines"></div>
            </div>
        </section>
        <!-- Header Banner -->
        <section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="img/1920x1128.jpg"></section>
        <!-- Services Page -->
        <section class="section-padding2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-title2">{{ $service->title }}</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <p>{{$services->description}}</p>
                        <div class="row mb-30">
                            <div class="col-md-6 gallery-item">
                                <a href="img/1100x750.jpg" title="Architecture" class="img-zoom">
                                    <div class="gallery-box">
                                        <div class="gallery-img"> <img src="img/1100x750.jpg" class="img-fluid mx-auto d-block" alt="work-img"> </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 gallery-item">
                                <a href="img/1100x750.jpg" title="Architecture" class="img-zoom">
                                    <div class="gallery-box">
                                        <div class="gallery-img"> <img src="img/1100x750.jpg" class="img-fluid mx-auto d-block" alt="work-img"> </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-12 gallery-item">
                                <a href="img/1100x750.jpg" title="Architecture" class="img-zoom">
                                    <div class="gallery-box">
                                        <div class="gallery-img"> <img src="img/1100x750.jpg" class="img-fluid mx-auto d-block" alt="work-img"> </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 gallery-item">
                                <a href="img/1100x750.jpg" title="Architecture" class="img-zoom">
                                    <div class="gallery-box">
                                        <div class="gallery-img"> <img src="img/1100x750.jpg" class="img-fluid mx-auto d-block" alt="work-img"> </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 gallery-item">
                                <a href="img/1100x750.jpg" title="Architecture" class="img-zoom">
                                    <div class="gallery-box">
                                        <div class="gallery-img"> <img src="img/1100x750.jpg" class="img-fluid mx-auto d-block" alt="work-img"> </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 sidebar-side">
                        <aside class="sidebar blog-sidebar">
                            <div class="sidebar-widget services">
                                <div class="widget-inner">
                                    <div class="sidebar-title">
                                        <h4>Todos los Servicios</h4>
                                    </div>
                                    <ul>
                                        <li class="active"><a href="interior-design.html">Interiorismo</a></li>
                                        <li><a href="landscaping.html">Paisajismo</a></li>
                                        <li><a href="collections.html">Colecciones</a></li>
                                        <li><a href="planning.html">Planning</a></li>
                                        <li><a href="3d-modelling.html">Modelado 3D</a></li>
                                        <li><a href="decor-plan.html">Decor Plan</a></li>
                                    </ul>
                                </div>
                            </div>
                        </aside>
                        <aside class="sidebar blog-sidebar mt-50">
                            <div class="sidebar-widget services">
                                <div class="widget-inner">
                                    <div class="sidebar-title">
                                        <h4>Proyectos de Interiorismo</h4>
                                    </div>
                                    <ul>
                                        <li><a href="armada-center.html">Chile</a></li>
                                        <li><a href="cotton-house.html">Devoto</a></li>
                                        <li><a href="prime-hotel.html">Fouba</a></li>
                                        <li><a href="stonya-villa.html">Adrogue</a></li>
                                        <li><a href="interior-design-projects.html">Ver Todos</a></li>
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
@endsection