<script src="https://cdn.tiny.cloud/1/{{ config('services.tinymec.key') }}/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea#texteditor', // Replace this CSS selector to match the placeholder element for TinyMCE
    plugins: 'image table lists accordion link autolink insertdatetime media pagebreak searchreplace anchor preview',
    toolbar: 'undo redo | blocks | bold italic | fontfamily | fontsize | forecolor backcolor | alignleft aligncenter alignright | indent outdent | bullist numlist | accordion | link | image | media | preview | table | anchor | searchreplace | insertdatetime | pagebreak',
    menubar: '',
    color_map: [
        "fff", 'White',
        "999", 'Grey',
        "838487", "Dark Grey",
        "0e0e0e", 'Black'
    ],
    font_size_formats: '4px 6px 8px 10px 12px 14px 16px 18px 24px 36px 48px',
    font_size_input_default_unit: "px",
    font_family_formats: 'Montserrat=montserrat,sans-serif; Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats; Oswald=oswald, sans-serif; Didact Gothic=didact gothic,sans-serif' ,
    font_css: "{{asset('fonts/fonts.css')}}",
    details_initial_state: 'collapsed',
    link_default_target: '_blank',
    link_default_protocol: 'https',
    image_title: true,
    automatic_uploads: true,
    file_picker_types: 'image',
    file_picker_callback: (cb, value, meta) => {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        input.addEventListener('change', (e) => {
        const file = e.target.files[0];

        const reader = new FileReader();
        reader.addEventListener('load', () => {
            /*
            Note: Now we need to register the blob in TinyMCEs image blob
            registry. In the next release this part hopefully won't be
            necessary, as we are looking to handle it internally.
            */
            const id = 'blobid' + (new Date()).getTime();
            const blobCache =  tinymce.activeEditor.editorUpload.blobCache;
            const base64 = reader.result.split(',')[1];
            const blobInfo = blobCache.create(id, file, base64);
            blobCache.add(blobInfo);

            /* call the callback and populate the Title field with the file name */
            cb(blobInfo.blobUri(), { title: file.name });
        });
        reader.readAsDataURL(file);
        });

        input.click();
    },
    insertdatetime_element: true,
    insertdatetime_formats: [ "%d/%m/%Y", "%d/%B/%Y", "%A %d/%B/%Y", "%A", '%H:%M:%S' ],
    pagebreak_split_block: true,
});
</script>