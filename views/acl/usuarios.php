<h3 class="page-title"><?php echo $this->titulo; ?></h3>


<table class="table" >
    <thead>
        <tr>
            <th>Nombre de Usuario</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Fecha de ingreso</th>
            <th>Eliminar</th>
        </tr>
    </thead>        
    <tbody>

        <?php for ($i = 0; $i < count($this->usuarios); $i++) { ?>
            <?php $id_u = $this->usuarios[$i]["ID"]; ?>
            <tr>
        <input type="hidden" value="<?php echo $id_u; ?>" class="id_usuario" /> 

        <td><?php echo $this->usuarios[$i]["NOMBRE_USUARIO"]; ?></td>
        <td><?php echo $this->usuarios[$i]["EMAIL"]; ?></td>
        <td><?php CHtml::dropDownList($id_u . 'rol', $id_u . 'rol', $this->roles, $this->usuarios[$i]["ID_ROLE"], 'selected_rol_u','',false); ?></td>
        <td>
            <?php if ($this->usuarios[$i]["ESTADO"] == 1) { ?>
                <button type="button" class="btn btn-danger deshabiliar_usuario">Deshabilitar</button>
            <?php } else { ?>
                <button type="button" class="btn btn-success habiliar_usuario">Habilitar</button>
            <?php } ?>
        </td>
        <td><?php echo $this->usuarios[$i]["FECHA"]; ?></td>
        <td><button type="button" class="btn btn-danger eliminar_user">Eliminar</button></td>
    </tr>            

<?php } ?>
</tbody>
</table>

<a class="btn btn-primary" href="<?php echo BASE_URL . 'acl/nuevo_usuario' ?>" >Nuevo Usuario</a>


