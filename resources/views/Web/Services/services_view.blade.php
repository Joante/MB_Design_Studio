@extends('Web.Layout.master_layout')

@section('page-style')
    <link rel="canonical" href="https://mbdesignstudio.com.ar/services/{{$service->id}}" />
@endsection 

@section('content')
        <section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ Helper::viteAsset('images/1920x1128.jpg') }}"></section>
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
                        <div id="editor" class="ql-editor" style="padding: 0px; height:auto;">{!! $service->text !!}</div>
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
                    <div class="col-md-8 sidebar-side service-sidebar-side">
                        <div class="sidebar blog-sidebar">
                            <div class="sidebar-widget services service-sidebar-widget">
                                <div class="widget-inner">
                                    <div class="sidebar-title">
                                        <h4>Todos los Servicios</h4>
                                    </div>
                                    <div class="row service-sidebar-grid">
                                        @foreach ($services as $list_service)
                                            <div class="col-3">
                                                <div class="item service-mini-item {{ $list_service->id == $service->id ? 'active-service-card' : '' }}">
                                                    <a href="{{ route('services_view', $list_service->id) }}">
                                                        @if ($list_service->icon != null && file_exists(public_path('images/icons/'.$list_service->icon->location)))
                                                            <img src="{{ Helper::viteAsset('images/icons/'.$list_service->icon->location) }}" alt="{{ $list_service->icon->title }}">
                                                        @else
                                                            <img src="{{ Helper::viteAsset('images/icons/icon-1.png') }}" alt="Icono de servicio">
                                                        @endif
                                                        <h5>{{ $list_service->title }}</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <aside class="sidebar blog-sidebar mt-50">
                            <div class="sidebar-widget services service-projects-widget">
                                <div class="widget-inner">
                                    <div class="sidebar-title">
                                        <h4>Proyectos</h4>
                                    </div>
                                    <div class="owl-carousel owl-theme service-projects-carousel">
                                        @foreach ($projects as $project)
                                            <div class="item">
                                                <div class="position-re o-hidden">
                                                    @if ($project->images != null && count($project->images) > 0 && file_exists(public_path($project->images[0]->location)))
                                                        <img class="projects-carousel service-projects-carousel-image" src="{{ asset($project->images[0]->location) }}" alt="{{ $project->images[0]->title }}">
                                                    @else
                                                        <img class="projects-carousel service-projects-carousel-image" src="{{ Helper::viteAsset('images/600x600.jpg') }}" alt="Imagen de proyecto no encontrada">
                                                    @endif
                                                </div>
                                                <div class="con service-project-card-content">
                                                    <h5><a href="{{ route('projects_view', $project->id) }}">{{ $project->title }}</a></h5>
                                                    <div class="line"></div>
                                                    <a href="{{ route('projects_view', $project->id) }}"><i class="ti-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="service-projects-actions">
                                        <a href="{{ route('projects_index') }}" class="service-projects-view-all">Ver Todos</a>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </section>    
@endsection

@section('page-script')
<script>
    $('.service-projects-carousel').owlCarousel({
        loop: {{ count($projects) > 1 ? 'true' : 'false' }},
        margin: 20,
        mouseDrag: true,
        autoplay: false,
        dots: true,
        nav: false,
        autoplayHoverPause: true,
        smartSpeed: 500,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
        }
    });
</script>
@endsection