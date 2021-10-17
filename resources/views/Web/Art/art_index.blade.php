@extends('Web.Layout.master_layout')

@section('content')
<!-- Header Banner -->
<section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ asset('img/1920x1128.jpg') }}"></section>
<!-- Pricing -->
<section class="section-padding2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-title">Ar<span>te</span></h2>
            </div>
        </div>
        <div class="row mb-30">
            <div class="col-md-12 animate-box" data-animate-effect="fadeInUp">
                <h6 class="section-title2" style="text-align: center;font-size: 25px;">Nuestras colecciónes de arte</h6>
            </div>
        </div>
        <section class="colections">
            <div class="container">
                @for ($i = 0; $i < 4; $i++)
                    @if ($i == 0 || $i == 2)
                        <div class="col-md-12 animate-box" data-animate-effect="fadeInUp" style="margin-bottom: 30px;">
                            <div class="row">
                                <div class="col-md-6 art_colections">
                    @else
                        <div class="col-md-6">
                    @endif
                            <h2 class="section-title2" style="text-align: center;font-size:18px;"><span>{{ $colections[$i]->name }}</span></h2>
                            <div class="owl-carousel owl-theme">
                                @foreach ($colections[$i]['paintings'] as $painting)
                                    <div class="item">
                                        <div class="position-re o-hidden"> 
                                            @if (count($painting->images)> 0)
                                                <img class="projects-carousel" src="{{ asset($painting->images[0]->location) }}" alt="{{ $painting->images[0]->title }}"> 
                                            @else
                                                <img class="projects-carousel" src="{{ asset('public/img/600x600.jpg') }}" alt="">     
                                            @endif
                                        </div>
                                        <div class="con">
                                            <h5><a href="{{ route('paint_collection_index', $colections[$i]->id) }}">{{ $painting->name }}</a></h5>
                                            <div class="line"></div> <a href="{{ route('paint_collection_index', $colections[$i]->id) }}"><i class="ti-arrow-right"></i></a>
                                        </div>
                                    </div>
                                @endforeach        
                            </div>
                        </div>
                    @if ($i == 1 || $i == 3)
                                <div class="col-md-12 animate-box " style="margin-top: 20px;" data-animate-effect="fadeInUp">
                                    <hr style="border-color: #fff;">
                                </div>    
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </section>
        <div class="row mb-30 justify-content-center animate-box" data-animate-effect="fadeInUp">
            <button type="button" class="butn-dark mt-15 "><a href="{{ route('paint_index') }} "><span>Ver Mas</span></a></button>
        </div>
        <div class="row">
            <div class="col-md-12 animate-box " data-animate-effect="fadeInUp">
                <hr>
            </div>
        </div>
        <section class="bauen-blog2 section-padding">
            <div class="container">
                <div class="row mb-30">
                    <div class="col-md-12 animate-box " data-animate-effect="fadeInUp ">
                        <h6 class="section-title2" style="text-align: center;font-size: 25px;">Nuestras exhibiciones</h6>
                    </div>
                </div>
                @for ($i=0;$i<4;$i++)
                    <div class="row mb-60">
                        @if ($i == 0 || $i == 2)
                            <div class="col-md-6 animate-box" data-animate-effect="fadeInLeft">
                                <div class="img left">
                                    <a href="{{ route('exhibition_show', $exhibitions[$i]->id) }}">
                                        @if (count($exhibitions[$i]->images) == 0)
                                            <img src="{{ asset($exhibitions[$i]->location->image->location) }}" alt="{{ $exhibitions[$i]->location->image->title }}"> 
                                        @else
                                            <img src="{{ asset($exhibitions[$i]->images[0]->location) }}" alt="{{ $exhibitions[$i]->images[0]->title }}">   
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 valign animate-box" data-animate-effect="fadeInRight">
                                <div class="content">
                                    <div class="date">
                                        <h3>{{ $exhibitions[$i]->date_start->format('d') }}</h3>
                                        <h6>{{ $exhibitions[$i]->date_start->translatedFormat('M Y') }}</h6>
                                        <hr style="margin-bottom: 5px;"> 
                                        <h3>{{ $exhibitions[$i]->date_finish->format('d') }}</h3>
                                        <h6>{{ $exhibitions[$i]->date_finish->translatedFormat('M Y') }}</h6>
                                    </div>
                                    <div class="cont">
                                        <div class="info">
                                            <h6><a href="{{ $exhibitions[$i]->location->url }}" target="_blank">{{ $exhibitions[$i]->location->name }}</a> / <span class="tags">{{ $exhibitions[$i]->hour_start->format('H:i') }} a {{ $exhibitions[$i]->hour_finish->format('H:i') }}</span></h6>
                                        </div>
                                        <h4>{{ $exhibitions[$i]->title }}</h4> <a href="{{ route('exhibition_show', $exhibitions[$i]->id) }}" class="more" data-splitting=""><span>Ver Mas</span></a> </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6 order2 valign animate-box" data-animate-effect="fadeInLeft">
                                <div class="content">
                                    <div class="date">
                                        <h3>{{ $exhibitions[$i]->date_start->format('d') }}</h3>
                                        <h6>{{ $exhibitions[$i]->date_start->translatedFormat('M Y') }}</h6>
                                        <hr style="margin-bottom: 5px;"> 
                                        <h3>{{ $exhibitions[$i]->date_finish->format('d') }}</h3>
                                        <h6>{{ $exhibitions[$i]->date_finish->translatedFormat('M Y') }}</h6>
                                    </div>
                                    <div class="cont">
                                        <div class="info">
                                            <h6><a href="{{ $exhibitions[$i]->location->url }}" target="_blank">{{ $exhibitions[$i]->location->name }}</a> / <span class="tags">{{ $exhibitions[$i]->hour_start->format('H:i') }} a {{ $exhibitions[$i]->hour_finish->format('H:i') }}</span></h6> 
                                        </div>
                                        <h4>{{ $exhibitions[$i]->title }}</h4> 
                                        <a href="{{ route('exhibition_show', $exhibitions[$i]->id) }}" class="more" data-splitting=""><span>Ver Mas</span></a> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 order1 animate-box" data-animate-effect="fadeInRight">
                                <div class="img">
                                    <a href="{{ route('exhibition_show', $exhibitions[$i]->id) }}">
                                        @if (count($exhibitions[$i]->images) == 0)
                                            <img src="{{ asset($exhibitions[$i]->location->image->location) }}" alt="{{ $exhibitions[$i]->location->image->title }}"> 
                                        @else
                                            <img src="{{ asset($exhibitions[$i]->images[0]->location) }}" alt="{{ $exhibitions[$i]->images[0]->title }}">   
                                        @endif
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                @endfor
				<div class="row mb-30 justify-content-center animate-box" data-animate-effect="fadeInUp">
                    <button class=" butn-dark mt-15 "><a href="{{ route('exhibition_index') }}"><span>Ver Mas</span></a></button>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection

@section('page-script')
<script>
    // Projects owlCarousel
    $('.colections .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: true,
        dots: true,
        autoplayHoverPause: true,
        smartSpeed: 500,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2
            },
        }
    });
</script>
@endsection