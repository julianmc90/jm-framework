<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <?php $this->favicon(); ?>
        <title><?php echo $this->titulo; ?></title>

        <?php
        //imprimimos el css seteado en view
        $this->imp_arr_css($_lp['main_css']);
        $this->imp_arr_css($_lp['_css_comp_library']);
        $this->imp_arr_css($_lp['css']);
        ?>
        <script type="text/javascript">
            var host = '<?php echo BASE_URL; ?>';
        </script>
    </head>

    <body>

        <!-- si el usuario esta autenticado mostramos la barra de navegacion -->
        <?php if (Session::get('autenticado')) { ?>
        
            <!-- Fixed navbar -->
            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" >
                            The Lawyer
                        </a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="_procesos">
                                <a href="<?php echo BASE_URL . 'procesos'; ?>">Procesos</a>
                            </li>
                            <li class="_clientes">
                                <a href="<?php echo BASE_URL . 'clientes'; ?>">Clientes</a>
                            </li>
                           <!-- <li><a href="">Contact</a></li> -->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    
                                    <?php 
                                    echo Session::get('nombre')." ".Session::get('apellido');
                                    ?> 

                                    <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                               <!-- <li><a href="">Action</a></li>
                                    <li><a href="">Another action</a></li>
                                    <li><a href="">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li class="dropdown-header">Nav header</li>
                                    <li><a href="#">Separated link</a></li>
                                    <li><a href="#">One more separated link</a></li>
                                -->
                                <li><a href="<?php echo BASE_URL.'login/cerrar'; ?>">Cerrar Sesi&oacute;n</a></li>
                               </ul>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>

        <?php } ?>

        <div class="container theme-showcase">
















