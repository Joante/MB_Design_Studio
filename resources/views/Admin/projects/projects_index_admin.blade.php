@extends('layouts/contentLayoutMaster')

@section('title', 'Proyectos')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('content')
<section>
  <div class="col-12 justify-content-center">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('projects_create') }}" style="margin-left: auto;order: 2;"><button class="btn add-new btn-primary mt-50" type="button"><span>Agregar Proyecto</span></button></a> 
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th>@sortablelink('id', 'Id')</th>
                <th>@sortablelink('title', 'Nombre')</th>
                <th>@sortablelink('service_id', 'Categoria')</th>
                <th>@sortablelink('client', 'Cliente')</th>
                <th>@sortablelink('area', 'Superficie')</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                  <tr>
                      <td>
                          <span class="font-weight-bold">{{$project->id}}</span>
                      </td>
                      <td>{{$project->title}}</td>
                      <td>{{$project->service->title}}</td>
                      <td>{{$project->client}}</td>
                      <td>{{$project->area}} m2</td>
                      <td>
                        <a href="{{ route('projects_show_admin', $project->id) }}">
                          <button class="btn btn-icon btn-outline-info">
                            <i data-feather='search'></i>
                          </button>
                        </a>
                        <a href="{{ route('projects_edit', $project->id) }}">
                          <button class="btn btn-icon btn-outline-warning" >
                          <i data-feather='edit-3'></i>
                          </button>
                        </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <button class="btn btn-icon btn-outline-danger" id="{{ $project->id }}">
                          <i data-feather='delete'></i>
                        </button>
                    </td>
                  </tr>      
                @endforeach    
            </tbody>
          </table>
        </div>
        <div class="col-md-12 d-flex justify-content-center">
          {{ $projects->links('vendor/pagination/vuexy') }}
        </div>
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
        btn[i].addEventListener('click', deleteConfirmation.bind(null,btn[i].id, 'projects'));
      }
    </script>
@endsection