@extends('Web.Layout.master_layout')

@section('content')
    <!-- Slider -->
    <header class="header slider-fade">
        <div class="owl-carousel owl-theme">
            <!-- The opacity on the image is made with "data-overlay-dark="number". You can change it using the numbers 0-9.  -->
            @foreach ($homepageImages as $homepageImage)
                <div class="text-left item bg-img" data-overlay-dark="3" data-background="{{ $homepageImage != null ? asset($homepageImage->image->location) : asset('img/1920x1128.jpg') }}">
                    <div class="v-bottom caption">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="o-hidden">
                                        <h1>{{ $homepageImage->title }}</h1>
                                        <hr>
                                        <p>{{ $homepageImage->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </header>
    <!-- Content -->
    <div class="content-wrapper">
        <!-- Lines -->
        <section class="content-lines-wrapper">
            <div class="content-lines-inner">
                <div class="content-lines"></div>
            </div>
        </section>
        <!-- About -->
        <section class="about section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-30 animate-box" data-animate-effect="fadeInUp">
                        <h2 class="section-title">About <span>MB</span></h2>
                        <p>Somos un estudio especializado en la realización y ejecución de proyectos de arquitectura interior, exterior, residencial y comercial.</p>
                        <p>Con base en Buenos Aires. Reconocido por nuestro estilo único, elegante y contemporáneo.</p>
                        <p>Ademas ofrecemos una exclusiva colección de obras de arte para elevar el estilo de multiples y diversos ambientes. </p>
                    </div>
                    <div class="col-md-6 animate-box" data-animate-effect="fadeInUp">
                        <div class="about-img">
                            <div class="img"> <img src="img/1100x750.jpg" class="img-fluid" alt=""> </div>
                            <div class="about-img-2 about-buro">Video Promocional</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Projects -->
        <section class="projects section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-title">Nuestros <span>Proyectos</span></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="owl-carousel owl-theme">
                            @foreach ($projects as $project)
                                <div class="item">
                                    <div class="position-re o-hidden"> 
                                        @if ($project->images != null && count($project->images) > 0 && file_exists(public_path($project->images[0]->location)))
                                            <img class="projects-carousel" src="{{ asset($project->images[0]->location) }}" alt="{{ $project->images[0]->title }}">
                                        @else
                                            <img class="projects-carousel" src="{{ asset('img/600x600.jpg') }}" alt="Image not found"> 
                                        @endif
                                    </div>
                                    <div class="con">
                                        <h5><a href="{{ route('projects_view', $project->id) }}">{{ $project->title }}</a></h5>
                                        <div class="line"></div> <a href="{{ route('projects_view', $project->id) }}"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Services -->
        <section class="services section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-title">Nuestros <span>Servicios</span></h2>
                    </div>
                </div>
                <div class="row">
                    @foreach ($services as $key => $service)
                        @if ($service->principal_page)
                            <div class="col-md-3">
                                <div class="item">
                                    <a href="{{ route('services_view', $service->id) }}"> 
                                        @if (file_exists(public_path('img/icons/'.$service->icon->location)))
                                            <img src="{{ asset('img/icons/'.$service->icon->location) }}" alt="$service->icon->title">
                                        @endif
                                        <h5>{{ $service->title }}</h5>
                                        <div class="line"></div>
                                        <p>{{ $service->description }}</p>
                                        <br>
                                        <div class="numb">0{{ $key+1 }}</div>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
         <!-- Art -->
         <section class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-title">Nuestra <span>Arte</span></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 art_colections">
                                <section class="bauen-blog2">
                                    <div class="col-md-12">
                                        <div class="row mb-30">
                                            <div class="col-md-12">
                                                <h6 class="section-title2" style="text-align: center;font-size: 25px;">Nuestras exhibiciones</h6>
                                            </div>
                                        </div>
                                        <div class="owl-carousel owl-theme">
                                            @foreach ($exhibitions as $exhibition)    
                                                <div class="item">
                                                    <div class="row">
                                                        <div class="col-md-6 animate-box position-re o-hidden" data-animate-effect="fadeInLeft">
                                                            <div class="img left">
                                                                <a href="{{ route('exhibition_show', $exhibition->id) }}">
                                                                    @if (count($exhibition->images) == 0)
                                                                        @if ($exhibition->location->image != null && file_exists(public_path($exhibition->location->image->location)))
                                                                            <img src="{{ asset($exhibition->location->image->location) }}" alt="{{ $exhibition->location->image->title }}"> 
                                                                        @else
                                                                            <img src="{{ asset('img/600x600.jpg') }}" alt="Image not found"> 
                                                                        @endif
                                                                    @elseif ($exhibition->images != null && count($exhibition->images) > 0 && file_exists(public_path($exhibition->images[0]->location)))
                                                                        <img src="{{ asset($exhibition->images[0]->location) }}" alt="{{ $exhibition->images[0]->title }}">   
                                                                    @else
                                                                        <img src="{{ asset('img/600x600.jpg') }}" alt="Image not found">         
                                                                    @endif
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 valign animate-box" data-animate-effect="fadeInRight" style="padding-left: 0px;">
                                                            <div class="content" style="padding: 0px;">
                                                                <div class="date">
                                                                    <h3>{{ $exhibition->date_start->format('d') }}</h3>
                                                                    <h6>{{ $exhibition->date_start->translatedFormat('M Y') }}</h6>
                                                                    <hr style="margin-bottom: 5px;"> 
                                                                    <h3>{{ $exhibition->date_finish->format('d') }}</h3>
                                                                    <h6>{{ $exhibition->date_finish->translatedFormat('M Y') }}</h6>
                                                                </div>
                                                                <div class="cont">
                                                                    <div class="info">
                                                                        <h6><a href="{{ $exhibition->location->url }}" target="_blank">{{ $exhibition->location->name }}</a> <span class="tags">{{ $exhibition->hour_start->format('H:i') }} a {{ $exhibition->hour_finish->format('H:i') }}</span></h6>
                                                                    </div>
                                                                    <h4 style="word-break: break-word; font-size:17px;">{{ $exhibition->title }}</h4> <a href="{{ route('exhibition_show', $exhibition->id) }}" class="more" data-splitting=""><span>Ver Mas</span></a> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-md-6">
                                <section class="colections">
                                    <div class="container">
                                        <div class="row mb-30">
                                            <div class="col-md-12">
                                                <h6 class="section-title2" style="text-align: center;font-size: 25px;">Nuestras colecciones</h6>
                                            </div>
                                        </div>
                                        <div class="owl-carousel owl-theme">
                                            @foreach ($colections as $colection)    
                                                <div class="item">
                                                    <div class="position-re o-hidden"> 
                                                        @if ($colection->image != null && file_exists(public_path($colection->image->location)))
                                                            <img class="projects-carousel" src="{{ asset($colection->image->location) }}" alt="{{ $colection->image->title }}"> 
                                                        @else
                                                            <img class="projects-carousel" src="{{ asset('img/600x600.jpg') }}" alt="Image not found"> 
                                                        @endif

                                                    </div>
                                                    <div class="con">
                                                        <h5><a href="{{ route('paint_collection_index', $colection->id) }}">{{ $colection->name }}</a></h5>
                                                        <div class="line"></div> <a href="{{ route('paint_collection_index', $colection->id) }}"><i class="ti-arrow-right"></i></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Blog -->
        <section class="bauen-blog section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-title">Nuestros <span>Escritos</span></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="owl-carousel owl-theme">
                            @foreach ($posts as $post)    
                                <div class="item">
                                    <div class="position-re o-hidden"> <img src="img/1100x750.jpg" alt=""> </div>
                                    <div class="con">
                                        <span class="category">
                                            <a href="{{ route('blog_view_category', $post->category->id) }}">{{ $post->category->title }} </a> -  {{ $post->created }}
                                        </span>
                                        <h5><a href="{{ route('blog_view', $post->id) }}">{{ $post->title }}</a></h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

@section('page-script')
<script>
    // Exhibtions owlCarousel
    $('.bauen-blog2 .owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        mouseDrag: true,
        autoplay: false,
        dots: true,
        autoplayHoverPause: true,
        smartSpeed: 700,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
        }
    });
    // Colections owlCarousel
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