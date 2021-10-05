window.addEventListener("load", function() {
    var divs = document.getElementsByClassName("gallery-item");
    var images = new Array();
    var links = new Array();
    for (var i = 0; i < divs.length; i++) {
        images.push(divs[i].children[0].children[0].children[0].children[0]);
        links.push(divs[i].children[0]);
    }
    links.forEach(element => {
        var title = element.title;
        element.addEventListener('click', function() {
            setLinkImage(title);
        });
    });
    if (window.matchMedia("(min-width: 768px)").matches) {
        for (var i = 0; i < images.length; i = i + 2) {
            var diferencia;
            if (i != 2) {
                if (images[i].height < images[i + 1].height) {
                    diferencia = images[i].height - images[i + 1].height;
                    if (i + 2 <= divs.length) {
                        divs[i + 2].setAttribute('style', 'margin-top: ' + diferencia + 'px;');
                    }
                } else {
                    diferencia = images[i + 1].height - images[i].height;
                    if (i + 3 <= divs.length) {
                        divs[i + 3].setAttribute('style', 'margin-top: ' + diferencia + 'px;');
                    }
                }
            }
        }
    }
});