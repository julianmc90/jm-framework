<?php

//helpers para construir formularios
class CHtml {

    //un campo de texto
    public static function textBoxFor($name, $id, $class = null, $options = null) {
        $textbox = "<input id='{$id}' type='text' name='" . $name . "' class='form-control {$class}' ";
        if ($options != null) {

            foreach ($options as $key => $value) {
                $textbox.=$key . "='" . $value . "' ";
            }
        }
        $textbox.=" />";
        echo $textbox;
    }

    public static function numberBoxFor($name, $id, $min,$class = null, $options = null) {
        $textbox = "<input id='{$id}' type='number' min='{$min}' name='" . $name . "' class='form-control {$class}' ";
        if ($options != null) {

            foreach ($options as $key => $value) {
                $textbox.=$key . "='" . $value . "' ";
            }
        }
        $textbox.=" />";
        echo $textbox;
    }

    
    public static function labelFor($texto) {

        echo "<label>" . $texto . "</label>";
    }

    public static function beginForm($action, $method, $id, $class) {

        echo "<form action='" . BASE_URL . $action . "' method='{$method}' id='{$id}' class='{$class}' >";
    }

    public static function endForm() {
        echo "</form>";
    }

    //campo escondido
    public static function hiddenFieldFor($name, $id, $value) {

        echo "<input type='hidden' id='{$id}' name='{$name}' value ='{$value}' />";
    }

    //boton 
    public static function buttonFor($text, $type, $class, $id, $options = null) {

        echo"<button class='{$class}' type='{$type}' id='{$id}' {$options} >{$text}</button>";
    }

    public static function buttonLink($r_url, $text, $class, $id) {
        echo "<a href='" . BASE_URL . "{$r_url}' class='btn {$class}' id='{$id}'>" . $text . "</a>";
    }

    public static function passwordFor($name, $options) {

        $textbox = "<input type='password' name='" . $name . "' ";
        foreach ($options as $key => $value) {
            $textbox.=$key . "='" . $value . "' ";
        }
        $textbox.=" />";
        echo $textbox;
    }

    public static function multipleDropDownList($id, $name, $data, $class = null, $options = null, $def = null) {

        $n_datos = count($data);
        $dropdown = "<select id='{$id}' size='6' name='{$name}' multiple='multiple' class='form-control " . $class . "' {$options} >";

        if ($def == true) {
            $dropdown.="<option value='seleccionar...'>seleccionar...</option>";
        }

        if ($data != null) {

            for ($i = 0; $i < $n_datos; $i++) {

                $dropdown.="<option value='{$data[$i][0]}'>{$data[$i][0]}</option>";
            }
        }
        $dropdown .="</select>";

        echo $dropdown;
    }

    public static function multipleDropDownListOptions($id, $name, $data, $class = null, $options = null, $def = null) {

        $n_datos = count($data);
        $dropdown = "<select id='{$id}' size='6' name='{$name}' multiple='multiple' class='form-control " . $class . "' {$options} >";

        if ($def == true) {
            $dropdown.="<option value='seleccionar...'>seleccionar...</option>";
        }

        if ($data != null) {

            for ($i = 0; $i < $n_datos; $i++) {

                $dropdown.="<option value='{$data[$i][0]}'>{$data[$i][1]}</option>";
            }
        }
        $dropdown .="</select>";

        echo $dropdown;
    }

    public static function multipleDropDownListOpt_def($id, $name, $data, $class = null, $options = null, $def = null, $value_def = null, $text_def = null) {

        $n_datos = count($data);
        $dropdown = "<select id='{$id}' size='6' name='{$name}' multiple='multiple' class='form-control " . $class . "' {$options} >";

        if ($data != null) {

            for ($i = 0; $i < $n_datos; $i++) {

                $dropdown.="<option value='{$data[$i][0]}'>{$data[$i][1]}</option>";
            }
        }
        if ($def == true) {

            $dropdown.="<option value='{$value_def}'>{$text_def}</option>";
        }

        $dropdown .="</select>";

        echo $dropdown;
    }

    //una lista desplegable
    public static function dropDownList($id, $name, $data, $selected, $class = null, $options = null, $def = null, $todos_opt = false, $topt_val = null, $topt_text = null) {

        $n_datos = count($data);
        $dropdown = "<select id='{$id}' name='{$name}' class='form-control " . $class . "' {$options} >";

        if ($def == true) {
            $dropdown.="<option value='seleccionar...'>seleccionar...</option>";
        }

        if ($data != null) {

            for ($i = 0; $i < $n_datos; $i++) {

                $dropdown.="<option value='{$data[$i][0]}'>{$data[$i][1]}</option>";
            }
        }

        if ($todos_opt == true) {
            $dropdown.="<option value='{$topt_val}'>{$topt_text}</option>";
        }

        $dropdown .="</select>";
        echo $dropdown . "<script>$('#{$id}').val({$selected});</script>";
    }

    //una lista desplegable
    public static function dropDownListEqId($id, $name, $data, $selected, $class = null, $def = null) {

        $n_datos = count($data);
        $dropdown = "<select id='{$id}' name='{$name}' class='form-control " . $class . "'>";
        if ($def == true) {

            $dropdown.="<option value='seleccionar...'>seleccionar...</option>";
        }
        if ($data != null) {

            for ($i = 0; $i < $n_datos; $i++) {
                $dropdown.="<option value='{$data[$i][0]}'>{$data[$i][0]}</option>";
            }
        }

        $dropdown .="</select>";

        if ($selected === null || $selected === '') {

            echo $dropdown;
        } else {

            echo $dropdown . "<script>$('#{$id}').val('{$selected}');</script>";
        }
    }

    public static function textareaFor($name, $id, $text, $cols = null, $rows = null, $class = null) {

        echo "<textarea id='{$id}' name ='{$name}' cols='{$cols}' rows='$rows' class='form-control {$class}'>{$text}</textarea>";
    }

}

?>
