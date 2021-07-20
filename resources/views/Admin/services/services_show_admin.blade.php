@extends('layouts/contentLayoutMaster')

@section('title', $service->title)
@section('content')
<section>
    <div class="col-md-12 justify-content-center">
        <div class="card">
            <div class="card-header">
                @if (isset($message))
                    <div class="col-md-12 d-flex justify-content-center">
                        <div class="alert alert-success">El servicio se actualizo con exito.</div>
                    </div>
                @endif
                <a href="{{ route('services_edit', $service->id) }}" style="margin-left: auto;order: 2;"><button class="btn add-new btn-primary mt-50" type="button"><span>Editar Servicio</span></button></a> 
            </div>
            <div class="card-body">
                <div class="row d-flex justify-content-center">
                    <div class="col-sm">
                        <div class="row d-flex justify-content-center align-items-center">
                            <h4>Icono:</h4>
                            <img src="{{ asset('img/icons/'.$service->icon->location) }}" style="margin-left: 10px;width: 80px;" alt="{{ $service->icon->title }}">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="row d-flex align-items-center" style="height: 100%;">
                            <h4>Descripcion:</h4>
                            <p class="card-text" style="margin-left:10px;">{{ $service->description }}</p>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 30px;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center">    
                                <h4>Texto:</h4>
                            </div>
                            <div class="col-md-12 d-flex justify-content-center">
                                {!! $service->text !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 justify-content-center">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Imagenes Asociadas</h4>
                <a href="{{ route('images_edit', ['services', $service->id]) }}" style="margin-left: auto;order: 2;"><button class="btn add-new btn-primary mt-50" type="button"><span>Editar Imagenes</span></button></a> 
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($service->images as $image)
                        <div class="col-md-4 col-6 profile-latest-img">
                            <img src="{{ asset($image->location) }}" class="img-fluid rounded" alt="{{ $image->title }}" style="max-height: 80%">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection