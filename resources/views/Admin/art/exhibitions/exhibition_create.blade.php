@extends('layouts/contentLayoutMaster') 

@section('title', 'Agregar Exhibicion')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection 

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <x-head.tinymce-config/>
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection

@section('content')
<section>
    <div class="col-12 justify-content-center">
      <div class="card">
        <div class="card-body">
            <form class="form" method="POST" action="{{ route('exhibition_store') }}" id="form">
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
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="location">Ubicacion *</label>
                            <select class="custom-select" id="location" name="location_id" required>
                                <option {{ old('location_id') == '' ? "selected": "" }} value="">Seleccionar Ubicacion</option>
                                @foreach ($locations as $location)
                                    <option {{ old('location_id') == $location->id ? "selected": "" }} value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="fp-date-time">Fecha de Inicio *</label>
                            <input type="text" id="fp-date-time" class="form-control flatpickr-date-time" name="date_start" placeholder="YYYY-MM-DD HH:MM" value="{{ old('date_start') }}" required/>
                            @error('date_start')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="fp-date-time-end">Fecha de Fin *</label>
                            <input type="text" id="fp-date-time-end" class="form-control flatpickr-date-time" name="date_finish" placeholder="YYYY-MM-DD HH:MM" value="{{ old('date_finish') }}" required/>
                            @error('date_finish')
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
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label class="form-label" for="hour_start">Hora de Inicio *</label>
                            <input type="text" id="hour_start" class="form-control flatpickr-time text-start flatpickr-input active" placeholder="HH:MM" readonly="readonly" name="hour_start" value="{{ old('hour_start') }}">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label class="form-label" for="hour_finish">Hora de Cierre *</label>
                            <input type="text" id="hour_finish" class="form-control flatpickr-time text-start flatpickr-input active" placeholder="HH:MM" readonly="readonly" name="hour_finish" value="{{ old('hour_finish') }}">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
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
                    <div class="col-md-12">
                        <div id="snow-wrapper">
                            <div id="snow-container">
                                <label for="texteditor">Texto *</label>
                                <textarea id="texteditor" name="text">{!! old('text') !!}</textarea>
                                @error('text')
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

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection 

@section('page-script')
    <script>
        var dateTimePicker = $('.flatpickr-date-time');
        var timePicker = $('.flatpickr-time');

        dateTimePicker.flatpickr({
            altInput: true,
            enableTime: true,
            altFormat: 'd/m/Y H:i',
            dateFormat: 'Y-m-d H:i',
            locale: {
                weekdays: {
                        shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                        longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado",
                        ],
                    },

                    months: {
                        shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dic",
                        ],
                        longhand: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre",
                        ],
                    },
                    time_24hr: true,
            },
        });
        timePicker.flatpickr({
            enableTime: true,
            noCalendar: true,
            locale: {
                time_24hr: true,
            }
        });
    </script>
@endsection