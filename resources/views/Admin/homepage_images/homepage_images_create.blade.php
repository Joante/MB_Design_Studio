@extends('layouts/contentLayoutMaster') 

@section('title', 'Agregar Image de Homepage')

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')
<section>
    <div class="col-12 justify-content-center">
      <div class="card">
        <div class="card-header d-flex justify-content-center">
            <div class="col-md-6 d-flex justify-content-center">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <form class="form" method="POST" action="{{ route('homepage_images_store') }}" id="form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="title-column">Nombre *</label>
                            <input type="text" id="title-column" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre" name="name" required value="{{ old('name') }}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="description-column">Descripción *</label>
                            <textarea id="description-column" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Descripcion" required value="{{ old('description') }}">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="image-column">Imagen de Portada *</label>
                            <input type="file" id="image-column" class="form-control @error('images') is-invalid @enderror" name="images" placeholder="Seleccionar Imagen">
                            @error('images')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="hierarchy-column">Jerarquia</label>
                            <select class="custom-select" id="hierarchy-column" name="hierarchy">
                                <option {{ old('hierarchy') == '' ? "selected": "" }} value="">Seleccionar Jerarquia</option>
                                @for ($i = 1; $i < $hierarchy + 1; $i++)
                                    <option {{ old('hierarchy') == $i ? "selected": "" }} value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
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