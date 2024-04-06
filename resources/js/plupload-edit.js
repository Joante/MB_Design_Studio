$(function() {
    var maxFiles;
    switch(modelType) {
        case "services":
        case "paint": 
            maxFiles = 5;
            break;
        case "projects":
        case "exhibitions":
            maxFiles = 10;
            break;
    }
    var browse = false;
    var filesUploaded = 0;
    var uploader = $("#uploader").plupload({
        
        url: urlStore,

        // Maximum file size
        max_file_size: '10mb',

        // User can upload no more then 20 files in one go (sets multiple_queues to false)
        max_file_count: maxFiles,
        
        multipart_params: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
        },

        // Specify what files to browse for
        filters: {
            mime_types: "images/*"
        },

        file_data_name: 'images',

        // Rename files by clicking on their titles
        rename: true,
        
        // Sort files
        sortable: true,

        // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
        dragdrop: true,

        // Views to activate
        views: {
            list: false,
            thumbs: true, // Show thumbs
            active: 'thumbs'
        },
        init: {
            UploadComplete: function(up, files) {
                window.location.href = urlRedirect;
            },
            Error: function(up, err) {
                alert('Error durante la carga del archivo:', err);
            },
            Browse: function(up){
                browse = true;
            },
            FilesRemoved: function(up, files){
                files.forEach(file => {
                    filesRemovedId.push(file.idDb);
                })
            },
            BeforeUpload: function(up, file){
                var option = up.getOption('multipart_params');
                if(filesUploaded == 0){
                    if(filesRemovedId.length > 0){
                        var idUniques = Array.from(new Set(filesRemovedId));
                        $.ajax({
                            url: urlDelete,
                            type:"POST",
                            data:{
                                deletedFiles:idUniques,
                                _token: option._token
                            },
                            success:function(response){
                                if(response != '"success"') {
                                    alert(response);
                                    return false;
                                }
                            },
                            error: function(xhr, status, error) {
                                alert(response);
                                return false;
                            }
                        });
                    }
                    var uploader = $("#uploader").plupload('getUploader');
                    var files = uploader.files;
                    files.forEach(file => {
                        file.newIndex = up.files.indexOf(file);
                    });
                    var queue = uploader._queue;
                    queue.sort(function(a, b) {
                        if (a.newIndex < b.newIndex) {
                            return -1;
                        }
                        if (a.newIndex > b.newIndex) {
                            return 1;
                        }
                        return 0;
                    });
                }
                var image = images.find(object => object.name === file.name);
                option.hierarchy = up.files.indexOf(file) + 1;
                if(image){
                    option.id = image.id;
                }else{
                    delete option.id; 
                }
                up.setOption('multipart_params', option);

                filesUploaded++;
            }
        }
    });

    
    // Handle the case when form was submitted before uploading has finished
    $('#form').submit(function(e) {
        // Files in queue upload them first
        if ($('#uploader').plupload('getFiles').length > 0) {

            // When all files are uploaded submit form
            $('#uploader').on('complete', function() {
                $('#form')[0].submit();
            });

            $('#uploader').plupload('start');
        } else {
            alert("You must have at least one file in the queue.");
        }
        return false; // Keep the form from submitting
    });

    var pluploadInstance = uploader.plupload('getUploader');
    var filesToAdd = [];
    images.forEach(image => {
        var xhr = new XMLHttpRequest();
        
        var protocol = window.location.protocol;
        var domain = window.location.hostname;
        var port = window.location.port;
        var rootDomain = protocol + '//' + domain;
        if (port) {
            rootDomain += ':' + port;
        }
        
        xhr.open('GET', rootDomain + '/' + image.location, true);
        xhr.responseType = 'blob';
        xhr.send();

        xhr.onload = function(event) {
            var blob = xhr.response;

            var file = new File([blob], image.name, { 
                type: "image/"+image.extension, 
                lastModified: new Date().getTime(),
                location: image.location,
                extension: image.extension,
            });
            file.hierarchy = image.hierarchy;
            filesToAdd.push(file);
            if (filesToAdd.length === images.length) {
                filesToAdd.sort((a, b) => a.hierarchy - b.hierarchy);
                filesToAdd.forEach(file => {
                    pluploadInstance.addFile(file);
                });
            }
            
            xhr.onerror = function(event) {
                console.error('Error al cargar la imagen:', xhr.statusText);
            };

            pluploadInstance.bind('FilesAdded', function(up, files) {
                if(!browse){
                    files.forEach(function(file) {
                        if(file.name == image.name){
                            file.hierarchy = image.hierarchy;
                            file.idDb = image.id;
                        }
                    });
                }else{
                    browse = false;
                }
            });         
        };
    });
});