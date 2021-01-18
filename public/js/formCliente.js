
/*function validarCliente(cliente) {

    const input_cliente = document.querySelector('#cliente')


    ///
    $.get(`form-cliente/validar-cliente/${cliente}`, function (data) {

        if (data.error) {
            input_cliente.dataset.ok = 0
        } else {
            input_cliente.dataset.ok = 1
            console.log('validado')
        }

        if (cliente.length === 0) {
            input_cliente.dataset.ok = 0
        }
    })


}*/

function validarGuardar() {


    const
        input_idcliente =document.querySelector('#usuario'),
        input_nombrecliente = document.querySelector('#nombrecliente'),
        input_apellidocliente = document.querySelector('#apellidocliente'),
        input_dui = document.querySelector('#dui'),
        input_nit = document.querySelector('#nit'),
        input_direccion = document.querySelector('#direccion'),
        input_telefono = document.querySelector('#telefono'),
        input_idcanton = document.querySelector('#idcanton'),
        input_matriculaescritura = document.querySelector('#matriculaescritura'),
        input_usuario= document.querySelector('#usuario'),
        input_contrasenia = document.querySelector('#contrasenia'),
        input_ccontrasenia = document.querySelector('#ccontrasenia'),
        input_correo = document.querySelector('#correo')
    const datos = {
        codcliente: input_idcliente.value,
        nombrecliente: input_nombrecliente.value,
        apellidocliente: input_apellidocliente.value,
        dui: input_dui.value,
        nit: input_nit.value,
        direccion: input_direccion.value,
        telefono: input_telefono.value,
        idcanton: parseInt(input_idcanton.value),
        matriculaescritura: input_matriculaescritura.value,
        id_usuario: 0,
        usuario: input_usuario.value,
        contrasenia: input_contrasenia.value,
        correo: input_correo.value,
        tipo: 'Cliente',
    }

if ( input_nombrecliente.dataset.ok == 0 || datos.nombrecliente.length < 3 ) {
        focus('nombrecliente')
        return
    }

    if (datos.apellidocliente.length < 3 || datos.apellidocliente.length == 0 ) {
        focus('apellidocliente')
        return
    }


   if (datos.dui.length == 0 || datos.dui.length > 10 || datos.dui.length < 10) {
        focus('dui')
        return
    }

    if (datos.nit.length == 0 || datos.nit.length < 17 || datos.nit.length > 17) {
        focus('nit')
        return
    }

    if (datos.direccion.length == 0 || datos.direccion.length < 6 || datos.direccion.length > 60) {
        focus('direccion')
        return
    }

    if (datos.telefono.length == 0 || datos.telefono.length < 9 || datos.telefono.length > 9) {
        focus('telefono')
        return
    }

 /*  if (datos.idcanton.nombrecanton.length == 0) {
        focus('nombre canton')
        return
    }*/

   // if (datos.idcanton != input_idcanton.value) {
  //      focus('idcanton')
  //      return
   /// }

    if (datos.matriculaescritura.length == 0) {
        focus('matriculaescritura')
        return
    }

    /* if (datos.contrasenia.length == 0) {
         focus('contrasenia')
        return
    }*/

    if (datos.contrasenia != input_ccontrasenia.value) {
      focus('ccontrasenia')
    return
    }


    /*if (datos.id_usuario.length ==0){
        focus('idusuario')
        return
    }*/
   /* if (datos.idusuario !== input_idusuario.value) {
        focus('idusuario')
        return
    }*/
    guardar(datos)

}

function guardar(datos) {
    ///
    console.log(datos)
    $.post('form-cliente/guardar', datos, function (data) {
        log(data);
        if (!data.error) {
            Swal.fire({
                title: 'Atención',
                text: data.mensaje,
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#6777ef',
                confirmButtonText: 'Ok',
            }).then((result) => {
                location.href = data.redireccion
            })
        }else {
            console.log('no sirvio')
            console.log(data.error)
        }
    })
}

document.addEventListener("DOMContentLoaded", function (event) {

    const nombrecliente = document.querySelector('#nombrecliente')
    const apellidocliente = document.querySelector('#apellidocliente')
    const dui = document.querySelector('#dui')
    const nit = document.querySelector('#nit')
    const direccion = document.querySelector('#direccion')
    const telefono = document.querySelector('#telefono')
    const idcanton = document.querySelector('#idcanton')
    const matriculaescritura = document.querySelector('#matriculaescritura')
    const idusuario = document.querySelector('#idusuario')
    const btn_registrar = document.querySelector('#registrar')


    /*const usuario = document.querySelector('#usuario')
    const contrasenia = document.querySelector('#contrasenia')
    const ccontrasenia = document.querySelector('#ccontrasenia')
    const btn_registrar = document.querySelector('#registrar')*/


  /*  cliente.addEventListener('keyup', (e) => {


        if (isEnter(e.keyCode, usuario.value, 0))
            focus('contrasenia')


        usuario.value
        validarUsuario(usuario.value)
    })

    contrasenia.addEventListener('keyup', (e) => {


        if (isEnter(e.keyCode, contrasenia.value, 8))
            focus('ccontrasenia')
   })*/

   /* ccontrasenia.addEventListener('keyup', (e) => {


        if (isEnter(e.keyCode, ccontrasenia.value, 8)){
            validarGuardar();
        }
    })
*/
    btn_registrar.addEventListener('click', (e) => {
        validarGuardar();
    })
});

