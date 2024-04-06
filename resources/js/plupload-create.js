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
    $("#uploader").plupload({
        
        url: url,

        // Maximum file size
        max_file_size: '10mb',

        // User can upload no more then 20 files in one go (sets multiple_queues to false)
        max_file_count: maxFiles,
        
        multipart_params: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'action': action
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
                // Agrega una función para manejar errores durante la carga
                console.error('Error durante la carga del archivo:', err);
            },
            BeforeUpload: function(up,file){
                var option = up.getOption('multipart_params');
                option.hierarchy = up.files.indexOf(file) + 1;
                up.setOption('multipart_params', option);
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
});