@extends('layouts/contentLayoutMaster')

@section('title', $painting->name)

@section('page-style')
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
                  <div class="alert alert-success">La obra se actualizo con exito.</div>
              </div>
          @endif
          <a href="{{ route('paint_edit', $painting->id) }}" style="margin-left: auto;order: 2;"><button class="btn add-new btn-primary mt-50" type="button"><span>Editar Obra de Arte</span></button></a> 
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-xl-6 col-lg-12 d-flex justify-content-center border-container-lg">
              <div class="user-info-wrapper">
                <div class="d-flex flex-wrap">
                  <div class="user-info-title">
                    <span class="card-text user-info-title font-weight-bold mb-0">Nombre</span>
                  </div>
                  <p class="card-text mb-0">{{ $painting->name }}</p>
                </div>
                <div class="d-flex flex-wrap my-50">
                  <div class="user-info-title">
                    <span class="card-text user-info-title font-weight-bold mb-0">Coleccion</span>
                  </div>
                  <p class="card-text mb-0"><a href="{{ route('paint_colection_show_admin', $painting->colection->id) }}" target="_blank">{{ $painting->colection->name }}</a></p>
                </div>
                <div class="d-flex flex-wrap">
                    <div class="user-info-title">
                        <span class="card-text user-info-title font-weight-bold mb-0">Tecnica</span>
                    </div>
                    <p class="card-text mb-0">{{ $painting->tecnique }}</p>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
              <div class="user-info-wrapper">
                <div class="d-flex flex-wrap">
                    <div class="user-info-title">
                        <span class="card-text user-info-title font-weight-bold mb-0">Ancho</span>
                    </div>
                    <p class="card-text mb-0">{{ $painting->width }}</p>
                </div>
                <div class="d-flex flex-wrap my-50">
                  <div class="user-info-title">
                    <span class="card-text user-info-title font-weight-bold mb-0">Alto</span>
                  </div>
                  <p class="card-text mb-0">{{ $painting->height }}</p>
                </div>
                <div class="d-flex flex-wrap my-50">
                    <div class="user-info-title">
                      <span class="card-text user-info-title font-weight-bold mb-0">Descripcion</span>
                    </div>
                    <p class="card-text mb-0">{{ $painting->description }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
              <div class="user-info-wrapper">
                
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
                <a href="{{ route('images_edit', ['paint', $painting->id]) }}" style="margin-left: auto;order: 2;"><button class="btn add-new btn-primary mt-50" type="button"><span>Editar Imagenes</span></button></a> 
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($painting->images as $image)
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