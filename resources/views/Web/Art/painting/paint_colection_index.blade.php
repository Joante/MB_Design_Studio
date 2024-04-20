@extends('Web.Layout.master_layout')

@section('content')
<!-- Header Banner -->
<section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ asset('img/1920x1128.jpg') }}"></section>
<section class="section-padding2">
    <div class="container">
        <div class="row">
            <div class="col-md-12 d-flex animate-box justify-content-center" data-animate-effect="fadeInUp">
                <h2 class="section-title"><span>{{ $colection->name }}</span></h2> 
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 d-flex justify-content-center">
                <p>{{ $colection->description }}</p>
            </div>
        </div>
        <section class="colections">
            <div class="container">
                <div class="col-md-12 animate-box" data-animate-effect="fadeInUp" style="margin-bottom: 30px;">
                    <div class="row">
                            <div class="owl-carousel owl-theme">
                                @if (count($paintings) > 0)
                                    @foreach ($paintings as $painting)
                                        <div class="item">
                                            <div class="position-re o-hidden"> 
                                                @if (count($painting->images)> 0)
                                                    <img class="paintings-carousel" src="{{ asset($painting->images[0]->location) }}" alt="{{ $painting->images[0]->title }}"> 
                                                @else
                                                    <img class="paintings-carousel" src="{{ asset('public/img/600x600.jpg') }}" alt="Not Found">     
                                                @endif
                                                 
                                            </div>
                                            <div class="con">
                                                <h5><a href="{{ route('paint_show', $painting->id) }}">{{ $painting->name }}</a></h5>
                                                <div class="line"></div> <a href="{{ route('paint_show', $painting->id) }}"><i class="ti-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif        
                            </div>
                    </div>
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
                items: 3
            },
        }
    });
</script>
@endsection
