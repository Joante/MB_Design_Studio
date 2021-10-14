@extends('layouts/contentLayoutMaster')

@section('title', $post->title)

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}" /> 
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
  <link href='https://fonts.googleapis.com/css2?family=Didact+Gothic&family=Oswald:wght@200;300;400;500;600;700&display=swap' rel="stylesheet">
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
                        <div class="alert alert-success">El post se actualizo con exito.</div>
                    </div>
                @endif
                <a href="{{ route('blog_edit', $post->id) }}" style="margin-left: auto;order: 2;"><button class="btn add-new btn-primary mt-50" type="button"><span>Editar Post</span></button></a> 
            </div>
            <div class="card-body">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-6 col-lg-12 d-flex justify-content-center border-container-lg">
                      <div class="user-info-wrapper">
                        <div class="d-flex flex-wrap">
                          <div class="user-info-title">
                            <span class="card-text user-info-title font-weight-bold mb-0">Nombre</span>
                          </div>
                          <p class="card-text mb-0">{{ $post->title }}</p>
                        </div>
                        <div class="d-flex flex-wrap my-50">
                          <div class="user-info-title">
                            <span class="card-text user-info-title font-weight-bold mb-0">Categoria</span>
                          </div>
                          <p class="card-text mb-0">{{ $post->category->title }}</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                      <div class="user-info-wrapper">
                        <div class="d-flex flex-wrap">
                          <div class="user-info-title" style="width:30%;">
                            <span class="card-text user-info-title font-weight-bold mb-0">Mostrar en la pagina principal</span>
                          </div>
                          <div class="custom-control custom-switch custom-control-inline">
                            <input type="checkbox" class="custom-control-input" disabled="" {{ $post->principal_page ? "checked":"" }} id="customSwitch2">
                            <label class="custom-control-label" for="customSwitch2"></label>
                          </div>
                        </div>
                        <div class="d-flex flex-wrap my-50">
                          
                        </div>
                      </div>
                    </div>
                  </div>
            <div class="col-md-12 d-flex justify-content-center">
                <h4>Texto:</h4>
            </div>
            <div class="row d-flex justify-content-center">    
                <div class="col-md-12 d-flex justify-content-center" style="max-width: 80%;">
                    <div id="editor" class="ql-editor">{!! $post->text !!}</div>
                </div>
            </div>
            <div class="col-md-12 d-flex justify-content-center" style="margin-top: 30px;">
                <h4>Imagen de Portada</h4>
            </div>
            <div class="col-md-12 d-flex justify-content-center">
                @foreach ($post->images as $image)
                  @if($image != null)
                   <img src="{{ asset($image->location) }}" class="img-fluid rounded" alt="{{ $image->title }}" style="max-width: 40%">
                  @endif  
                 @endforeach
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
      </div>
    </div>
</section>
@endsection