<?php

class aclController extends Controller {

    private $_aclm;

    public function __construct() {

        parent::__construct();
        $this->_view->setJs(array('acl'));
        $this->loadModel("acl");
        $this->_aclm = new aclModel();
    }

    public function index() {

        $this->_view->titulo = "Control de Acceso";
        $this->_view->renderizar('index');
    }

    public function usuarios() {

        $this->_view->titulo = "Usuarios";
        $this->_view->usuarios = $this->_aclm->get_all_users();
        $this->_view->roles = $this->_aclm->get_all_roles();

        $this->_view->renderizar('usuarios');
    }

    /**
     * funcion que envia datos a la vista de nuevo usuario
     */
    public function nuevo_usuario() {

        $this->_view->titulo = "Nuevo Usuario";
        $this->_view->roles = $this->_aclm->get_all_roles();
    
        $this->_view->renderizar('nuevo_usuario');
    }
    
    public function eliminar_usuario (){
        
        $this->_aclm->eliminarByidTbn($this->post('id_usuario'), 'usuarios');
    }

     public function enabDesUsuario() {

        $id_usuario = $this->post('id_usuario');
        $estado = $this->post('accion');

        if ($estado == 'hab') {
            $estado = 1;
        } else {
            $estado = 0;
        }
     
        $this->_aclm->deshabUsuario($id_usuario, $estado);
    }
    
    public function changeUserRole(){
        
        $this->_aclm->changeUserRole($this->post('id_rol'), $this->post('id_usuario'));
        
    }
    
    /**
     * Accion que crea el usuario nuevo 
     */
    public function crear_usuario() {

        $form = $this->get_array_from_serialized("form");
        //print_r($form);

        if ($form["passa"] == $form["passb"]) {
            $this->_aclm->agregar_usuario(
                    $form["nombre_usuario"], $this->hash_pass($form["passa"]), $form["email"], $form["rol_u"]);
        }
    }

    public function roles() {
        $this->_view->titulo = "Administración de Roles";
        $this->_view->roles = $this->_aclm->get_all_roles();
        $this->_view->renderizar('roles');
    }

    public function Permisos_roles($id_rol) {

        //si no existe el parametro
        if (empty($id_rol)) {
            $this->redireccionar('acl/roles');
        }

        $id_rol = $this->int($id_rol);
        $this->_view->id_rol = $id_rol;
        $this->_view->titulo = "Administracion de permisos del rol " . $this->_aclm->get_rol_name($id_rol);
        $this->_view->permisos = $this->_aclm->get_permisos_por_rol($id_rol);
        $this->_view->renderizar('permisos_roles');
    }

    /**
     * accion para agregar un nuevo rol
     */
    public function agregar_rol() {

        $this->_aclm->agregar_role($this->post('new_role'));
    }

    public function eliminar_rol() {

        $this->_aclm->eliminarRole($this->post('id_role'));
    }

    /**
     * Funcion que activa o desactiva un permiso de un role
     */
    public function enabDesPermiso() {

        $id_permiso_rol = $this->post('id_permiso_rol');
        $estado = $this->post('accion');

        if ($estado == 'hab') {
            $estado = 1;
        } else {
            $estado = 0;
        }

        $this->_aclm->deshabPermiso($id_permiso_rol, $estado);
    }

    /**
     * funcion para agregar un nuevo permiso, este es necesario en la etapa de desarrollo de la aplicacion
     * para agregar los permisos necesarios a las areas de la aplicacion
     */
    public function agregarPermiso() {

        // $permiso = "Visualizar Gantt";
        // $key = "ver_gantt";
        // $this->_aclm->agregarPermiso($permiso, $key);
    }

}

?>