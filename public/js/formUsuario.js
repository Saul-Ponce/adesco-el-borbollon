function validarUsuario(usuario) {
    const input_usuario = document.querySelector('#usuario')


    ///
    $.get(`form-usuario/validar-usuario/${usuario}`, function (data) {

        if (data.error) {
            input_usuario.dataset.ok = 0
        } else {
            input_usuario.dataset.ok = 1
            console.log('validado')
        }

        if (usuario.length === 0) {
            input_usuario.dataset.ok = 0
        }
    })


}

function validarGuardar() {
    const input_usuario = document.querySelector('#usuario'),
        input_contrasenia = document.querySelector('#contrasenia'),
        input_ccontrasenia = document.querySelector('#ccontrasenia')
        input_correo = document.querySelector('#correo')
        input_tipo = document.querySelector('#tipo')
    const datos = {
        usuario: input_usuario.value,
        contrasenia: input_contrasenia.value,
        correo: input_correo.value,
        tipo: input_tipo.value,
    }

    if (datos.usuario.length < 8 || input_usuario.dataset.ok == 0) {
        focus('usuario')
        return
    }

    if (datos.contrasenia.length < 8) {
        focus('contrasenia')
        return
    }

    if (datos.contrasenia != input_ccontrasenia.value) {
        focus('ccontrasenia')
        return
    }

    guardar(datos)

}

function guardar(datos) {
    ///
    $.post('form-usuario/guardar', datos, function (data) {
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

    const usuario = document.querySelector('#usuario')
    const contrasenia = document.querySelector('#contrasenia')
    const ccontrasenia = document.querySelector('#ccontrasenia')
    const btn_registrar = document.querySelector('#registrar')


    usuario.addEventListener('keyup', (e) => {


        if (isEnter(e.keyCode, usuario.value, 0))
            focus('contrasenia')


        usuario.value
        validarUsuario(usuario.value)
    })

    contrasenia.addEventListener('keyup', (e) => {


        if (isEnter(e.keyCode, contrasenia.value, 8))
            focus('ccontrasenia')
    })

    ccontrasenia.addEventListener('keyup', (e) => {


        if (isEnter(e.keyCode, ccontrasenia.value, 8)){
            validarGuardar();
        }
    })

    btn_registrar.addEventListener('click', (e) => {
        validarGuardar();
    })
});

