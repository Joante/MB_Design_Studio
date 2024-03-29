@extends('Web.Layout.master_layout')

@section('page-style')
@endsection 

@section('content')
    <!-- Header Banner -->
    <section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ asset('img/1920x1128.jpg') }}"></section>

    <section class="pb-90 bauen-blog">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @if (is_array($post->images))
                        <img src="{{ asset($post->images[0]->location) }}" class="mb-30 mt-30" alt="$post->images[0]->title">
                    @else
                        <img src="{{ asset($post->images->location) }}" class="mb-30 mt-30" alt="$post->images->title">
                    @endif 
                    <h2 class="section-title2">{{ $post->title }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="ql-editor" style="padding: 0px; height:auto;">{!! $post->text !!}</div>
                </div>
            </div>
            {{-- <div class="bauen-comment-section">
                <div class="row">
                    <!-- Comment -->
                    <div class="col-md-7">
                        <div class="bauen-post-comment-wrap">
                            <div class="bauen-user-comment"> <img src="{{ asset($location) }}" alt=""> </div>
                            <div class="bauen-user-content">
                                <h3>Maximiliano Bilotti<span> {{ $post->created }}</span></h3>
                                <p>{{ $description }} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
@endsection