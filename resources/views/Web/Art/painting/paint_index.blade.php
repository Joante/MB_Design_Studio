@extends('Web.Layout.master_layout')

@section('page-style')
    <link rel="canonical" href="https://mbdesignstudio.com.ar/art/paint" />
@endsection 

@section('content')
<!-- Header Banner -->
<section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ asset('img/1920x1128.jpg') }}"></section>
<section class="section-padding2">
    <div class="container">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <h2 class="section-title">Colecciónes <span>de Arte</span></h2>
            </div>
        </div>
        <div class="row mb-30">
            <div class="col-md-12 animate-box" data-animate-effect="fadeInUp">
                <h6 class="section-title2" style="text-align: center;font-size: 25px;"></h6>
            </div>
        </div>
        <section class="colections">
            <div class="container">
                @for ($i = 0; $i < count($colections); $i++)
                    @if ($i == 0 || $i % 2 == 0)
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
                                            <img class="projects-carousel" src="{{ asset($painting->images[0]->location) }}" alt="{{ $painting->images[0]->title }}"> 
                                        </div>
                                        <div class="con">
                                            <h5><a href="{{ route('paint_collection_index', $colections[$i]->id) }}">{{ $painting->name }}</a></h5>
                                            <div class="line"></div> <a href="{{ route('paint_collection_index', $colections[$i]->id) }}"><i class="ti-arrow-right"></i></a>
                                        </div>
                                    </div>
                                @endforeach        
                            </div>
                        </div>
                    @if ($i % 2 == 1)
                                <div class="col-md-12 animate-box " style="margin-top: 20px;" data-animate-effect="fadeInUp">
                                    <hr style="border-color: #fff;">
                                </div>    
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </section>
        <div class="row">
            <div class="col-md-12 text-center">
                <!-- Pagination -->
                <div class="bauen-pagination-wrap align-center mb-30 mt-30">
                    {{ $colections->links() }}
                </div>
            </div>
        </div>
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
