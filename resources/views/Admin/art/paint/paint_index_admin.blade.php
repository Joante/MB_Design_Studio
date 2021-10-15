@extends('layouts/contentLayoutMaster')

@section('title', 'Obras de Arte')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('content')
<section>
  <div class="col-12 justify-content-center">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('paint_create') }}" style="margin-left: auto;order: 2;"><button class="btn add-new btn-primary mt-50" type="button"><span>Agregar Obra</span></button></a> 
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th>@sortablelink('id', 'Id')</th>
                <th>@sortablelink('name', 'Nombre')</th>
                <th>Medidas</th>
                <th>@sortablelink('tecnique', 'Tecnica')</th>
                <th>@sortablelink('colection_id', 'Coleccion')</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($paintings as $painting)
                  <tr>
                      <td>
                          <span class="font-weight-bold">{{$painting->id}}</span>
                      </td>
                      <td>{{$painting->name}}</td>
                      <td>{{ $painting->width }} x {{ $painting->height }}</td>
                      <td>{{ $painting->tecnique }}</td>
                      <td><a href="{{ route('paint_colection_show_admin',$painting->colection->id) }}" target="_blank">{{ $painting->colection->name }} </a></td>
                      <td>
                        <a href="{{ route('paint_show_admin', $painting->id) }}">
                          <button class="btn btn-icon btn-outline-info">
                            <i data-feather='search'></i>
                          </button>
                        </a>
                        <a href="{{ route('paint_edit', $painting->id) }}">
                          <button class="btn btn-icon btn-outline-warning" >
                          <i data-feather='edit-3'></i>
                          </button>
                        </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <button class="btn btn-icon btn-outline-danger" id="{{ $painting->id }}">
                          <i data-feather='delete'></i>
                        </button>
                    </td>
                  </tr>      
                @endforeach    
            </tbody>
          </table>
        </div>
        <div class="col-md-12 d-flex justify-content-center">
          {{ $paintings->links('vendor/pagination/vuexy') }}
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
        btn[i].addEventListener('click', deleteConfirmation.bind(null,btn[i].id, 'art/painting/list/admin'));
      }
    </script>
@endsection