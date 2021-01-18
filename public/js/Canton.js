

function cargarModalEditar(id) {
    $('#modal-content-body').load(`/Canton/modal-editar/${id}`);
}
function cargarModalGuardar() {

    $('#modal-content-body').load('/canton/modal-guardar');
}


$(document).on('click', '#btn_eliminar_canton', function() {
    let idcanton = $(this).attr('data-id');
    validarCantonEliminar(idcanton)
})

function validarCantonEditar() {


    let canton = {
        idcanton: $('#btn_editar_c').data('canton'),
        nombrecanton:$('#nombrecanton').val()

    }
    // casos de error
    if (canton.nombrecanton.length === 0) {
        validarCampo('nombrecanton', true);
        focus('nombrecanton');
        return false;
    }

    //confirmar guardar
    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de editar este Canton?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            editarCanton(canton);
        } else {
            focus('nombrecanton');
        }
    })
}

function validarCantonEliminar(idcanton) {

    log(idcanton);

    //confirmar eliminar
    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de eliminar este canton?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            eliminarcanton(idcanton);
        } else {

        }
    })
}

function editarCanton(canton) {

    $.post('/canton/editar', { canton }, function(data) {

        if (!data.error) {
            Swal.fire({
                title: 'Exito',
                text: data.mensaje,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $('#modal_acciones_canton').modal('hide');
                location.href = '/canton'
            })
        } else {
            Swal.fire({
                title: 'Error',
                text: data.mensaje,
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $('#modal_acciones_canton').modal('hide');
            })
        }
    });
}

function eliminarcanton(idcanton) {
    $.post('/canton/eliminar', { idcanton }, function(data) {
        if (!data.error) {
            Swal.fire({
                title: 'Exito',
                text: data.mensaje,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                location.href = data.redireccion
            })
        } else {
            Swal.fire({
                title: 'Error',
                text: data.mensaje,
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
            })
        }
    });
}

function validarCantonGuardar() {


    let canton= {
        nombrecanton: $('#nombrecanton').val(),
    }
    // casos de error
    if (canton.nombrecanton.length === 0 ) {
        focus('nombrecanton');
        return false;
    }


    //confirmar guardar
    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de guardar este canton?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
    }).then((result)=>{
        if(result.value){
            guardarCanton(canton);
        }
            })
}

function guardarCanton(canton) {
    $.post('/canton/guardar', { canton }, function(data) {
        if (!data.error) {
            Swal.fire({
                title: 'Exito',
                text: data.mensaje,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $('#modal_acciones_canton').modal('hide');
                location.href = '/Canton'
            })
        }else{
            Swal.fire({
                title: 'Error',
                text: data.mensaje,
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                focus('nombrecanton')
            })
        }
    });
}






$(document).ready((event) => {


    /*
     * Eventos
     */


    $('#btn_acciones_canton').on('click', function() {
        cargarModalGuardar();
        $('#modal_acciones_canton').modal('show');
    })

    $(document).on("click", "#btn_guardar", function(e) {
        $('#btn_guardar').blur();
       // submitFormularioEspecico();
        validarCantonGuardar();

    });

    $(document).on('click', '#btn_editar_canton', function() {
        let id = $(this).attr('data-id');
        cargarModalEditar(id);
        $('#modal_acciones_canton').modal('show');
    })


    $(document).on("click", "#btn_editar_c", function(e) {
        $('#btn_editar_c').blur();
        validarCantonEditar();
    });





});


