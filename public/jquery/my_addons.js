
/*
 * Funcion que hace reset a un formulario
 */

jQuery.fn.reset = function() {
    $(this).each(function() {
        this.reset();
    });
};


