// function cargarTablaUsuarios(carga = false) {
//     if(carga){
//         Swal.fire({
//             title: 'Cargando...',
//             onBeforeOpen: () => {
//                 Swal.showLoading()
//             }
//         })
//     }
//     $('#div_tabla_usuarios').load('/form-usuario/tablaUsuarios', (data) => {
//         //$('[data-toggle="tooltip"]').tooltip();
//         if(carga){
//             Swal.close();
//         }
//     });
// }

function cargarModalEditar(id) {
    $('#modal-content-body').load(`/form-usuario/modal-editar/${id}`);
}

$(document).on('click', '#btn_editar_usuario', function() {
    let id = $(this).attr('data-id');
    cargarModalEditar(id);
    $('#modal_acciones_usuario').modal('show');
})

$(document).on('click', '#btn_eliminar_usuario', function() {
    let idusuario = $(this).attr('data-id');
    validarUsuarioEliminar(idusuario)
})

function validarUsuarioEditar() {

    //objeto de cuenta
    let usuario = {
        idusuario: $('#btn_editar').data('usuario'),
        usuario:$('#usuario').val(),
        contrasenia: $('#contrasenia').val(),
        correo: $('#correo').val(),
        tipo: $('#tipo').val()
    }
    // casos de error
    if (usuario.contrasenia.length === 0) {
        validarCampo('contrasenia', true);
        focus('contrasenia');
        return false;
    }

    //confirmar guardar
    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de editar este usuario?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            editarUsuario(usuario);
        } else {
            focus('contrasenia');
        }
    })
}

function validarUsuarioEliminar(idusuario) {


    //confirmar eliminar
    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de eliminar este usuario?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            eliminarUsuario(idusuario);
        } else {
        }
    })
}

function editarUsuario(usuarios) {
    $.post('/form-usuario/editar', { usuarios }, function(data) {
        if (!data.error) {
            Swal.fire({
                title: 'Exito',
                text: data.mensaje,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $('#modal_acciones_usuario').modal('hide');
                location.href = '/formUsuario/tablaUsuarios'
            })
        } else {
            Swal.fire({
                title: 'Error',
                text: data.mensaje,
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $('#modal_acciones_usuario').modal('hide');
            })
        }
    });
}

function eliminarUsuario(idusuario) {
    $.post('/form-usuario/eliminar', { idusuario }, function(data) {
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

$(document).ready((event) => {


    /*
     * Eventos
     */




    $(document).on('click', '#btn_editar_usuario', function() {
        let id = $(this).attr('data-id');
        cargarModalEditar(id);
        $('#modal_acciones_usuario').modal('show');
    })


    $(document).on("click", "#btn_editar", function(e) {
        $('#btn_editar').blur();
        validarUsuarioEditar();
    });

});
