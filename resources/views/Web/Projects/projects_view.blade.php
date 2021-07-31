@extends('Web.Layout.master_layout')

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}" />
@endsection 

@section('content')
    <!-- Header Banner -->
    <section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ asset('img/1920x1128.jpg') }}"></section>

    <!-- Project Page -->
    <section class="section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title2">{{ $project->title }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div id="editor" class="ql-editor" style="padding: 0px; height:auto;">{!! $project->description !!}</div>
                </div>
                <div class="col-md-4">
                    <p><b>Nombre de Projecto : </b> {{ $project->title }}</p>
                    @if ($project->client != null)
                        <p><b>Cliente : </b> {{ $project->client }}</p>    
                    @endif
                    @if ($project->location != null)
                        <p><b>Locación : </b> {{ $project->location }}</p>
                    @endif
                </div>
            </div>
            <div class="row mt-30">
                @foreach ($project->images as $image)
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
    <!-- Prev-Next Projects -->
    <section class="projects-prev-next">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <div class="col-md-4 d-flex justify-content-start">
                            @if ($previous != null)
                                <div class="projects-prev-next-left">
                                    <a href="{{ route('projects_view', $previous) }}"> <i class="ti-arrow-left"></i>Anterior Projecto</a>
                                </div>    
                            @endif
                        </div>
                        <div class="col-md-4 d-flex justify-content-center">
                            <a href="{{ route('project_view_category', $project->service_id) }}"><i class="ti-layout-grid3-alt"></i></a>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end">
                            @if ($next != null)
                                <div class="projects-prev-next-right"> 
                                    <a href="{{ route('projects_view', $next) }}">Siguiente Projecto <i class="ti-arrow-right"></i></a> 
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection