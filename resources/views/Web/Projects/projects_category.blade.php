@extends('Web.Layout.master_layout')

@section('content')
    <!-- Header Banner -->
    <section class="banner-header banner-img bg-img bg-fixed pb-0" data-background="{{ asset('img/1920x1128.jpg') }}" data-overlay-darkgray="5">
    </section>
    <!-- Projects -->
    <section class="projects section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-md-12 animate-box" data-animate-effect="fadeInUp">
                    <h2 class="section-title">{{ $service }}</h2>
                    <hr>
                </div>
            </div>
            <div class="row">
                @foreach ($projects as $project)
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
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <!-- Pagination -->
                    <div class="bauen-pagination-wrap align-center mb-30 mt-30">
                        {{ $projects->links() }}
                    </div>
                </div>
            </div>  
        </div>
    </section>
@endsection