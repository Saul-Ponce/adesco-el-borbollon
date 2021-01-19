function cargarModalEditar(id) {
    $('#modal-content-body').load(`/form-cliente/modal-editar/${id}`);
}

$(document).on('click', '#btn_editar_cliente', function() {
    let id = $(this).attr('data-id');
    cargarModalEditar(id);
    $('#modal_acciones_cliente').modal('show');
})

$(document).on('click', '#btn_eliminar_cliente', function() {
    let idcliente = $(this).attr('data-id');
    validarClienteEliminar(idcliente)
})

function validarClienteEditar() {

    //objeto de cuenta
    let cliente = {
        codcliente: $('#btn_editar').data('cliente'),
        nombrecliente:$('#nombrecliente').val(),
        apellidocliente: $('#apellidocliente').val(),
        dui: $('#dui').val(),
        nit: $('#nit').val(),
        direccion: $('#direccion').val(),
        telefono: $('#telefono').val(),
        idcanton: $('#idcanton').val(),
        matriculaescritura: $('#matriculaescritura').val(),
        id_usuario: $('#id_usuario').val(),
    }

    let usuario={
        idusuario: cliente.id_usuario,
            usuario: $('#usuario').val(),
            contrasenia: $('#contrasenia').val(),
            correo: $('#correo').val(),
        tipo: $('#tipo').val(),
    }
    log(cliente);
    log(usuario);
    // casos de error
    if (cliente.nombrecliente.length === 0) {
        validarCampo('nombrecliente', true);
        focus('nombrecliente');
        return false;
    }

    //confirmar guardar
    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de editar este cliente?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            editarCliente(cliente,usuario);
        } else {
            focus('nombrecliente');
        }
    })
}

function validarClienteEliminar(idcliente) {

    log(idcliente);

    //confirmar eliminar
    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de eliminar este cliente?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.value) {
            eliminarCliente(idcliente);
        } else {
            console.log('cliente no eliminado')
        }
    })
}

function editarCliente(clientes,usuarios) {
////////////
    const datos={ clientes,usuarios };
    console.log(datos);

    $.post('/form-cliente/editar', { clientes,usuarios }, function(data) {
        console.log(data)
        if (!data.error) {
            Swal.fire({
                title: 'Exito',
                text: data.mensaje,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $('#modal_acciones_cliente').modal('hide');
                location.href = '/formCliente/tablaClientes'
            })
        } else {
            console.log(data.SqlError)
            Swal.fire({
                title: 'Error',
                text: data.mensaje,
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $('#modal_acciones_cliente').modal('hide');
            })
        }
    });
}

function eliminarCliente(idcliente) {
    $.post('/form-cliente/eliminar', { idcliente }, function(data) {
        console.log(data)
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


    tablaPaginacion('tabla_clientes')

    $(document).on('click', '#btn_editar_cliente', function() {
        let id = $(this).attr('data-id');
        cargarModalEditar(id);
        $('#modal_acciones_cliente').modal('show');
    })


    $(document).on("click", "#btn_editar", function(e) {
        $('#btn_editar').blur();
        validarClienteEditar();
    });

});
