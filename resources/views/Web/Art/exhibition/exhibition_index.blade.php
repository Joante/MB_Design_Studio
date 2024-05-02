@extends('Web.Layout.master_layout')

@section('page-style')
    <link rel="canonical" href="https://mbdesignstudio.com.ar/art/exhibition" />
@endsection 

@section('content')
    <!-- Header Banner -->
    <section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ asset('img/1920x1128.jpg') }}"></section>
    
    <section class="bauen-blog3 section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title">Exhibiciones</h2> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row mb-30 mt-30">
                        <div class="col-md-12 animate-box " data-animate-effect="fadeInUp ">
                            <h6 class="section-title2" style="text-align: center;font-size: 25px;">Exibiciones <span>Actuales</span></h6>
                        </div>
                    </div>
                    <div class="blog-sidebar row animate-box " data-animate-effect="fadeInUp">
                        @foreach ($actualExhibitions as $actualExhibition)
                            <div class="col-md-6">
                                <div class="item">
                                    <div class="post-img">
                                        <a href="{{ route('exhibition_show', $actualExhibition->id) }}"> 
                                            @if (count($actualExhibition->images) == 0)
                                                <img src="{{ asset($actualExhibition->location->images->location) }}" alt="{{ $actualExhibition->location->images->title }}"> 
                                            @else
                                                <img src="{{ asset($actualExhibition->images[0]->location) }}" alt="{{ $actualExhibition->images[0]->title }}">   
                                            @endif
                                        </a>
                                    </div>
                                    <div class="post-cont widget">
                                        <div class="row" style="margin:0;">
                                            <span class="tag">{{ $actualExhibition->location->name }}</span> 
                                            <i>|</i> 
                                            <span class="date">{{ $actualExhibition->date_start->translatedFormat('d M Y') }} - {{ $actualExhibition->date_finish->translatedFormat('d M Y') }}</span>
                                            <i>|</i> 
                                            <span class="date">{{ $actualExhibition->hour_start->format('H:i') }} a {{ $actualExhibition->hour_finish->format('H:i') }}</span>
                                        </div>
                                        <div class="widget-title">
                                            <h6>
                                                <a href="{{ route('exhibition_show', $actualExhibition->id) }}">{{ $actualExhibition->title }}</a>
                                            </h6>
                                        </div>
                                        <p>{{ $actualExhibition->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-md-12 animate-box " data-animate-effect="fadeInUp">
                            <hr>
                        </div>
                    </div>
                    <div class="row mb-30 mt-30">
                        <div class="col-md-12 animate-box " data-animate-effect="fadeInUp ">
                            <h6 class="section-title2" style="text-align: center;font-size: 25px;">Exibiciones <span>Futuras</span></h6>
                        </div>
                    </div>
                    <div class="blog-sidebar row animate-box " data-animate-effect="fadeInUp">
                        @foreach ($futureExhibitions as $futureExhibition)
                            <div class="col-md-6">
                                <div class="item">
                                    <div class="post-img">
                                        <a href="{{ route('exhibition_show', $futureExhibition->id) }}"> 
                                            @if (count($futureExhibition->images) == 0)
                                                <img src="{{ asset($futureExhibition->location->images->location) }}" alt="{{ $futureExhibition->location->images->title }}"> 
                                            @else
                                                <img src="{{ asset($futureExhibition->images[0]->location) }}" alt="{{ $futureExhibition->images[0]->title }}">   
                                            @endif
                                        </a>
                                    </div>
                                    <div class="post-cont widget">
                                        <div class="row" style="margin:0;">
                                            <span class="tag">{{ $futureExhibition->location->name }}</span> 
                                            <i>|</i> 
                                            <span class="date">{{ $futureExhibition->date_start->translatedFormat('d M Y') }} - {{ $futureExhibition->date_finish->translatedFormat('d M Y') }}</span>
                                            <i>|</i> 
                                            <span class="date">{{ $futureExhibition->hour_start->format('H:i') }} a {{ $futureExhibition->hour_finish->format('H:i') }}</span>
                                        </div>
                                        <div class="widget-title">
                                            <h6>
                                                <a href="{{ route('exhibition_show', $futureExhibition->id) }}">{{ $futureExhibition->title }}</a>
                                            </h6>
                                        </div>
                                        <p>{{ $futureExhibition->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-md-12 animate-box " data-animate-effect="fadeInUp">
                            <hr>
                        </div>
                    </div>
                    <div class="row mb-30 mt-30">
                        <div class="col-md-12 animate-box " data-animate-effect="fadeInUp ">
                            <h6 class="section-title2" style="text-align: center;font-size: 25px;">Exibiciones <span>Pasadas</span></h6>
                        </div>
                    </div>
                    <div class="blog-sidebar row animate-box " data-animate-effect="fadeInUp">
                        @foreach ($pastExhibitions as $pastExhibition)
                            <div class="col-md-6">
                                <div class="item">
                                    <div class="post-img">
                                        <a href="{{ route('exhibition_show', $pastExhibition->id) }}"> 
                                            @if (count($pastExhibition->images) == 0)
                                                <img src="{{ asset($pastExhibition->location->images->location) }}" alt="{{ $pastExhibition->location->images->title }}"> 
                                            @else
                                                <img src="{{ asset($pastExhibition->images[0]->location) }}" alt="{{ $pastExhibition->images[0]->title }}">   
                                            @endif
                                        </a>
                                    </div>
                                    <div class="post-cont widget">
                                        <div class="row" style="margin:0;">
                                            <span class="tag">{{ $pastExhibition->location->name }}</span> 
                                            <i>|</i> 
                                            <span class="date">{{ $pastExhibition->date_start->translatedFormat('d M Y') }} - {{ $pastExhibition->date_finish->translatedFormat('d M Y') }}</span>
                                            <i>|</i> 
                                            <span class="date">{{ $pastExhibition->hour_start->format('H:i') }} a {{ $pastExhibition->hour_finish->format('H:i') }}</span>
                                        </div>
                                        <div class="widget-title">
                                            <h6>
                                                <a href="{{ route('exhibition_show', $pastExhibition->id) }}">{{ $pastExhibition->title }}</a>
                                            </h6>
                                        </div>
                                        <p>{{ $pastExhibition->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <!-- Pagination -->
                    <div class="bauen-pagination-wrap align-center mb-30 mt-30">
                        {{ $pastExhibitions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection