@extends('Web.Layout.master_layout')

@section('content')
    <!-- Header Banner -->
    <section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ asset('img/1920x1128.jpg') }}"></section>

    <!-- Blog  -->
    <section class="bauen-blog section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="section-title">Nuestro <span>Blog</span></h2>
                </div>
                <div class="col-md-3 ml-auto mr-0 animate-box" data-animate-effect="fadeInUp">
                    <h6 class="section-title2"><span style="font-size: 25px;">Ultimos Posteos</span></h6>
                </div>
            </div>
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-6">
                        <div class="item">
                            <div class="position-re o-hidden"> <img src="{{ asset($post->images[0]->location) }}" alt="$post->images[0]->title"> </div>
                            <div class="con">
                                <span class="category">
                                    <a href="{{ route('blog_view_category', $post->category->id) }}">{{ $post->category->title }}</a> - {{ $post->created }}
                                </span>
                                <h5><a href="{{ route('blog_view', $post->id) }}">{{ $post->title }}</a></h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <!-- Pagination -->
                    <div class="bauen-pagination-wrap align-center mb-30 mt-30">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection