<?php

class genmodelsController extends Controller {

    private $odb;
    private $_database_name = 'thelawyer';
    public function __construct() {

        parent::__construct();
        $this->odb = new Database("mysql");
    }

    public function index() {

        $odb = $this->odb;
         

        $nombres_tablas = $odb->fetch_all("show tables from ".$this->_database_name);

        $size_nombres_tabs = count($nombres_tablas);

        for ($j = 0; $j < $size_nombres_tabs; $j++) {

            $table = $odb->fetch_all("select COLUMN_NAME from information_schema.columns where table_schema = '".$this->_database_name."' and table_name = '" . $nombres_tablas[$j][0] . "'");
            $size_table = count($table);

            $mi_archivo = "generatedModels/" . strtolower($nombres_tablas[$j][0]) . "Model.php";

            $handle = fopen($mi_archivo, 'w') or die('Cannot open file:  ' . $mi_archivo);

            $datos = "<?php \nclass " . strtolower($nombres_tablas[$j][0]) . "Model extends Model { \n";

            for ($i = 0; $i < $size_table; $i++) {

                $datos.="public $" . strtolower($table[$i]["COLUMN_NAME"]) . ";\n";
            }

            $datos.="public function __construct(";

            for ($i = 0; $i < $size_table; $i++) {

                $datos.="$" . strtolower($table[$i]["COLUMN_NAME"]) . "=null,";
            }

            $datos = substr($datos, 0, -1);
            $datos.="){parent::__construct(); ";

            for ($i = 0; $i < $size_table; $i++) {

                $datos.="$" . "this->" . strtolower($table[$i]["COLUMN_NAME"]) . "=$" . strtolower($table[$i]["COLUMN_NAME"]) . ";\n";
            }

            $datos.="} ";


            $col_types = $this->odb->fetch_all("select column_name,data_type from information_schema.columns where table_schema = '".$this->_database_name."' and table_name = '" . $nombres_tablas[$j][0] . "'");

            $size_types = count($col_types);
            $datos.= "public function get_prop_type(" . "$" . "prop){";


            $datos.= "$" . "types = Array(";

            for ($t = 0; $t < $size_types; $t++) {

                $datos.= "'" . $col_types[$t]["column_name"] . "'=>'" . $this->get_type_identifier($col_types[$t]["data_type"]) . "',";
            }

            $datos = substr($datos, 0, -1);

            $datos.= ");";

            $datos.= "return " . "$" . "types[" . "$" . "prop]; }";

            $datos.="} ";
            fwrite($handle, $datos);
            fclose($handle);
        }
    }

    public function get_type_identifier($tipo) {

        $identifier = "";

        switch ($tipo) {

            case "int":

                $identifier = "i";
                break;

            case "varchar":

                $identifier = "s";
                break;

            case "decimal":

                $identifier = "d";
                break;

            case "datetime":

                $identifier = "s";
                break;

            case "text":

                $identifier = "s";
                break;
        }

        return $identifier;
    }

}

?>