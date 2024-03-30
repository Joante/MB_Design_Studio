@extends('layouts/contentLayoutMaster')

@section('title', $location->name)

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
                  <div class="alert alert-success">La ubicacion se actualizo con exito.</div>
              </div>
          @endif
          <a href="{{ route('location_edit', $location->id) }}" style="margin-left: auto;order: 2;"><button class="btn add-new btn-primary mt-50" type="button"><span>Editar Ubicacion</span></button></a> 
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-xl-6 col-lg-12 d-flex justify-content-center border-container-lg">
              <div class="user-info-wrapper">
                <div class="d-flex flex-wrap">
                  <div class="user-info-title">
                    <span class="card-text user-info-title font-weight-bold mb-0">Nombre</span>
                  </div>
                  <p class="card-text mb-0">{{ $location->name }}</p>
                </div>
                <div class="d-flex flex-wrap my-50">
                  <div class="user-info-title">
                    <span class="card-text user-info-title font-weight-bold mb-0">Pagina Web</span>
                  </div>
                  <p class="card-text mb-0">{{ $location->url }}</p>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
              <div class="user-info-wrapper">
                <div class="d-flex flex-wrap my-50">
                    <div class="user-info-title">
                      <span class="card-text user-info-title font-weight-bold mb-0">Telefono</span>
                    </div>
                    <p class="card-text mb-0">{{ $location->phone }}</p>
                  </div>
                <div class="d-flex flex-wrap my-50">
                  <div class="user-info-title">
                    <span class="card-text user-info-title font-weight-bold mb-0">Direccion</span>
                  </div>
                  <p class="card-text mb-0">{{ $location->adress }}</p>
                </div>
              </div>
            </div>
            @if ($location->images)
              <div class="col-md-12 d-flex justify-content-center" style="margin-top: 30px;">
                  <h4>Imagen de Portada</h4>
              </div>
              <div class="col-md-12 d-flex justify-content-center">
                  <img src="{{ asset($location->images->location) }}" class="img-fluid rounded" alt="{{ $location->images->title }}" style="max-width: 40%">
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    <!-- /User Card Ends-->
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