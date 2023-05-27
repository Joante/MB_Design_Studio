@extends('Web.Layout.master_layout')

@section('content')
    <!-- Header Banner -->
    <section class="banner-header banner-img bg-img bg-fixed pb-0" data-background="{{ asset('img/1920x1128.jpg') }}" data-overlay-darkgray="5"></section>
    <!-- Projects -->
    <section class="projects section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-md-12 animate-box" data-animate-effect="fadeInUp">
                    <h2 class="section-title">Nuestros <span>Proyectos</span></h2>
                    <hr>
                </div>
            </div>
            @foreach ($services as $service)
                @if (in_array($service->id, $categories))
                    <div class="row justify-content-center">
                        <h6 class="section-title2"><span style="font-size: 25px;"><a href="{{ route('project_view_category', $service->id) }}">{{ $service->title }}</a></span></h6>
                    </div>
                    <div class="row">
                        @foreach ($projects as $project)
                            @if ($project->service_id == $service->id)
                                <div class="col-md-6 animate-box" data-animate-effect="fadeInUp">
                                    <div class="item">
                                        <div class="position-re o-hidden">
                                            @if (!empty($project->images->all()))
                                            
                                                <img src="{{ asset($project->images->first()->location) }}" alt="{{ $project->images->first()->title }}"> 
                                            @else
                                                <img src="{{ asset('img/1920x1128-1.jpg') }}" alt=""> 
                                            @endif
                                        </div>
                                        <div class="con">
                                            <h5><a href="{{ route('projects_view', $project->id) }}">{{ $project->title }}</a></h5>
                                            <div class="line"></div> <a href="{{ route('projects_view', $project->id) }}"><i class="ti-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endsection