@extends('Web.Layout.master_layout')

@section('content')
    <!-- Slider -->
    <header class="header slider-fade">
        <div class="owl-carousel owl-theme">
            <!-- The opacity on the image is made with "data-overlay-dark="number". You can change it using the numbers 0-9. -->
            <div class="text-left item bg-img" data-overlay-dark="3" data-background="img/slider.jpeg">
                <div class="v-bottom caption">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="o-hidden">
                                    <h1>Interiorismo</h1>
                                    <hr>
                                    <p>Buscamos transmitir diferentes sensaciones y mejorar la calidad de vida
                                        <br>a traves de diseños esteticos y funcionales que crean experiencias unicas.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-left item bg-img" data-overlay-dark="4" data-background="img/slider_1.jpeg">
                <div class="v-bottom caption">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="o-hidden">
                                    <h1>Modelado</h1>
                                    <hr>
                                    <p>Creamos e idealizamos visualizaciones realistas de los propotipos
                                        <br>con personalización, expresión y atención al detalle.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-left item bg-img" data-overlay-dark="4" data-background="img/slider_paisajismo.jpg">
                <div class="v-bottom caption">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="o-hidden">
                                    <h1>Paisajismo</h1>
                                    <hr>
                                    <p>Diseñamos, materializamos y conservamos distintos tipos
                                        <br>de espacios exteriores y espacios verdes.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-left item bg-img" data-overlay-dark="3" data-background="img/slider_arte2.jpg">
                <div class="v-bottom caption">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="o-hidden">
                                    <h1>Arte</h1>
                                    <hr>
                                    <p>Composiciónes geométricas, elegantes y monocromáticas
                                        <br>que aportan calma, elegancia y contemporaneidad.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                    <div class="position-re o-hidden"> <img class="projects-carousel" src="{{ asset('img/proyects/azucena/azucena_1.jpeg') }}" alt=""> </div>
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
                                    <a href="{{ route('services_view', $service->id) }}"> <img src="{{ asset('img/icons/'.$service->icon->location) }}" alt="$service->icon->title">
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
                        <div class="col-md-3">
                        <div class="item">
                            <a href="art.html"> <img src="img/icons/arte_logo.png" style="margin-left: -10px;" alt="">
                                <h5>Arte</h5>
                                <div class="line"></div>
                                <p>Comercializamos y realizamos exposiciones de nuestra colección de obras arte, con una estética minimalista y contemporánea.</p>
                                <div class="numb">04</div>
                            </a>
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