@extends('Web.Layout.master_layout')

@section('page-style')
    <link rel="canonical" href="https://mbdesignstudio.com.ar/art/exhibiton/{{$exhibition->id}}" />
@endsection 

@section('content')
    <!-- Header Banner -->
    <section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ asset('img/1920x1128.jpg') }}"></section>

    <!-- Project Page -->
    <section class="section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title2">{{ $exhibition->title }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div id="editor" class="ql-editor" style="padding: 0px; height:auto;">{!! $exhibition->text !!}</div>
                </div>
                <div class="col-md-4">
                    <div class="blog-sidebar row">
                        <div class="widget" style="width: 100%;">
                            <ul>
                                <li><p><b>Fecha de Inicio : </b> {{ $exhibition->date_start->format('d/m/Y H:m') }}</p></li>
                                <li><p><b>Fecha de Cierre : </b> {{ $exhibition->date_finish->format('d/m/Y H:m') }}</p></li>
                                <li><p><b>Horarios : </b> {{ $exhibition->hour_start->format('H:i') }} a {{ $exhibition->hour_finish->format('H:i') }}</p></li>
                            </ul>
                        </div>
                        <div class="widget" style="width: 100%;">
                            <div class="widget-title">
                                <h6>{{ $exhibition->location->name }}</h6>
                            </div>
                            <ul>
                                <li><p><b>Direccion : </b> {{ $exhibition->location->adress }}</p></li>
                                <li><p><b>Pagina Web : </b> <a href="{{ $exhibition->location->url }}" target="_blank">{{ $exhibition->location->url }}</a></p></li>
                                <li><p><b>Telefono : </b> {{ $exhibition->location->phone }}</p></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-30">
                @foreach ($exhibition->images as $image)
                    <div class="col-md-6 gallery-item">
                        <a href="{{ asset($image->location) }}" title="{{ $image->title }}" class="img-zoom">
                            <div class="gallery-box">
                                <div class="gallery-img"> <img src="{{ asset($image->location) }}" class="img-fluid mx-auto d-block" alt="{{ $image->title }}"> </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection