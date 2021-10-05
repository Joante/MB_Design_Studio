@extends('layouts/contentLayoutMaster')

@section('title', 'Exhibiciones')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('content')
<section>
  <div class="col-12 justify-content-center">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('exhibition_create') }}" style="margin-left: auto;order: 2;"><button class="btn add-new btn-primary mt-50" type="button"><span>Agregar Exhibicion</span></button></a> 
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Ubicacion</th>
                <th>Pagina Principal</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($exhibitions as $exhibition)
                  <tr>
                      <td>
                          <span class="font-weight-bold">{{$exhibition->id}}</span>
                      </td>
                      <td>{{$exhibition->title}}</td>
                      <td>{{$exhibition->location->name}}</td>
                      <td>
                        <div class="custom-control custom-switch custom-control-inline">
                            <input type="checkbox" class="custom-control-input" disabled="" {{ $exhibition->principal_page ? "checked":"" }} id="customSwitch2">
                            <label class="custom-control-label" for="customSwitch2"></label>
                        </div>
                      </td>
                      <td>{{ $exhibition->date_start->format('d/m/Y H:m') }}</td>
                      <td>{{ $exhibition->date_finish->format('d/m/Y H:m') }}</td>
                      <td>
                        <a href="{{ route('exhibition_show_admin', $exhibition->id) }}">
                          <button class="btn btn-icon btn-outline-info">
                            <i data-feather='search'></i>
                          </button>
                        </a>
                        <a href="{{ route('exhibition_edit', $exhibition->id) }}">
                          <button class="btn btn-icon btn-outline-warning" >
                          <i data-feather='edit-3'></i>
                          </button>
                        </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <button class="btn btn-icon btn-outline-danger" id="{{ $exhibition->id }}">
                          <i data-feather='delete'></i>
                        </button>
                    </td>
                  </tr>      
                @endforeach    
            </tbody>
          </table>
        </div>
        <div class="col-md-12 d-flex justify-content-center">
          {{ $exhibitions->links('vendor/pagination/vuexy') }}
        </div>
    </div>
  </div>
</section>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/sweerAlertDeleteConfirmation.js')) }}"></script>
    <script>
      var btn = document.getElementsByClassName('btn-outline-danger');
      for (let i = 0; i < btn.length; i++) {
        btn[i].addEventListener('click', deleteConfirmation.bind(null,btn[i].id, 'art/exhibition/list/admin'));
      }
    </script>
@endsection