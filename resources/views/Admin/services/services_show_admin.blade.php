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
                <div class="row d-flex justify-content-center" style="margin-bottom: 30px;">
                <div class="col-md-4 d-flex justify-content-center align-items-center">
                    <h4>Icono:</h4>
                    <img src="{{ asset('img/icons/'.$service->icon->location) }}" style="margin-left: 10px;width: 80px;" alt="{{ $service->icon->title }}">
                </div>
                <div class="col-md-4 d-flex justify-content-center align-items-center">
                    <div class="custom-control custom-switch custom-control-inline">
                        @if ($service->principal_page == 1)
                            <input type="checkbox" class="custom-control-input" disabled="" checked="" id="customSwitch2">
                        @else
                            <input type="checkbox" class="custom-control-input" disabled="" id="customSwitch2">
                        @endif
                        <label class="custom-control-label" for="customSwitch2">Mostrar en la pagina principal</label>
                    </div>
                </div>
                </div>
                <h4>Descripcion:</h4>
                <p class="card-text" style="margin-bottom: 30px;">{{ $service->description }}</p>
                <h4>Texto:</h4>
                <p class="card-text mb-2">{!! $service->text !!}</p>
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