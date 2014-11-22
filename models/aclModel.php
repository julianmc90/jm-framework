<?php

class aclModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     * Esta funcion obtiene todos los roles de la aplicacion
     * @return Array
     */

    public function get_all_roles() {

        return $this->get_by_tbn("roles");
    }

    /**
     * Esta funcion Obtiene un arreglo con los usuarios
     * @return Array
     */
    public function get_all_users() {

        return $this->fetch_all("select us.id,us.nombre_usuario,(select usuarios_roles.id_rol from usuarios_roles where id_usuario=us.id ) as id_role,us.email,us.Estado, to_char(us.fecha,'yyyy-mm-dd hh:mi:ss AM') as fecha from usuarios us");
    }

    public function get_security_questions() {

        return $this->get_by_tbn("preguntas_de_seguridad");
    }

    public function agregar_usuario($nombre_usuario, $password, $email,$id_role) {

        $query = "insert into usuarios (nombre_usuario,password,email,estado,fecha) values ('{$nombre_usuario}','{$password}','{$email}',0,current_timestamp)";
        $this->consulta($query);
        $new_id_user = $this->getLastId('id', 'usuarios');
    
        $this->consulta("insert into usuarios_roles(id_usuario,id_rol) values ({$new_id_user},{$id_role})");
        
        }

    public function deshabUsuario($id_usuario, $estado) {

        $this->consulta("update usuarios set estado={$estado} where id = {$id_usuario}");
    }

    public function changeUserRole($id_role, $id_usuario) {

        $this->consulta("update usuarios_roles set id_rol ={$id_role} where id_usuario= {$id_usuario}");
    }

    /**
     * funcion que obtiene el nombre de un rol
     * @param int $id_role
     * @return String
     */
    public function get_rol_name($id_role) {

        return $this->fetch_all("select role from roles where id=" . $id_role)[0][0];
    }

    /**
     * funcion que agrega un nuevo rol
     * @param String $role_name
     */
    public function agregar_role($role_name) {

        $this->consulta("insert into roles (role) values('" . $role_name . "')");

        $new_id_role = $this->getLastId('id', 'roles');

        $permisos = $this->fetch_all('select id from permisos');
        $size = count($permisos);

        for ($i = 0; $i < $size; $i++) {
            $this->insert_permiso_role($permisos[$i][0], $new_id_role);
        }
    }

    public function eliminarRole($id) {

        $this->eliminarByidTbn($id, 'roles');
    }

    public function insert_permiso_role($id_permiso, $id_role) {
        $this->consulta("insert into permisos_roles (id_role,id_permiso,estado) values ({$id_role},{$id_permiso},0)");
    }

    /**
     * Esta funcion Obtiene los permisos del rol seleccionado haciendo un case para detectar aquellos permisos que no tiene el rol
     * @param int $id_rol
     * @return Array
     */
    public function get_permisos_por_rol($id_rol) {

        return $this->fetch_all("select pr.id,p.permiso,pr.estado from permisos_roles pr,permisos p where pr.id_role={$id_rol} and pr.id_permiso=p.id");
    }

    /**
     * function que deshabilita o habilita un permiso de un rol
     * @param int $id_permiso_rol
     * @param int $estado
     */
    public function deshabPermiso($id_permiso_rol, $estado) {

        $this->consulta("update permisos_roles set estado={$estado} where id = {$id_permiso_rol}");
    }

    public function agregarPermiso($permiso, $key) {

        $this->consulta("insert into permisos (permiso,key) values ('{$permiso}','{$key}')");

        $new_id_permiso = $this->getLastId('id', 'permisos');

        $roles = $this->get_all_roles();
        $size_roles = count($roles);
        for ($i = 0; $i < $size_roles; $i++) {
            $this->insert_permiso_role($new_id_permiso, $roles[$i][0]);
        }
    }

}

?>
