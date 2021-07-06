@extends('Web.Layout.master_layout')

@section('content')
    <!-- Header Banner -->
    <section class="banner-header banner-img valign bg-img bg-fixed" data-overlay-darkgray="5" data-background="img/1920x1128.jpg"></section>

    <!-- Contact -->
    <section class="section-padding2">
        <div class="container">
            <div class="row">
                <div class="col-md-12 animate-box" data-animate-effect="fadeInUp">
                    <h2 class="section-title">Contácte<span>nos</span></h2>
                </div>
            </div>
            <div class="row mb-90">
                <div class="col-md-4 mb-30 animate-box" data-animate-effect="fadeInUp">
                    <p><b>MB Design Studio</b></p>
                    <p>Esperamos su contacto ante cualquier duda o consulta para que nuestro equipo de asesores especializados pueda ayudarlo.</p>
                </div>
                <div class="col-md-4 mb-30 animate-box" data-animate-effect="fadeInUp">
                    <p><b>Detalles de Contacto</b></p>
                    <p><b>Telefono :</b> +1 203-123-0606</p>
                    <p><b>Email :</b> maxbilotti.designstudio@gmail.com</p>
                </div>
                <div class="col-md-4 animate-box" data-animate-effect="fadeInUp">
                    @if(Session::has('success'))
                        <div>
                            <h6 class="section-title2" style="font-size: 25px;">{{ Session::get('success') }}</h6>
                            @php
                                Session::forget('success');
                            @endphp
                        </div>
                    @endif
                    <p><b>Formulario de Contacto</b></p>
                    <form method="POST" action="{{ route('contact-send') }}" class="row">
                        @csrf
                        <div class="col-md-12">
                            <input type="text" name="name" id="name" placeholder="Nombre Completo" value="{{ old('name')}}" required>
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <input type="email" name="email" id="email" placeholder="Email" required value="{{ old('email')}}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <textarea name="message" id="message" cols="40" rows="4" placeholder="Su Mensaje" required>{{ old('message') }}</textarea>
                            @if ($errors->has('message'))
                                <span class="text-danger">{{ $errors->first('message') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="buttn-dark mt-15"><span>Enviar</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection