function cargarModalGuardar(id) {
    $('#modal-content-body').load(`/ConsumoAgua/modal-guardar/${id}`);
}

function validarConsumoGuardar() {
    const input_idcliente = document.querySelector('#idcliente'),
        input_lecturaactual = document.querySelector('#lecturaactual'),
        input_lecturaanterior = document.querySelector('#lecturaanterior'),
        input_fechadelectura = document.querySelector('#fechadelectura')
    let consumo = {
        idcliente: input_idcliente.value,
        lecturaactual: (parseFloat(input_lecturaactual.value)).toPrecision(4),
        lecturaanterior: (parseFloat(input_lecturaanterior.value)).toPrecision(4),
        fechadelectura: input_fechadelectura.value,
    }

    console.log(consumo)

    Swal.fire({
        title: 'Atención',
        text: "¿Esta seguro de guardar este registro?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
    }).then((result)=>{
        if(result.value){
            guardarConsumo(consumo)
        }
    })


}

function guardarConsumo(consumo) {
    $.post('/consumo-agua/guardar', { consumo }, function(data) {
        if (!data.error) {
            log(data.errorlog)
            Swal.fire({
                title: 'Exito',
                text: data.mensaje,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $('#modal_acciones_consumo').modal('hide');
                location.href = '/consumo-agua'
            })
        }else{
            Swal.fire({
                title: 'Error',
                text: data.mensaje,
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                log(data.error)
            })
        }
    });
}

$(document).ready((event) => {


    /*
     * Eventos
     */
    log('ando por aca')
    tablaPaginacion('tabla_cliente_consumo')
    tablaPaginacion('tabla_cliente_consumo_para_factura')




    $('#btn_regconsumo').on('click', function() {
        let id = $(this).attr('data-id');
        cargarModalGuardar(id)
        $('#modal_acciones_consumo').modal('show');
    })
    // $(document).on('click', '#btn_regconsumo', function() {
    //     let id = $(this).attr('data-id');
    //     cargarModalGuardar(id);
    //     $('#modal_acciones_consumo').modal('show');
    // })

    $(document).on("click", "#btn_guardar_consumo", function(e) {
        $('#btn_guardar_consumo').blur();
        validarConsumoGuardar();

    });
});
