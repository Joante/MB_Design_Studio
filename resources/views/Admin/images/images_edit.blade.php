@extends('layouts/contentLayoutMaster') 

@section('title', 'Editar Imagenes') 

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
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-12 d-flex justify-content-center">
                            <a href="{{ route('services_show_admin', $modelId) }}" style="margin-right: 20px;"> 
                                <button id="return" type="button" class="btn btn-primary btn-next waves-effect waves-float waves-light">
                                    <span class="align-middle d-sm-inline-block d-none">Volver</span>
                                </button>
                            </a>
                            <button id="submitForm" type="button" class="btn btn-primary btn-next waves-effect waves-float waves-light" style="display:none;">
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

    var images = @json($images);

    fileUploader.dropzone({
        paramName: 'images', // The name that will be used to transfer the file
        maxFilesize: 5, // MB
        addRemoveLinks: true,
        thumbnailWidth: null,
        thumbnailHeight: null,
        dictRemoveFile: 'Borrar',
        acceptedFiles: 'image/*',
        maxFiles: 5,
        autoProcessQueue: false,
        parallelUploads: 5,
        init : function() {

            myDropzone = this;

            var deletedFiles = [];
            var modificadoAgregado = false;
            var btnSubmit = document.getElementById('submitForm');
            this.on("thumbnail", function(file, dataUrl) {
                $('.dz-image').last().find('img').attr({width: '100%', height: '100%'});
            }),
            this.on("addedfiles", function(file) {
                if(images.length != myDropzone.files.length)
                {
                    modificadoAgregado = true;
                }
                btnSubmit.setAttribute('style', 'display:block;');            
            });
            this.on("removedfile", function(file) {
                deletedFiles.push(file.id);
                if(myDropzone.files.length == 0) {
                    btnSubmit.setAttribute('style', 'display:none;');
                } else {
                    btnSubmit.setAttribute('style', 'display:block;');
                }
            });
            var form = document.getElementById('dpz-single-file');
            btnSubmit.addEventListener('click', function(){
                if(myDropzone.getRejectedFiles().length > 0) {
                    alert('Alguno de los archivos es de un tipo no permitido.');
                }else {
                    if(deletedFiles.length > 0) {
                        let _token   = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: "{{ route('images_delete', [$modelType, $modelId]) }}",
                            type:"POST",
                            data:{
                                deletedFiles:deletedFiles,
                                _token: _token
                            },
                            success:function(response){
                                console.log(response);
                                if(response != '"success"') {
                                    alert(response);
                                }else {
                                    myDropzone.processQueue();
                                    if (myDropzone.getUploadingFiles().length === 0 && myDropzone.getQueuedFiles().length === 0) {
                                        //window.location.href = "{{ route($modelType.'_show_admin', $modelId)}}";
                                    }
                                }
                            },
                        });
                    }else if(modificadoAgregado) {
                        myDropzone.processQueue();
                        if (myDropzone.getUploadingFiles().length === 0 && myDropzone.getQueuedFiles().length === 0) {
                            //window.location.href = "{{ route($modelType.'_show_admin', $modelId)}}";
                        }
                    }
                }
            });

            this.on('error', function(file, response) {
                $(file.previewElement).find('.dz-error-message').text(response.errors.images[0]);
            });
          
            images.forEach(element => {
                // Create the mock file:
                var mockFile = { name: element.name, id:element.id, size: element.size, type: 'image/'+element.extension, accepted: true};

                let location = "{{ asset('') }}"+element.location;
                this.files.push(mockFile);    // add to files array
                this.emit("addedfile", mockFile);
                this.createThumbnailFromUrl(mockFile,location);
                this.emit("thumbnail", mockFile, location);
                this.emit("complete", mockFile); 
            });            
        }
    });

    
</script>
@endsection