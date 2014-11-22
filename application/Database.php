<?php

/**
 * Clase que administra el acceso a datos a diferentes motores
 */
class Database {

    protected $link;
    protected $data_provider;

    /**
     * funcion que construye el objeto de tipo Database  
     * @param String $data_provider definicion del proveedor de datos
     */
    public function __construct($data_provider) {

        $this->data_provider = $data_provider;

        switch ($data_provider) {

            case 'mysql':
                try {

                $this->link = new PDO('mysql:host=mysql2.000webhost.com;dbname=a1804079_law', 'a1804079_law', 'law1234', array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                
                
                } catch (PDOException $exc) {
                    echo $exc;
                }
                break;
        }
    }

    /**
     * Funcion que retorna el resultado de una consulta
     * @param String $consulta
     * @return PDOQueryResult
     */
    function consulta($consulta) {

        try {
            return $this->link->query($consulta);
        } catch (PDOException $exc) {
            echo $exc;
        }
    }

    /**
     * funcion que genera un consecutivo de ids
     * 
     * @param type $object
     * @return int
     * 
     */
    function gid($object) {

        try {
            $result = $this->fetch("select id from " . $this->table_name($object) . " order by id desc limit 1");
            return $result["id"] + 1;
        } catch (PDOException $exc) {
            echo $exc;
        }
    }

    /**
     * Funcion que retorna resultados de una consulta
     * 
     * @param String $consulta
     * @return PDOFetchedRows
     * 
     */
    function fetch($consulta) {

        try {
            return $this->consulta($consulta)->fetch();
        } catch (PDOException $exc) {
            echo $exc;
        }
    }

    /**
     * Funcion que retorna los resultados de una fila de una tabla
     * @param object $object
     * @param int $id
     */
    function get_rows_from($object, $id) {

        $this->fetch("select * from " . $this->table_name($object) . " where id=" . $id);
    }

    /**
     * Funcion que develve los resultados de una consulta personalizada con la funcion FetchAll de PDO
     * 
     * @param String $consulta
     * @return PDOFetchAll
     */
    function fetch_all($consulta) {

        try {

            return $this->consulta($consulta)->fetchAll();
        } catch (PDOException $exc) {
            echo $exc;
        }
    }

    function fetch_assoc($sql) {

        $statement = $this->link->prepare($sql);
        $statement->execute();
        $res = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $res;
    }

    /**
     * Funcion que obtiene todos los resultados de una Tabla de un modelo
     * 
     * @param object $object
     * @return PDOFetchAll
     */
    function get_all($object) {

        $this->fetch_all("select * from " . $this->table_name($object));
    }

    /**
     * Obtiene los datos de la tabla ingresada por parametro
     * @param String $table
     * @return PDOFetchAll Array
     */
    function get_by_tbn($table) {

        return $this->fetch_all("select * from " . $table);
    }

    /**
     * funcion para tal devolver el nombre de la tabla de la base de datos 
     * de un obtejo 
     * @param object $object Objeto del cual se extraera la informacion
     */
    function table_name($object) {

        return str_replace("Model", "", get_class($object));
    }

    /**
     * Funcion que guarda los datos de un objeto en el motor de la base de datos
     * @param object $object
     */
    function save($object) {

        $table = $this->table_name($object);

        $class_vars = $this->get_obj_class_vars($object);




        switch ($this->data_provider) {

            case 'mysql':

                //obtenemos el numero de atributos de la clase
                $n_prop = sizeof($class_vars);

                //empezamos a construir la consulta de insercion
                //el atributo table_db es el nombre de la tabla
                $consulta = "insert into " . $table . " (";

                //inicializamos un contador
                $contador = 1;

                //variable para completar la consulta y con ello en el siguiente bloque de codigo 
                //se prevendra de sql injection

                $completar_statement = "values(";
                //escribimos los atributos en la variable consulta
                foreach ($class_vars as $name => $value) {

                    $consulta.=$name . ',';
                    $completar_statement.=":" . $name . ",";
                }


                $consulta = substr($consulta, 0, -1);
                $completar_statement = substr($completar_statement, 0, -1);

                $consulta.=")" . $completar_statement . ");";


                //escribimos los valores de las vatriables en un arreglo asociativo
                foreach ($class_vars as $name => $value) {


                    $input_parameters[":" . $name] = $object->$name;
                }

                //parametro null para generar un nuevo id!
                $input_parameters[":id"] = null;

                try {

                    $prepared_statement = $this->link->prepare($consulta);
                    //ejecutamos la consulta
                    $prepared_statement->execute($input_parameters);
                } catch (PDOException $exc) {
                    echo $exc;
                }

                break;
        }
    }

    /**
     * Funcion que retorna los nombres de los atributos de una clase
     * @param Object $object
     * @return Array
     */
    function get_obj_class_vars($object) {

        //obtenemos un arreglo con los nombres de los atributos de la clase
        $get_class_vars = get_class_vars(get_class($object));

        //quitamos el atributo link y dataprovider
        return array_slice($get_class_vars, 0, -2);
    }

    /**
     * Funcion que edita un objeto de la base de datos 
     * @param Object $clase
     */
    function edit($object) {

        $table = $this->table_name($object);

        $class_vars = $this->get_obj_class_vars($object);


        switch ($this->data_provider) {

            case 'mysql':

                //empezamos a construir la consulta de insercion
                $consulta = "update " . $table . " set ";

                //obtenemos el numero de atributos de la clase
                $n_prop = sizeof($class_vars);



                //inicializamos un contador
                $contador = 1;

                //variable para almacenar la parte de la condicion
                $where_condition = "where ";

                //escribimos los atributos en la variable consulta
                foreach ($class_vars as $name => $value) {

                    if ($contador == 1) {

                        $where_condition.=$name . "= :" . $name . " ;";

                        //arreglo para ingresar los valores de los parametros de entrada
                        $input_parameters[] = intval($object->$name);

                        $contador++;
                    } else {
                        if ($object->$name == null) {
                            continue;
                        }

                        $input_parameters[] = $object->$name;
                        $consulta.=$name . "= :" . $name . " ,";
                    }
                }

                $consulta = substr($consulta, 0, -1);

                //completamos la condicion
                $consulta.=$where_condition;

                //preparamos la consulta
                $prepare_statement = $this->link->prepare($consulta);

                $contar = 1;

                foreach ($class_vars as $name => $value) {

                    if ($contar == 1) {
                        
                    } else {

                        if ($object->$name == null) {
                            continue;
                        }

                        if (gettype($object->$name) == 'integer') {
                            $valor = (int) $object->$name;
                        } else {
                            $valor = $object->$name;
                        }

                        $prepare_statement->bindValue(":" . $name, $valor);
                    }
                    $contar++;
                }

                foreach ($class_vars as $name => $value) {

                    if ($object->$name == null) {
                        continue;
                    }

                    if (gettype($object->$name) == 'integer') {
                        $valor = (int) $object->$name;
                    } else {
                        $valor = $object->$name;
                    }

                    $prepare_statement->bindValue(":" . $name, $valor, (is_int($value) ? PDO::PARAM_INT :
                                    PDO::PARAM_STR));
                    break;
                }


                //ejecutamos la consulta
                $prepare_statement->execute();

                break;

            case 'oracle11g':

                //empezamos a construir la consulta de insercion
                $consulta = "update " . $table . " set ";

                foreach ($class_vars as $key => $value) {

                    if ($key == 'id') {
                        continue;
                    }

                    //si el valor es vacio no se toma en cuenta
                    if ($object->$key === null) {
                        continue;
                    }

                    if (is_array($object->$key)) {

                        $var_a = $object->$key;

                        $consulta.=$key . "=" . $var_a[0] . ",";
                    } else {

                        $consulta.=$key . "=" . $this->quoteValue($object->$key) . ",";
                    }
                }

                $consulta = substr($consulta, 0, -1);
                $consulta.=" where id = " . $object->id;

                try {

                    $this->link->query($consulta);
                } catch (PDOException $exc) {
                    echo $exc;
                }

                break;
        }
    }

    /**
     * Funcion que elimina un registro de una tabla
     * @param int $id
     * @param String $table
     */
    function eliminarByidTbn($id, $table) {

        try {
            $this->link->query("delete from {$table} where id = " . $id);
        } catch (PDOException $exc) {
            echo $exc;
        }
    }

    /**
     * Funcion que elimina un registro de una entidad
     * @param int $id
     * @param entidad $object
     */
    function eliminar($id, $object) {

        try {
            $this->link->query("delete from " . $this->table_name($object) . " where id = " . $id);
        } catch (PDOException $exc) {
            echo $exc;
        }
    }

    /**
     * Funcion que trunca la tabla especificada por parametro
     * @param String $table
     */
    function truncate($table) {

        try {
            $this->link->query('truncate table ' . $table);
        } catch (PDOException $exc) {
            echo $exc;
        }
    }

    /**
     * Borra todos los datos de una tabla con la condicion id>0
     * @param String $table
     */
    function erase_all($table) {

        try {
            $this->link->query("delete from " . $table . " where id > 0");
        } catch (PDOException $exc) {
            echo $exc;
        }
    }

    /**
     * Funcion que sanea y edita un objeto
     * @param object $obj
     * @param Array $datos array de datos correspondiente al objeto a editar
     */
    public function santz_edit($obj, $datos) {

        $keys = array_keys($datos[0]);
        $size_keys = count($keys);

        for ($i = 0; $i < $size_keys; $i++) {

            $key = $keys[$i];
            $obj->$key = $this->santz_val($datos[0][$key], $obj->get_prop_type($key));
        }

        $obj->edit($obj);
    }

    public function santz_save($obj, $datos) {

        $keys = array_keys($datos[0]);
        $size_keys = count($keys);

        for ($i = 0; $i < $size_keys; $i++) {

            $key = $keys[$i];
            $obj->$key = $this->santz_val($datos[0][$key], $obj->get_prop_type($key));
        }

        $obj->save($obj);
    }

    /**
     * Funcion que devuelve un valor saneado y en el tipo de dato que le corresponde en la base de datos
     * @param String $valor
     * @param String $tipo
     * @return Int,Float,String
     */
    public function santz_val($valor, $tipo) {

        $valor_santz = null;

        switch ($tipo) {

            //Integer
            case "i":
                $valor_santz = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
                break;

            //String
            case "s";

                $valor_santz = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
                break;

            //Float
            case "d":

                $valor_santz = filter_var($valor, FILTER_SANITIZE_NUMBER_FLOAT);
                break;
        }

        return $valor_santz;
    }

    /**
     * Funcion que sanatiza una variable
     * @param any $str
     * @return type
     */
    public function quoteValue($str) {

        if (is_int($str)) {

            return filter_var($str, FILTER_SANITIZE_NUMBER_INT);
        }

        if (is_float($str)) {

            return filter_var($str, FILTER_SANITIZE_NUMBER_FLOAT);
        }

        if (is_string($str)) {
            return "'" . addcslashes(str_replace("'", "''", $str), "\000\n\r\\\032") . "'";
        }
    }
    
    
    function getLastId($identifier, $table) {

        $res = $this->fetch_all("select max({$identifier}) as max  from {$table}");
        return trim($res[0][0]);
    }

    /**
     * Función que verifica si existe un id en una tabla
     * @param string $table
     * @param string $id
     * @return boolean
     */
    public function exists_id($table, $id) {
        
        $res = $this->fetch_all("select count(*) from {$table} where id={$id}");
        $res = $res[0][0];
        
        if ($res == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Funcion que obtiene el ultimo id de una tabla
     * @param string $table_name nombre de la tabla
     * @return int ultimo id de la tabla
     */
    public function get_last_id($table_name) {

        $res = $this->fetch_all("select max(id) from {$table_name}");
        return $res[0][0];
    }

    public function n_rows($table_name) {
        
        $res=$this->fetch_all("select count(*) from {$table_name}");
        return $res[0][0];
    }


}

?>