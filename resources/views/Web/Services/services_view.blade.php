@extends('Web.Layout.master_layout')

@section('page-style')
@endsection 

@section('content')
        <section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ asset('img/1920x1128.jpg') }}"></section>
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
                                        <h4>Proyectos</h4>
                                    </div>
                                    <ul>
                                        @foreach ($projects as $project)
                                            <li><a href="{{ route('projects_view', $project->id) }}">{{ $project->title }}</a></li>    
                                        @endforeach
                                        <li><a href="{{ route('project_view_category', $service->id) }}">Ver Todos</a></li>
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </section>    
@endsection