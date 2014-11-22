<?php

class Session {

    public static function init() {

        session_start();
       //session_destroy();
    }

    public static function destroy($clave = false) {

        if ($clave) {
            if (is_array($clave)) {
                for ($i = 0; $i < count($clave); $i++) {
                    if (isset($_SESSION[$clave[$i]])) {
                        unset($_SESSION[$clave[$i]]);
                    }
                }
            } else {
                if (isset($_SESSION[$clave])) {
                    unset($_SESSION[$clave]);
                }
            }
        } else {
            session_destroy();
        }
    }

    public static function set($clave, $valor) {
        if (!empty($clave))
            $_SESSION[$clave] = $valor;
    }

    public static function get($clave) {
        
        if (empty($_SESSION[$clave])){
            
            return false;
        
        }else{
            Session::regenerate_session_id();
            return $_SESSION[$clave];
        }
    }

    public static function acceso($level) {

        Session::regenerate_session_id();

        //verificamos si el usuario esta autenticado
        if (!Session::get('autenticado')) {
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }

        //si el nivel del usuario logueado es menor al nivel requerido
        if (Session::get('level') < $level) {

            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }

        $fecha_actual = time();
        $session_timeout = strtotime(Session::get('session_time'));

        //si el tiempo almacenado en la variable de sesion se ha acabado
        if ($fecha_actual > $session_timeout) {

            //Comprobamos el tiempo de la base de datos de sim_launcher
            if (Session::get_session_time() <= 0) {
                header('location:' . BASE_URL . 'login/cerrar');
                exit;
            }
        } else {

            $fecha = new DateTime();
            $fecha_actual_st = new DateTime();

            $fecha->setTimestamp($session_timeout);

            //session_timeout
           // echo "Session timeout";
           // echo $fecha->format('Y-m-d H:i:s');
           // echo "<br />";

            $fecha->modify("-30 Seconds");

            //Session_timeout con 30 segundos menos
           // echo "Session timeout con 30 seg menos";
           // echo $fecha->format('Y-m-d H:i:s');
           // echo "<br />";
           // echo "fecha Actual" . $fecha_actual_st->format('Y-m-d H:i:s');

            if ($fecha_actual_st >= $fecha) {
                Session::set_session_time();
                echo "session_timeout_setted";
            }
        }
    }

    public static function get_session_time() {

        $sim_conn = new Database('mysql');

        $res = $sim_conn->fetch("select session_time from peticiones where id=" . Session::get('id_sim_launcher') . ";");
        
        Session::set('session_time', $res[0]);

        $session_end_date = new DateTime(Session::get('session_time'));
        $actual_date = new DateTime();

        $diffInSeconds = $session_end_date->getTimestamp() - $actual_date->getTimestamp();
        return $diffInSeconds;
    }

    public static function set_session_time() {

        $sim_conn = new Database('mysql');

        //insertamos el primer tiempo de sesion
        $date = new DateTime();
        $date->modify("+1 Minutes");
        Session::set('session_time', $date->format("Y-m-d H:i:s"));

        $sim_conn->consulta("update peticiones set session_time= '" . $date->format('Y-m-d H:i:s') . "' where id =" . Session::get('id_sim_launcher') . ";");
    }

    
    //funcion que regenera el id de la session
    public static function regenerate_session_id() {

          session_regenerate_id(true);
//        echo "<br/>";
//        echo "SID: " . SID . "<br>session_id(): " . session_cache_expire() . "<br>COOKIE: " . $_COOKIE["PHPSESSID"];
//        session_regenerate_id(true);
//        echo "<br/>";
//        echo "SID: " . SID . "<br>session_id(): " . session_id() . "<br>COOKIE: " . $_COOKIE["PHPSESSID"];
    }

}

?>