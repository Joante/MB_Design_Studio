@extends('layouts/contentLayoutMaster') 

@section('title', 'Agregar Servicio') 

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}" /> 
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}"/>
@endsection 

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link href='https://fonts.googleapis.com/css2?family=Didact+Gothic&family=Oswald:wght@200;300;400;500;600;700&display=swap' rel="stylesheet">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
    <style>
    [type=radio] { 
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

/* IMAGE STYLES */
[type=radio] + img {
  cursor: pointer;
}

/* CHECKED STYLES */
[type=radio]:checked + img {
  outline: 2px solid #b19777;
}
</style> 
@endsection 

@section('content')
<section class="horizontal-wizard">
<div class="bs-stepper horizontal-wizard-example linear">
  <div class="bs-stepper-header">
    <div class="step active" data-target="#account-details">
        <button type="button" class="step-trigger" aria-selected="true">
          <span class="bs-stepper-box">1</span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Detalles del Servicio</span>
            <span class="bs-stepper-subtitle">Especificaciones del servicio</span>
          </span>
        </button>
      </div>
      <div class="line">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right font-medium-2"><polyline points="9 18 15 12 9 6"></polyline></svg>
      </div>
      <div class="step" data-target="#personal-info">
        <button type="button" class="step-trigger" aria-selected="false" disabled="disabled">
          <span class="bs-stepper-box">2</span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Seleccionar Icono</span>
            <span class="bs-stepper-subtitle">Seleccionar o cargar icono</span>
          </span>
        </button>
      </div>
      <div class="line">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right font-medium-2"><polyline points="9 18 15 12 9 6"></polyline></svg>
      </div>
    </div>
    <div class="bs-stepper-content">
      <div id="account-details" class="content active dstepper-block">
        <form class="form" method="POST" action="{{ route('services_store') }}" id="form" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="name-column">Nombre *</label>
                        <input type="text" id="name-column" class="form-control @error('title') is-invalid @enderror" placeholder="Nombre" name="title" required value="{{ old('title') }}">
                        @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                      @if (old('principal_page') == '1')
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
                        <label for="description-column">Descripcion *</label>
                        <textarea id="description-column" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Descripcion" required value="{{ old('description') }}">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="snow-wrapper">
                        <div id="snow-container">
                            <label for="editor">Texto *</label>
                            <div id="editor" class="editor ql-container ql-snow">{!! old('text') !!}</div>
                            <textarea hidden id="text" name="text"></textarea>
                            @error('text')
                              <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        <div class="d-flex justify-content-between">
          <button type="button" class="btn btn-primary btn-next waves-effect waves-float waves-light" style="margin-top: 30px; margin-left: auto;order: 2;" id="firstStep">
            <span class="align-middle d-sm-inline-block d-none">Siguiente</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right align-middle ml-sm-25 ml-0"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </button>
        </div>
      </div>
      <div id="personal-info" class="content">
        <div class="row mt-20">
          <div class="form-group col-md-12 d-flex justify-content-center">
            @error('icon')
                <div class="alert alert-danger">El icono es requerido excepto que suba uno nuevo.</div>
            @enderror
          </div>
        </div>
        <div class="row mt-20">
          <div class="form-group col-md-12 d-flex justify-content-center">
            @foreach ($icons as $icon)
              <label style="margin-left: 30px;">
                @if (old('icon') == $icon->id)
                  <input type="radio" id="icon" name="icon" class="custom-control-input" value="{{ $icon->id }}" checked>
                @else
                  <input type="radio" id="icon" name="icon" class="custom-control-input" value="{{ $icon->id }}">
                @endif
                <img src="{{ asset('img/icons/'.$icon->location) }}" alt="{{ $icon->title }}" style="height: 42px; width:60px;"/>
              </label>
            @endforeach
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-12 d-flex justify-content-center">
            @if (old('newIcon') == 'on')
              <input type="checkbox" class="custom-control-input" id="newIcon" name="newIcon" checked>
            @else
              <input type="checkbox" class="custom-control-input" id="newIcon" name="newIcon">
            @endif
            <label class="custom-control-label" for="newIcon">Subir nuevo icono</label>
          </div>
        </div>
        <div class="row justify-content-center" style="display: none;" id="inputIcon">
          <div class="form-group col-md-12 d-flex justify-content-center">
            <div class="custom-file" style="width: 30%;">
              <input type="file" class="custom-file-input @error('iconFile') is-invalid @enderror" id="iconFile" name="iconFile">
              <label class="custom-file-label" for="iconFile">Seleccionar Archivo</label>
              @error('iconFile')
                  <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-between" style="margin-top: 30px;">
          <button type="button" class="btn btn-primary btn-prev waves-effect waves-float waves-light">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left align-middle mr-sm-25 mr-0"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span class="align-middle d-sm-inline-block d-none">Anterior</span>
          </button>
          <button type="submit" class="btn btn-primary btn-next waves-effect waves-float waves-light">
            <span class="align-middle d-sm-inline-block d-none">Guardar</span>
          </button>
        </div>
      </div>
    </form>
    </div>
  </div>
</section>
@endsection 

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
@endsection 

@section('page-script')
    
    {{-- Page js files --}}
    <script src="{{ asset(mix('js/quill-mb.js')) }}"></script>
<script>
    var newIcon = document.getElementById('newIcon');
    newIcon.addEventListener('click', function(e){
      if(newIcon.checked)
      {
        document.getElementById('inputIcon').setAttribute('style', 'display:flex;');
      }else 
      {
        document.getElementById('inputIcon').setAttribute('style', 'display:none;');
        document.getElementById('inputIcon').value = '';
      }
    });
    
    var firstStep = document.getElementById('firstStep');
    firstStep.addEventListener('click', function(e){
      if(quill.root.innerHTML != '<p><br></p>') {
        document.getElementById('text').innerText = quill.root.innerHTML;
      }
    });
      

    var bsStepper = document.querySelectorAll('.bs-stepper'),
    horizontalWizard = document.querySelector('.horizontal-wizard-example')

  // Adds crossed class
  if (typeof bsStepper !== undefined && bsStepper !== null) {
    for (var el = 0; el < bsStepper.length; ++el) {
      bsStepper[el].addEventListener('show.bs-stepper', function (event) {
        var index = event.detail.indexStep;
        var numberOfSteps = $(event.target).find('.step').length - 1;
        var line = $(event.target).find('.step');

        // The first for loop is for increasing the steps,
        // the second is for turning them off when going back
        // and the third with the if statement because the last line
        // can't seem to turn off when I press the first item. ¯\_(ツ)_/¯

        for (var i = 0; i < index; i++) {
          line[i].classList.add('crossed');

          for (var j = index; j < numberOfSteps; j++) {
            line[j].classList.remove('crossed');
          }
        }
        if (event.detail.to == 0) {
          for (var k = index; k < numberOfSteps; k++) {
            line[k].classList.remove('crossed');
          }
          line[0].classList.remove('crossed');
        }
      });
    }
  }

  // Horizontal Wizard
  // --------------------------------------------------------------------
  if (typeof horizontalWizard !== undefined && horizontalWizard !== null) {
    var numberedStepper = new Stepper(horizontalWizard)
      
    $(horizontalWizard)
      .find('.btn-next')
      .each(function () {
        $(this).on('click', function (e) {
          numberedStepper.next();
        });
      });

    $(horizontalWizard)
      .find('.btn-prev')
      .on('click', function () {
        numberedStepper.previous();
      });
  }
  window.onload = function() {
      if(newIcon.checked)
      {
        document.getElementById('inputIcon').setAttribute('style', 'display:flex;');
      }else 
      {
        document.getElementById('inputIcon').setAttribute('style', 'display:none;');
        document.getElementById('inputIcon').value = '';
      }
      if("{{ $errors->has('icon') }}" || "{{ $errors->has('iconFile') }}") {
        numberedStepper.next();
      }
    };
</script>
@endsection