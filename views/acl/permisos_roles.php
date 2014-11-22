<h3 class="page-title"><?php echo $this->titulo; ?></h3>

<?php if (!empty($this->permisos)) { ?>

    <table class="table" style="width: 50%;" >
        <thead>
            <tr>
                <th>Permiso</th>
                <th>Habilitar</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < count($this->permisos); $i++) { ?>
                <tr>
                    <input type='hidden' class='id_permiso_rol' value='<?php echo $this->permisos[$i][0];?>'/>
                    <td>
                        <?php echo $this->permisos[$i][1]; ?>
                    </td>
                    <td>
                        <?php if ($this->permisos[$i][2] == 0) { ?> 
                            <button type='button' class='btn btn-success habilitar'>Habilitar</button>
                        <?php } else { ?>
                            <button type='button' class='btn btn-danger deshabilitar'>Deshabilitar</button>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

<?php } else { ?>


<?php } ?>
