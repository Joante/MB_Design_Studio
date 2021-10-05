@extends('Web.Layout.master_layout')

@section('content')
    <!-- Header Banner -->
    <section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ asset('img/1920x1128.jpg') }}"></section>

    <section class="section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title2">{{ $painting->name }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <p>{{ $painting->description }}</p>
                    <div class="row mb-30">
                        @foreach ($painting->images as $key => $image)
                            @if ($key!=2)
                                <div class="col-md-6 gallery-item">
                                    <a href="{{ asset($image->location) }}" title="{{ $image->title }}" class="img-zoom">
                                        <div class="gallery-box">
                                            <div class="gallery-img"> <img src="{{ asset($image->location) }}" class="img-fluid mx-auto d-block" alt="{{ $image->title }}"> </div>
                                        </div>
                                    </a>
                                </div>
                            @else
                                <div class="col-md-12 gallery-item">
                                    <a href="{{ asset($image->location) }}" title="{{ $image->title }}" class="img-zoom">
                                        <div class="gallery-box">
                                            <div class="gallery-img"> <img src="{{ asset($image->location) }}" class="img-fluid mx-auto d-block" alt="{{ $image->title }}"> </div>
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
                                    <h4>Informacion de la Obra</h4>
                                </div>
                                <ul>
                                    <li><p><b>Tecnica:</b> {{ $painting->tecnique }}</p></li>
                                    <li><p><b>Alto:</b> {{ $painting->height }}</p></li>
                                    <li><p><b>Ancho:</b> {{ $painting->width }}</p></li>
                                </ul>
                            </div>
                        </div>
                    </aside>
                    <aside class="sidebar blog-sidebar mt-50">
                        <div class="sidebar-widget services">
                            <div class="widget-inner">
                                <div class="sidebar-title">
                                    <h4>Otras obras de la coleccion</h4>
                                </div>
                                <ul>
                                    @foreach ($colection as $paintings)
                                        @if ($paintings->id == $painting->id)
                                            <li class="active"><a href="{{ route('paint_show', $paintings->id) }}">{{ $paintings->name }}</a></li>    
                                        @else
                                            <li><a href="{{ route('paint_show', $paintings->id) }}">{{ $paintings->name }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection