document.addEventListener("DOMContentLoaded", function(event) {
    document.form_login.addEventListener('submit', (e) => {
        e.preventDefault();

        let login = {
            usuario: document.querySelector('#usuario').value,
            contrasenia: document.querySelector('#contrasena').value
        };

        $.ajax({
            type: "POST",
            url: "/login/iniciarSesion",
            data: { login },
            success: function(result) {
                console.log(result);


                if (result.error && result.tipo === 'no_encontrado') {
                    document.querySelector(`#usuario`).focus();
                }

                if (!result.error) {
                    location.href = result.url;
                }
            }
        });
    });
});
