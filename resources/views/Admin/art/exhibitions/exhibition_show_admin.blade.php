@extends('layouts/contentLayoutMaster')

@section('title', $exhibition->title)

@section('vendor-style')
@endsection

@section('page-style')
  <link href='https://fonts.googleapis.com/css2?family=Didact+Gothic&family=Oswald:wght@200;300;400;500;600;700&display=swap' rel="stylesheet">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
@endsection

@section('content')
<section class="app-user-view">
  <!-- User Card & Plan Starts -->
  <div class="row">
    <!-- User Card starts-->
    <div class="col-xl-12 col-lg-12 col-md-12">
      <div class="card user-card">
        <div class="card-header">
          @if (session()->has('success'))
              <div class="col-md-12 d-flex justify-content-center">
                  <div class="alert alert-success">La exhibicion se actualizo con exito.</div>
              </div>
          @endif
          <a href="{{ route('exhibition_edit', $exhibition->id) }}" style="margin-left: auto;order: 2;"><button class="btn add-new btn-primary mt-50" type="button"><span>Editar Exhibicion</span></button></a> 
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-xl-6 col-lg-12 d-flex justify-content-center border-container-lg">
              <div class="user-info-wrapper">
                <div class="d-flex flex-wrap">
                  <div class="user-info-title">
                    <span class="card-text user-info-title font-weight-bold mb-0">Nombre</span>
                  </div>
                  <p class="card-text mb-0">{{ $exhibition->title }}</p>
                </div>
                <div class="d-flex flex-wrap my-50">
                  <div class="user-info-title">
                    <span class="card-text user-info-title font-weight-bold mb-0">Ubicacion</span>
                  </div>
                  <p class="card-text mb-0"><a href="{{ route('location_show', $exhibition->location->id) }}" target="_blank">{{ $exhibition->location->name }}</a></p>
                </div>
                <div class="d-flex flex-wrap my-50">
                    <div class="user-info-title">
                        <span class="card-text user-info-title font-weight-bold mb-0">Mostrar en la pagina principal</span>
                    </div>
                    <div class="custom-control custom-switch custom-control-inline">
                        <input type="checkbox" class="custom-control-input" disabled="" {{ $exhibition->principal_page ? "checked":"" }} id="customSwitch2">
                        <label class="custom-control-label" for="customSwitch2"></label>
                    </div>
                </div>
                <div class="d-flex flex-wrap my-50">
                  <div class="user-info-title">
                    <span class="card-text user-info-title font-weight-bold mb-0">Descripcion</span>
                  </div>
                  <p class="card-text mb-0">{{ $exhibition->description }}</p>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
              <div class="user-info-wrapper">
                <div class="d-flex flex-wrap">
                    <div class="user-info-title">
                        <span class="card-text user-info-title font-weight-bold mb-0">Fecha de Inicio</span>
                    </div>
                    <p class="card-text mb-0">{{ $exhibition->date_start->format('d/m/Y H:i') }}</p>
                </div>
                <div class="d-flex flex-wrap my-50">
                  <div class="user-info-title">
                    <span class="card-text user-info-title font-weight-bold mb-0">Fecha de Fin</span>
                  </div>
                  <p class="card-text mb-0">{{ $exhibition->date_finish->format('d/m/Y H:i') }}</p>
                </div>
                <div class="d-flex flex-wrap my-50">
                  <div class="user-info-title">
                      <span class="card-text user-info-title font-weight-bold mb-0">Hora de Inicio</span>
                  </div>
                  <p class="card-text mb-0">{{ $exhibition->hour_start->format('H:i') }}</p>
              </div>
              <div class="d-flex flex-wrap my-50">
                <div class="user-info-title">
                  <span class="card-text user-info-title font-weight-bold mb-0">Hora de Cierre</span>
                </div>
                <p class="card-text mb-0">{{ $exhibition->hour_finish->format('H:i') }}</p>
              </div>
              </div>
            </div>
            <div class="col-md-12 d-flex justify-content-center">
              <h4>Texto:</h4>
            </div>
            <div class="row d-flex justify-content-center">    
                <div class="col-md-12 d-flex justify-content-center" style="max-width: 80%;">
                    <div id="editor" class="ql-editor">{!! $exhibition->text !!}</div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /User Card Ends-->
  </div>
    <div class="col-md-12 justify-content-center">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Imagenes Asociadas</h4>
                <a href="{{ route('images_edit', ['exhibitions', $exhibition->id]) }}" style="margin-left: auto;order: 2;"><button class="btn add-new btn-primary mt-50" type="button"><span>Editar Imagenes</span></button></a> 
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($exhibition->images as $image)
                        <div class="col-md-4 col-6 profile-latest-img">
                            <img src="{{ asset($image->location) }}" class="img-fluid rounded" alt="{{ $image->title }}" style="max-height: 80%">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 d-flex justify-content-center">
      <a href="{{ url()->previous() }}" style="margin-top: 30px;"> 
          <button id="return" type="button" class="btn btn-primary btn-next waves-effect waves-float waves-light">
              <span class="align-middle d-sm-inline-block d-none">Volver</span>
          </button>
      </a>
    </div>
</section>
@endsection