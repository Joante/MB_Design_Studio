@extends('Web.Layout.master_layout')

@section('page-style')
    <link rel="canonical" href="https://mbdesignstudio.com.ar/services" />
@endsection

@section('content')
    <!-- Header Banner -->
    <section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ asset('img/1920x1128.jpg') }}"></section>
    <!-- Services -->
    <section class="services section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-md-12 animate-box" data-animate-effect="fadeInUp">
                    <h2 class="section-title">Servicios</h2>
                </div>
            </div>
            <div class="row">
                @foreach ($services as $key => $service)
                    <div class="col-md-4">
                        <div class="item">
                            <a href="{{ route('services_view', $service->id) }}"> <img src="{{ asset('img/icons/'.$service->icon->location) }}" alt="$service->icon->title">
                                <h5>{{ $service->title }}</h5>
                                <div class="line"></div>
                                <p>{{ $service->description }}</p>
                                <br>
                                <div class="numb">0{{ $key+1 }}</div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection