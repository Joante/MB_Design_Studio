const staticAssets = import.meta.glob([
    '../js/*.min.js',
    '../js/custom.js',
    '../js/gridify-min.js',
    '../js/images-gallery.js',
    '../js/jquery.magnific-popup.js',
    '../js/map.js',
    '../js/plupload-*.js',
    '../js/sweerAlertDeleteConfirmation.js',
    '../js/YouTubePopUp.js',
    '../js/core/**/*.js',
    '../js/scripts/**/*.js',
    '../vendors/js/**/*.js',
    '../fonts/**/*.{svg,ttf,eot,woff,woff2,otf,png,jpg,jpeg,gif,ico}',
    '../data/**/*.json',
], {
    eager: true,
    import: 'default',
    query: '?url',
});

void staticAssets;
