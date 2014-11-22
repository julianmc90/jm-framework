<h3 class="page-title"><?php echo $this->titulo; ?></h3>

<?php if (!empty($this->roles)) { ?>

    <table class="table" style="width: 50%;">
        <thead>
            <tr>
                <th>Rol</th>
                <th>Permisos</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < count($this->roles); $i++) { ?>
                <tr>
            <input type="hidden" value='<?php echo $this->roles[$i][0]; ?>' class='id_role'>
            <td><?php echo $this->roles[$i][1]; ?></td>
            <td>
                <a href="<?php echo BASE_URL . 'acl/permisos_roles/' . $this->roles[$i][0]; ?>" class="btn btn-orange">
                    <i class="glyphicon glyphicon-lock"></i>&nbsp;Permisos
                </a>
            </td>
            <td><a class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i>&nbsp;Editar</a></td>
            <td><a class="btn btn-danger eliminar_role"><i class="glyphicon glyphicon-trash"></i>&nbsp;Eliminar</a></td>
        </tr>
    <?php } ?>
    </tbody>
    </table>
    <?php CHtml::buttonFor('Nuevo Rol', 'button', 'btn btn-primary', 'add_role'); ?>
<?php } else { ?>

<?php } ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Nuevo Rol</h4>
            </div>
            <div class="modal-body">
                <?php
                CHtml::beginForm('', 'post', 'add_role_form', '');
                CHtml::labelFor('Nombre del Nuevo Rol:');
                CHtml::textBoxFor('new_rol_name', 'new_rol_name');
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <?php
                CHtml::buttonFor('Agregar Rol', 'button', 'btn btn-primary', 'agregar_role');
                CHtml::endForm();
                ?>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->