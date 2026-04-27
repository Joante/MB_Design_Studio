@extends('Web.Layout.master_layout')

@section('content')
    <section class="banner-header2 banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="{{ Helper::viteAsset('images/1920x1128.jpg') }}"></section>

    <section class="pb-90">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <img src="{{ Helper::viteAsset('images/404-image.png') }}" class="mb-30" alt="404">
                    <h2 class="section-title2 mb-10">Perdon, no pudimos encontrar esta pagina!</h2>
                    <p>La pagina que esta buscando fue movida, removida, renombrada o nunca existio.</p>
                    <div class="butn-dark mt-30 text-center"><a href="{{ route('home') }}"><span>Volver al home</span></a></div>
                </div>
            </div>
        </div>
    </section>
@endsection
