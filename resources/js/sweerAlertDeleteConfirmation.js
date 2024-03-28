function deleteConfirmation(id, pathname) {
    var path;
    if (location.pathname == '/' + pathname) {
        switch(pathname){
            case 'art/exhibition/list/admin':
                path = '/art/exhibition/destroy';
                break;
            case 'art/painting/colection/list/admin':
                path = '/art/painting/colection/destroy';
                break;
            case 'art/painting/list/admin':
                path = '/art/painting/destroy';
                break;
            case 'admin/settings':
                path = '/admin/degrees/destroy';
                break;
            default:
                path = "/" + pathname + "/destroy";
                break;
        }
    } else {
        path = "destroy";
    }
    Swal.fire({
        title: '¿Esta seguro?',
        text: "Esta accion no puede revertirse",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminarlo',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            fetch(path, {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    credentials: "same-origin",
                    body: JSON.stringify({
                        id: id
                    })
                }).then(
                    function(response) {
                        if (response.status !== 200) {
                            console.log('Looks like there was a problem. Status Code: ' +
                                response.status);
                            return;
                        }
                        // Examine the text in the response
                        response.json().then(function(data) {
                            if (data.message == 'success') {
                                Swal.fire({
                                    title: 'Eliminado!',
                                    text: 'Se ha eliminado con existo el registro de la base de datos.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.value) {
                                        if (pathname == 'art/exhibition/list/admin' || pathname == 'art/painting/colection/list/admin' || pathname == "art/painting/list/admin" || pathname == 'admin/settings') {
                                            window.location.replace("/" + pathname);
                                        } else {
                                            window.location.replace("/" + pathname + "/list");
                                        }

                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'No se ha podido eliminar el registro. ' + data.message,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        });
                    }
                )
                .catch(function(err) {
                    console.log('Fetch Error :-S', err);
                });
        }
    })
}