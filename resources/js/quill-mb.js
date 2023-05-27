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
        'color': ['#999', '#838487', '#fff', '#0e0e0e']
    }, {
        'background': ['#999', '#838487', '#fff', '#0e0e0e']
    }], // dropdown with defaults from theme
    [{
        'align': []
    }]
];
var quill = new Quill('#editor', {
    modules: {
        // Equivalent to { toolbar: { container: '#toolbar' }}
        toolbar: toolbarOptions
    },
    theme: 'snow'
});