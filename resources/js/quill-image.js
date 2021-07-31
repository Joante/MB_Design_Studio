let Font = Quill.import('formats/font');
Font.whitelist = ['didact-gothic', 'oswald'];
Quill.register(Font, true);

var toolbarOptions = [
    [{
        'font': ['didact-gothic', 'oswald']
    }],
    ['bold', 'italic', 'underline'], // toggled buttons

    [{
        'header': 1
    }, {
        'header': 2
    }], // custom button values
    [{
        'list': 'ordered'
    }, {
        'list': 'bullet'
    }],
    [{
        'indent': '-1'
    }, {
        'indent': '+1'
    }], // outdent/indent
    [{
        'direction': 'rtl'
    }], // text direction

    [{
        'size': ['small', false, 'large', 'huge']
    }], // custom dropdown
    [{
        'header': [1, 2, 3, 4, 5, 6, false]
    }],

    [{
        'color': ['#999', '#b19777', '#fff', '#272727']
    }, {
        'background': ['#999', '#b19777', '#fff', '#272727']
    }], // dropdown with defaults from theme
    [{
        'align': []
    }],
    ['link', 'image', 'video']
];
var quill = new Quill('#editor', {
    modules: {
        // Equivalent to { toolbar: { container: '#toolbar' }}
        toolbar: toolbarOptions,
        imageResize: {
            displaySize: true
        }
    },
    theme: 'snow'
});