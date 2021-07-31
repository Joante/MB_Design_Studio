@extends('layouts/contentLayoutMaster') 

@section('title', 'Editar Categoria de Blog')

@section('content')
<section>
    <div class="col-12 justify-content-center">
      <div class="card">
        <div class="card-body">
            <form class="form" method="POST" action="{{ route('blog_category_update', $category->id) }}" id="form">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="name-column">Nombre *</label>
                            <input type="text" id="name-column" class="form-control @error('title') is-invalid @enderror" placeholder="Nombre" name="title" required value="{{ old('title', $category->title) }}">
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="description">Descripcion</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center" style="margin-top: 30px;">
                    <button type="submit" class="btn btn-primary btn-next waves-effect waves-float waves-light">
                        <span class="align-middle d-sm-inline-block d-none">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
      </div>
    </div>
</section>
@endsection