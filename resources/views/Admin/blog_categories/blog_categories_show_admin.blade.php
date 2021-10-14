@extends('layouts/contentLayoutMaster')

@section('title', $category->title)

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
@endsection

@section('content')
<section class="app-user-view">
  <!-- User Card & Plan Starts -->
  <div class="row d-flex justify-content-center">
    <!-- User Card starts-->
    <div class="col-xl-8 col-lg-8 col-md-8">
      <div class="card user-card">
        <div class="card-header">
          @if (session()->has('success'))
              <div class="col-md-12 d-flex justify-content-center">
                  <div class="alert alert-success">La categoria se actualizo con exito.</div>
              </div>
          @endif
          <a href="{{ route('blog_category_edit', $category->id) }}" style="margin-left: auto;order: 2;"><button class="btn add-new btn-primary mt-50" type="button"><span>Editar Categoria</span></button></a> 
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-xl-6 col-lg-8 d-flex justify-content-center border-container-lg">
              <!--<div class="user-info-wrapper">-->
                <div class="d-flex flex-wrap">
                  <div class="user-info-title" style="margin-right: 10px;">
                    <span class="card-text user-info-title font-weight-bold mb-0">Nombre:</span>
                  </div>
                  <p class="card-text mb-0">{{ $category->title }}</p>
                </div>
              <!--</div>-->
            </div>
            <div class="col-xl-6 col-lg-8 d-flex justify-content-center border-container-lg">
                <div class="user-info-wrapper">
                    <div class="d-flex flex-wrap">
                        <div class="user-info-title">
                          <span class="card-text user-info-title font-weight-bold mb-0">Descripcion:</span>
                        </div>
                        <p class="card-text mb-0">{{ $category->description }}</p>
                      </div>
                </div>
            </div>
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


