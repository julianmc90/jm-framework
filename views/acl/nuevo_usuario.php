<h3 class="page-title"><?php echo $this->titulo; ?></h3>

<div class="row">
    <div class="col-md-6">
        <?php
        CHtml::beginForm('', '', 'add_user_form', '');

        CHtml::labelFor('Nombre de Usuario:');
        CHtml::textBoxFor('nombre_usuario', '');

        echo "<br/>";

        CHtml::labelFor('Contraseña:');
        CHtml::passwordFor('passa', array('class' => 'form-control', 'id' => 'passa'));

        echo "<br/>";

        CHtml::labelFor('Confirmar Contraseña:');

        CHtml::passwordFor('passb', array('class' => 'form-control', 'id' => 'passb'));

        echo "<br/>";

        CHtml::labelFor('Email:');
        CHtml::textBoxFor('email', '');

        echo "<br/>";
        
        CHtml::labelFor('Rol:');
        CHtml::dropDownList('rol_u', 'rol_u', $this->roles, '', '',null,true);

        echo "<br/>";

        CHtml::buttonFor('Agregar', 'button', 'btn btn-primary', 'add_user', "style='float:right;'");

        CHtml::endForm();
        ?>
    </div>
</div>