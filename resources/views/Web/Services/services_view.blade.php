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
                       {!! $service->text !!}
                        <div class="row mb-30">
                            @foreach ($service->images as $key => $image)
                                @if ($key!=2)
                                    <div class="col-md-6 gallery-item">
                                        <a href="{{ asset($image->location) }}" title="$image->title" class="img-zoom">
                                            <div class="gallery-box">
                                                <div class="gallery-img"> <img src="{{ asset($image->location) }}" class="img-fluid mx-auto d-block" alt="$image->title"> </div>
                                            </div>
                                        </a>
                                    </div>
                                @else
                                    <div class="col-md-12 gallery-item">
                                        <a href="{{ asset($image->location) }}" title="$image->title" class="img-zoom">
                                            <div class="gallery-box">
                                                <div class="gallery-img"> <img src="{{ asset($image->location) }}" class="img-fluid mx-auto d-block" alt="$image->title"> </div>
                                            </div>
                                        </a>
                                    </div>    
                                @endif
                            @endforeach
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
                                        @foreach ($services as $list_service)
                                            @if ($list_service->id == $service->id)
                                                <li class="active"><a href="{{ route('services_view', $list_service->id) }}">{{ $list_service->title }}</a></li>    
                                            @else
                                                <li><a href="{{ route('services_view', $list_service->id) }}">{{ $list_service->title }}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </aside>
                        <aside class="sidebar blog-sidebar mt-50">
                            <div class="sidebar-widget services">
                                <div class="widget-inner">
                                    <div class="sidebar-title">
                                        <h4>Proyectos de {{ $service->title }}</h4>
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