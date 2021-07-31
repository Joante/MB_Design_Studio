@extends('layouts/contentLayoutMaster') 

@section('title', 'Editar Post')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}" /> 
@endsection 

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link href='https://fonts.googleapis.com/css2?family=Didact+Gothic&family=Oswald:wght@200;300;400;500;600;700&display=swap' rel="stylesheet">
@endsection

@section('content')
<section>
    <div class="col-12 justify-content-center">
      <div class="card">
        <div class="card-header d-flex justify-content-center">
            <div class="col-md-6 d-flex justify-content-center">
                @error('error')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="card-body">
            <form class="form" method="POST" action="{{ route('blog_update', $post->id) }}" id="form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="name-column">Nombre *</label>
                            <input type="text" id="name-column" class="form-control @error('title') is-invalid @enderror" placeholder="Nombre" name="title" required value="{{ old('title', $post->title) }}">
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="category">Categoria *</label>
                            <select class="custom-select @error('category_id') is-invalid @enderror" id="category" name="category_id" required>
                                <option {{ old('category_id', $post->category->id) == '' ? "selected": "" }} value="">Seleccionar Categoria</option>
                                @foreach ($categories as $category)
                                    <option {{ old('category_id',$post->category->id) == $category->id ? "selected": "" }} value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12 d-flex align-items-center">
                        <div class="form-group">
                            @if (old('principal_page', $post->principal_page) == '1')
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
                    <div class="col-md-12 col-12 d-flex justify-content-center" id="old-image">
                        <div class="form-group">
                            <div class="row">
                                <span>Imagen de Portada: </span>
                                <button class="btn add-new btn-primary" id="edit-image" style="margin-left: auto;order: 2;" type="button"><span>Editar Imagen</span></button></a>
                            </div>
                            <div class="row" style=" margin-top: 20px;">
                                <img src="{{ asset($post->images[0]->location) }}" style="height:400px; width:800px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 d-flex align-items-center" id="new-image" style="display: none !important;">
                        <div class="form-group">
                            <label for="image-column">Imagen de Portada *</label>
                            <input type="file" id="image-column" class="form-control @error('image') is-invalid @enderror" name="image" placeholder="Seleccionar Imagen">
                            @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn add-new btn-primary" style="margin-left: auto;order: 2; height:60%;" id="btn-cancel" type="button"><span>Cancelar</span></button></a>
                    </div>
                    <div class="col-md-12">
                        <div id="snow-wrapper">
                            <div id="snow-container">
                                <label for="editor">Texto *</label>
                                <div id="editor" class="editor ql-container ql-snow">{!! old('text',$post->text) !!}</div>
                                <textarea hidden id="text" name="text"></textarea>
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
    <script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
    <script src="{{ asset(mix('js/image-resize.min.js')) }}"></script>
@endsection 

@section('page-script')
    <script src="{{ asset(mix('js/quill-image.js')) }}"></script>
    <script>
        var form = document.getElementById('form');
        form.addEventListener('submit', function(e){
            console.log(quill.getContents());
            e.preventDefault();
            if(quill.root.innerHTML != '<p><br></p>') {
                document.getElementById('text').innerHTML = quill.root.innerHTML;
            }
        });

        var editImage = document.getElementById('edit-image');
        editImage.addEventListener('click', function(){
            document.getElementById('old-image').setAttribute('style', 'display:none !important;');
            document.getElementById('new-image').setAttribute('style', 'display:flex;');
        });

        var btnCancel = document.getElementById('btn-cancel');
        btnCancel.addEventListener('click', function(){
            document.getElementById('image-column').value = '';
            document.getElementById('old-image').setAttribute('style', 'display:flex;');
            document.getElementById('new-image').setAttribute('style', 'display:none !important;');
        });
    </script>
@endsection