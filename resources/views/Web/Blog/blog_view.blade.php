@extends('Web.Layout.master_layout')

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}" /> 
@endsection 

@section('content')
    <!-- Header Banner -->
    <section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ asset('img/1920x1128.jpg') }}"></section>

    <section class="pb-90">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <img src="{{ asset($post->images[0]->location) }}" class="mb-30" alt="">
                    <h2 class="section-title2">{{ $post->title }}</h2>
                    <div class="ql-editor">{!! $post->text !!}</div>
                </div>
            </div>
            <div class="bauen-comment-section">
                <div class="row">
                    <!-- Comment -->
                    <div class="col-md-7">
                        <div class="bauen-post-comment-wrap">
                            <div class="bauen-user-comment"> <img src="{{ asset('img/team/max_bilotti.jpg') }}" alt=""> </div>
                            <div class="bauen-user-content">
                                <h3>Maximiliano Bilotti<span> {{ $post->created }}</span></h3>
                                <p>Photography ultricies nibh non dolor maximus sceleue inte molliser faubs neque nec tincidunte aliquam erat volutpat. Praeser tempor malade yap. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection