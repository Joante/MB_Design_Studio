@extends('layouts/contentLayoutMaster') 

@section('title', 'Editar Ubicacion')

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')
<section>
    <div class="col-12 justify-content-center">
      <div class="card">
        <div class="card-header d-flex justify-content-center">
            <div class="col-md-6 d-flex justify-content-center">
                @error('error')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="card-body">
            <form class="form" method="POST" action="{{ route('location_update', $location->id) }}" id="form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="name-column">Nombre *</label>
                            <input type="text" id="name-column" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre" name="name" required value="{{ old('name',$location->name) }}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="url-column">Pagina Web *</label>
                            <input type="text" id="url-column" class="form-control @error('url') is-invalid @enderror" placeholder="Pagina Web" name="url" required value="{{ old('url',$location->url) }}">
                            @error('url')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="phone-column">Telefono</label>
                            <input type="number" minlength="8" id="phone-column" class="form-control @error('phone') is-invalid @enderror" placeholder="Telefono" name="phone" value="{{ old('phone',$location->phone) }}">
                            @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="image-column">Imagen de Portada</label>
                            <input type="file" id="image-column" class="form-control @error('image') is-invalid @enderror" name="image" placeholder="Seleccionar Imagen">
                            @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="adress-column">Direccion *</label>
                            <input type="text" id="adress-column" class="form-control @error('adress') is-invalid @enderror" placeholder="Direccion" name="adress" required value="{{ old('adress',$location->adress) }}">
                            @error('adress')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center" style="margin-top: 30px;">
                    <button type="submit" class="btn btn-primary btn-next waves-effect waves-float waves-light" id>
                        <span class="align-middle d-sm-inline-block d-none">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
      </div>
    </div>
</section>
@endsection