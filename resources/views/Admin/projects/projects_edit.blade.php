@extends('layouts/contentLayoutMaster') 

@section('title', 'Editar Proyecto')

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <x-head.tinymce-config/>
@endsection

@section('content')
<section>
    <div class="col-12 justify-content-center">
      <div class="card">
        <div class="card-body">
            <form class="form" method="POST" action="{{ route('projects_update', $project->id) }}" id="form">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="name-column">Nombre *</label>
                            <input type="text" id="name-column" class="form-control @error('title') is-invalid @enderror" placeholder="Nombre" name="title" required value="{{ old('title', $project->title) }}">
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="service">Categoria *</label>
                            <select class="custom-select" id="service" name="service_id" required>
                                <option {{ old('service', $project->service->id) == '' ? "selected": "" }} value="">Seleccionar Categoria</option>
                                @foreach ($services as $service)
                                    <option {{ old('service', $project->service->id) == $service->id ? "selected": "" }} value="{{ $service->id }}">{{ $service->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="client-column">Cliente</label>
                            <input type="text" id="client-column" class="form-control @error('client') is-invalid @enderror" name="client" placeholder="Cliente" value="{{ old('client', $project->client) }}">
                            @error('client')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            @if (old('principal_page', $project->principal_page) == '1')
                                <input type="checkbox" class="custom-control-input" id="principal_page" name="principal_page" checked value=1>
                            @else
                                <input type="checkbox" class="custom-control-input" id="principal_page" name="principal_page" value=1>
                            @endif
                            <label class="custom-control-label" for="principal_page" style="margin-left: 21px;">Mostrar en la pagina principal</label>
                            @error('principal_page')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="location-column">Ubicacion</label>
                            <input type="text" id="location-column" class="form-control @error('location') is-invalid @enderror" name="location" placeholder="Ubicacion" value="{{ old('location', $project->location) }}">
                            @error('location')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="area-column">Superficie *</label>
                            <input type="number" id="area-column" required class="form-control @error('area') is-invalid @enderror" min="1" name="area" placeholder="Superficie" value="{{ old('area', $project->area) }}">
                            @error('area')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div id="snow-wrapper">
                            <div id="snow-container">
                                <label for="texteditor">Descripcion *</label>
                                <textarea id="texteditor" name="description">{!! old('description', $project->description) !!}</textarea>
                                @error('description')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
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
