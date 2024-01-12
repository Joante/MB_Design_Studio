@extends('layouts/contentLayoutMaster')

@section('title', 'Imagen de Homepage')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('content')
<section>
  <div class="col-12 justify-content-center">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('homepage_images_create') }}" style="margin-left: auto;order: 2;"><button class="btn add-new btn-primary mt-50" type="button"><span>Agregar Imagen de Homepage</span></button></a> 
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Jerarquia</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($homepageImages as $homepageImage)
                  <tr>
                      <td>
                          <span class="font-weight-bold">{{$homepageImage->id}}</span>
                      </td>
                      <td>{{$homepageImage->title}}</td>
                      <td style="width: 65%;">{{ $homepageImage->description }}</a></td>
                      <td>{{ $homepageImage->hierarchy }}</td>
                      <td>
                        <a href="{{ route('homepage_images_show', $homepageImage->id) }}">
                          <button class="btn btn-icon btn-outline-info">
                            <i data-feather='search'></i>
                          </button>
                        </a>
                        <a href="{{ route('homepage_images_edit', $homepageImage->id) }}">
                          <button class="btn btn-icon btn-outline-warning" >
                          <i data-feather='edit-3'></i>
                          </button>
                        </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <button class="btn btn-icon btn-outline-danger" id="{{ $homepageImage->id }}">
                          <i data-feather='delete'></i>
                        </button>
                    </td>
                  </tr>      
                @endforeach    
            </tbody>
          </table>
        </div>
        <div class="col-md-12 d-flex justify-content-center">
          {{ $homepageImages->links('vendor/pagination/vuexy') }}
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
        btn[i].addEventListener('click', deleteConfirmation.bind(null,btn[i].id, 'homepage_images'));
      }
    </script>
@endsection