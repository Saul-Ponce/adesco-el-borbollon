function cargarTablaIndex(carga = false) {

    $('#div_tabla_cuentas').load('/cuenta/tabla-cuentas', (data) => {
        tablaPaginacionTodos('tabla_cuentas');
        $('[data-toggle="tooltip"]').tooltip();
        if(carga){
            Swal.close();
        }
    });
}

function cargarModalGuardar(id) {
    $('#modal-content-body').load(`/ConsumoAgua/modal-guardar/${id}`);
}

$(document).ready((event) => {


    /*
     * Eventos
     */

    tablaPaginacion('tabla_cliente_para_consumo')
    tablaPaginacion('tabla_cliente_consumo_para_factura')

    $(document).on("keyup", "#lecturaactual", function(e) {
        validarCampo('codigo', false);
        focusOnEnter(
            e.keyCode,
            $(this).val(),
            0,
            'nombre'
        );
        buscarCuentaPadre();
    });

    $(document).on('click', '#btn_regconsumo', function() {
        let id = $(this).attr('data-id');
        cargarModalGuardar(id);
        $('#modal_acciones_consumo').modal('show');
    })

});
