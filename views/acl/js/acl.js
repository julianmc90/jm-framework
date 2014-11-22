
//evento para abrir la ventana de nuevo rol
$(document).on('click', '#add_role', function() {
    $('#myModal').modal('show');
});

//metodo para validar el nombre del rol
$.validator.addMethod(
        "only_letters",
        function(value, element, regexp) {
            var check = false;
            return this.optional(element) || regexp.test(value);
        },
        "El valor ingresado no es valido"
        );

$.validator.addMethod("valueNotEquals", function(value, element, arg) {
    return arg != value;
}, "El valor no debe ser igual");

 $.validator.addMethod(
        "strong_pass",
        function(value, element, regexp) {
            var check = false;
            return this.optional(element) || regexp.test(value);
        },
        "la Contraseña No Es Válida"
        );

    $.validator.addMethod(
        "valid_username",
        function(value, element, regexp) {
            var check = false;
            return this.optional(element) || regexp.test(value);
        },
        "El nombre de usuario no es valido"
        );


//validacion del formuladio de ingresar nuevo role
$('#add_role_form').validate({
    rules: {
        new_rol_name: {
            required: true,
            only_letters: /[a-zA-Z]+/
        }
    },
    messages: {
        new_rol_name: {
            required: "Debe Introducir un Nombre para el Nuevo Rol"
        }
    },
    //clase de error de Twitter Bootstrap
    errorClass: 'alert alert-danger'
});


$(document).on('click', '#agregar_role', function() {


    if ($("#add_role_form").valid()) {
        $.ajax({
            url: host + 'acl/agregar_rol',
            data: {
                new_role: $.trim($("#new_rol_name").val())
            },
            type: "POST",
            success: function(datos) {
                alert(datos);
            },
            async: true
        });
    }
});


//funcion para habilitar un permiso
$(document).on('click', '.eliminar_role', function() {

    var parent_html = $(this).parent();
    var id_rol = $.trim($(this).parent().parent().find('.id_role').val());

    $.ajax({
        url: host + 'acl/eliminar_rol',
        data: {
            id_role: id_rol
        },
        type: "POST",
        success: function(datos) {

            alert(datos);
        },
        async: true
    });
});


//funcion para habilitar un permiso
$(document).on('click', '.habilitar', function() {

    var parent_html = $(this).parent();
    var id_permiso_rol = $.trim($(this).parent().parent().find('.id_permiso_rol').val());

    $.ajax({
        url: host + 'acl/enabDesPermiso',
        data: {
            id_permiso_rol: id_permiso_rol,
            accion: 'hab'
        },
        type: "POST",
        success: function(datos) {
            parent_html.html("<button type='button' class='btn btn-danger deshabilitar'>Deshabilitar</button>");

        },
        async: true
    });
});

//funcion para deshabilitar un permiso
$(document).on('click', '.deshabilitar', function() {

    var parent_html = $(this).parent();
    var id_permiso_rol = $.trim($(this).parent().parent().find('.id_permiso_rol').val());

    $.ajax({
        url: host + 'acl/enabDesPermiso',
        data: {
            id_permiso_rol: id_permiso_rol,
            accion: 'des'
        },
        type: "POST",
        success: function(datos) {
            parent_html.html("<button type='button' class='btn btn-success habilitar'>Habilitar</button>");
        },
        async: true
    });
});


//validacion del formuladio de ingresar nuevo Usuario
$('#add_user_form').validate({
    rules: {
        nombre_usuario: {
            required: true,
            valid_username:/^[a-zA-Z0-9_]{3,16}$/
        },
        passa: {
            required: true,
            minlength: 8,
            strong_pass:/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#%*/+-_.;:()=?!]).{8,20})/
        },
        passb: {
            minlength: 8,
            required: true,
            equalTo: "#passa",
            strong_pass:/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#%*/+-_.;:()=?!]).{8,20})/
        },
        rol_u: {
            valueNotEquals: "seleccionar..."
        },
        email: {
            required: true,
            email: true
        }

    },
    messages: {
        nombre_usuario: {
            required: "Debe Introducir un Nombre para el Nuevo Usuario",
            valid_username:"El Nombre de usuario debe ser alfanumerico"
        },
        passa: {
            required: "por favor ingrese una contraseña",
            minlenght: "la contraseña debe tener por lo menos 8 caracteres",
            strong_pass:"La contraseña debe tener como minimo 8 caracteres y debe contener minimo una letra mayuscula, una minuscula, un numero y alguno de los siguientes simbolos @#%*/+-_.;:()=?!"
        },
        passb: {
            required: "Por favor repita la contraseña",
            minlenght: "la contraseña debe tener por lo menos 8 caracteres",
            equalTo: "Las contraseñas deben ser iguales",
            strong_pass:"La contraseña debe tener como minimo 8 caracteres y debe contener minimo una letra mayuscula, una minuscula, un numero y alguno de los siguientes simbolos @#%*/+-_.;:()=?!"
        
        },
        rol_u: {
            valueNotEquals: "Debe Seleccionar un rol para el nuevo usuario"
        }
    },
    //clase de error de Twitter Bootstrap
    errorClass: 'alert alert-danger'
});


$(document).on('click', '#add_user', function() {

    if ($('#add_user_form').valid()) {
        $.ajax({
            url: host + 'acl/crear_usuario',
            data: {
                form: $('#add_user_form').serialize()
            },
            type: "POST",
            success: function(datos){
                alert(datos);
                $("#add_user_form").reset();
            },
            async: true
        });
    }
});


//funcion para eliminar un Usuario
$(document).on('click', '.eliminar_user', function() {

    var parent_html = $(this).parent();
    var id_usuario = $.trim($(this).parent().parent().find('.id_usuario').val());

    $.ajax({
        url: host + 'acl/eliminar_usuario',
        data: {
            id_usuario: id_usuario
        },
        type: "POST",
        success: function(datos) {

            alert(datos);
        },
        async: true
    });
});


//funcion para habilitar un usuario
$(document).on('click', '.habiliar_usuario', function() {

    var parent_html = $(this).parent();
    var id_usuario = $.trim($(this).parent().parent().find('.id_usuario').val());

    $.ajax({
        url: host + 'acl/enabDesUsuario',
        data: {
            id_usuario: id_usuario,
            accion: 'hab'
        },
        type: "POST",
        success: function(datos) {

            parent_html.html("<button type='button' class='btn btn-danger deshabiliar_usuario'>Deshabilitar</button>");
        },
        async: true
    });
});


//funcion para deshabilitar un usuario
$(document).on('click', '.deshabiliar_usuario', function() {

    var parent_html = $(this).parent();
    var id_usuario = $.trim($(this).parent().parent().find('.id_usuario').val());

    $.ajax({
        url: host + 'acl/enabDesUsuario',
        data: {
            id_usuario: id_usuario,
            accion: 'des'
        },
        type: "POST",
        success: function(datos) {
            parent_html.html("<button type='button' class='btn btn-success habiliar_usuario'>Habilitar</button>");
        },
        async: true
    });
});

//funcion para cambiar el rol de un usuario
$(document).on('change', '.selected_rol_u', function() {

    var sel_id_rol = $.trim($(this).val());
    var id_usuario = $.trim($(this).parent().parent().find('.id_usuario').val());


    $.ajax({
        url: host + 'acl/changeUserRole',
        data: {
            id_rol: sel_id_rol,
            id_usuario: id_usuario
        },
        type: "POST",
        success: function(datos) {

            alert(datos);

        },
        async: true
    });

});