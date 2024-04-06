@extends('layouts/contentLayoutMaster') 

@section('title', 'Editar Imagenes') 

@section('vendor-style')
@endsection 
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
  <link rel="stylesheet" href="{{ asset('vendors/css/jquery.ui.plupload/jquery.ui.plupload.css')}}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
@endsection

@section('content')
<section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @switch($modelType)
                        @case("services")
                        @case("paint")
                            <p class="card-text">Maximo 5 imagenes. Maximo 10 MB por imagen.</p>
                            @break
                        @case("projects")
                        @case("exhibitions")
                            <p class="card-text">Maximo 10 imagenes. Maximo 10 MB por imagen.</p>
                            @break
                        @default
                    @endswitch
                    <form action="{{ route('images_store', [$modelType, $modelId]) }}" method="POST" enctype="multipart/form-data" id="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div id="uploader">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('vendor-script')
@endsection 

@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('vendors/js/plupload/plupload.full.min.js') }}"></script>
    <script src="{{ asset('vendors/js/plupload/jquery.ui.plupload/jquery.ui.plupload.min.js') }}"></script>
    <script>
        var modelType = "{{ $modelType }}";
        var urlStore = "{{ route('images_update', [$modelType, $modelId]) }}";
        var urlDelete = "{{ route('images_delete', [$modelType, $modelId]) }}";
        var urlRedirect = "{{ route($modelType.'_show_admin', $modelId)}}";
        var images = @json($images);
        var filesRemovedId = [];
    </script>
    <script src="{{ asset('js/plupload-edit.js')}}"></script>
@endsection