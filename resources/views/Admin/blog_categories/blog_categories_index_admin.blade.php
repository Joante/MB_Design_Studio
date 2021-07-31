@extends('layouts/contentLayoutMaster')

@section('title', 'Categorias de Blog')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('content')
<section>
  <div class="col-12 justify-content-center">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('blog_category_create') }}" style="margin-left: auto;order: 2;"><button class="btn add-new btn-primary mt-50" type="button"><span>Agregar Categoria</span></button></a> 
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                  <tr>
                      <td>
                          <span class="font-weight-bold">{{$category->id}}</span>
                      </td>
                      <td>{{$category->title}}</td>
                      <td>{{$category->description}}</td>
                      <td>
                        <a href="{{ route('blog_category_show', $category->id) }}">
                          <button class="btn btn-icon btn-outline-info">
                            <i data-feather='search'></i>
                          </button>
                        </a>
                        <a href="{{ route('blog_category_edit', $category->id) }}">
                          <button class="btn btn-icon btn-outline-warning" >
                          <i data-feather='edit-3'></i>
                          </button>
                        </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <button class="btn btn-icon btn-outline-danger" id="{{ $category->id }}">
                          <i data-feather='delete'></i>
                        </button>
                    </td>
                  </tr>      
                @endforeach    
            </tbody>
          </table>
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
        btn[i].addEventListener('click', deleteConfirmation.bind(null,btn[i].id, 'blog/category'));
      }
    </script>
@endsection