

var split_url = document.URL.split(host);
var controller_actions_from_url = split_url[1];

//nombre del controlador pricipal
var final_main_controller = controller_actions_from_url.split('/')[0];

$('._'+final_main_controller).addClass('active');

//los nombres de los elementos de las listas deben tener el prefijo _ (guion bajo) 
//para evitar redundancias, ademas de que debe coincidir con el nombre del controlador

