@extends('layouts/contentLayoutMaster') 

@section('title', 'Adjuntar Imagenes') 

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}"/>
@endsection 
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-file-uploader.css')) }}">
@endsection

@section('content')
<section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p class="card-text">Maximo 5 imagenes. Maximo 5 MB por imagen.</p>
                    <form action="{{ route('images_store', [$modelType, $modelId]) }}" class="dropzone dropzone-area dz-clickable" method="POST" enctype="multipart/form-data" id="dpz-single-file">
                        @csrf
                        <div class="dz-message">Suelta los archivos aquí o haz clic para subirlos.</div>
                    </form>
                    <div class="row" style="margin-top: 30px; display:none;" id="divSubmit">
                        <div class="col-md-12 d-flex justify-content-center">
                            <button id="submitForm" type="button" class="btn btn-primary btn-next waves-effect waves-float waves-light">
                                <span class="align-middle d-sm-inline-block d-none">Guardar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
@endsection 

@section('page-script')
<script>
    Dropzone.autoDiscover = false;

    var fileUploader = $('#dpz-single-file');

    fileUploader.dropzone({
        paramName: 'images', // The name that will be used to transfer the file
        maxFilesize: 5, // MB
        addRemoveLinks: true,
        thumbnailHeight: null,
        thumbnailWidth: null,
        dictRemoveFile: 'Borrar',
        acceptedFiles: 'image/*',
        maxFiles: 5,
        autoProcessQueue: false,
        parallelUploads: 5,
        init : function() {

            myDropzone = this;

            this.on("thumbnail", function(file, dataUrl) {
                $('.dz-image').last().find('img').attr({width: '100%', height: '100%'});
            }),

            this.on("addedfiles", function(file) {
                document.getElementById('divSubmit').setAttribute('style', 'margin-top: 30px; display:flex;');            
            });

            this.on("removedfile", function(file) {
                if(myDropzone.getQueuedFiles().length == 0) {
                    document.getElementById('divSubmit').setAttribute('style', 'margin-top: 30px; display:none;');
                }
            });

            var btnSubmit = document.getElementById('submitForm');
            var form = document.getElementById('dpz-single-file');
            btnSubmit.addEventListener('click', function(){
                if(myDropzone.getRejectedFiles().length > 0) {
                    alert('Alguno de los archivos es de un tipo no permitido.');
                }else {
                    myDropzone.processQueue();
                }
            });

            this.on('error', function(file, response) {
                $(file.previewElement).find('.dz-error-message').text(response.errors.images[0]);
            });

            this.on("complete", function (file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    window.location.href = "{{ route($modelType.'_index_admin')}}";
                }
            });
        }
    });

    
</script>
@endsection