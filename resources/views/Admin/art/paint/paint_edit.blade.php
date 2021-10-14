@extends('layouts/contentLayoutMaster') 

@section('title', 'Editar Obra de Arte')

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')
<section>
    <div class="col-12 justify-content-center">
      <div class="card">
        <div class="card-body">
            <form class="form" method="POST" action="{{ route('paint_update', $painting->id) }}" id="form">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="name-column">Nombre *</label>
                            <input type="text" id="name-column" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre" name="name" required value="{{ old('name', $painting->name) }}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="colection">Coleccion *</label>
                            <select class="custom-select" id="colection" name="art_colection_id" required>
                                <option {{ old('art_colection_id', $painting->art_colection_id) == '' ? "selected": "" }} value="">Seleccionar Coleccion</option>
                                @foreach ($colections as $colection)
                                    <option {{ old('art_colection_id', $painting->art_colection_id) == $colection->id ? "selected": "" }} value="{{ $colection->id }}">{{ $colection->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="tecnique-column">Tecnica *</label>
                            <input type="text" id="tecnique-column" class="form-control @error('tecnique') is-invalid @enderror" name="tecnique" placeholder="Tecnica" value="{{ old('tecnique', $painting->tecnique) }}" required>
                            @error('tecnique')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="description-column">Descripcion</label>
                            <textarea id="description-column" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Descripcion">{{ old('description', $painting->description) }}</textarea>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="width-column">Ancho *</label>
                            <input type="number" step="0.01" min="0.01" id="width-column" class="form-control @error('width') is-invalid @enderror" name="width" placeholder="Ancho (Metros)" value="{{ old('width', $painting->width) }}" required>
                            @error('width')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="height-column">Alto *</label>
                            <input type="number" step="0.01" min="0.01" id="height-column" class="form-control @error('height') is-invalid @enderror" name="height" placeholder="Alto (Metros)" value="{{ old('height', $painting->height) }}" required>
                            @error('height')
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