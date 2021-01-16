function cargarModalGuardar(id) {
    $('#modal-content-body').load(`/ConsumoAgua/modal-guardar/${id}`);
}

$(document).ready((event) => {


    /*
     * Eventos
     */

    $(document).on('click', '#btn_regconsumo', function() {
        let id = $(this).attr('data-id');
        cargarModalGuardar(id);
        $('#modal_acciones_consumo').modal('show');
    })

});
