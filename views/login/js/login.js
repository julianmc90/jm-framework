

$('#form_login').validate({
    rules: {
        nombre_de_usuario: {
            required: true

        },
        password: {
            required: true

        }
    },
    messages: {
        nombre_de_usuario: {
            required: "Debe Intrododucir un nombre de usuario"
        },
        password: {
            required: "Debe introducir una contraseña"
        }
    },
    //clase de error de Twitter Bootstrap
    errorClass: 'alert alert-danger'
});




$(document).on('click', '#autenticar', function(event) {
    
     event.preventDefault();
    
    if ($('#form_login').valid()) {

        $.ajax({
            url: host + 'login/autenticar',
            data: {nombre_de_usuario: $('#nombre_de_usuario').val(),
                password: $('#password').val()},
            type: 'POST',
            success: function(res) {

                var result = $.trim(res);
                if (result === '1') {
                    
                    window.location = host+'clientes';

                } else {
                    alert("los datos son incorrectos");
                }

            }

        });

    }

});