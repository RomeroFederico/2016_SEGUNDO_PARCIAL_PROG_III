<?php
    //IMPLEMENTAR...
    require_once "verificar_sesion.php";

    $objUser = json_decode($_SESSION["Usuario"]);

    if (isset($_COOKIE["theme" . $objUser->id]))
        $theme = "background-color:" . $_COOKIE["theme" . $objUser->id];
?>
<html>
    <head>
        <title>Romero Federico</title> 

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="./js/funciones.js"></script>

        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="css/estilo.css" />
        <link rel="stylesheet" type="text/css" href="css/animacion.css" />

    </head>
    <body id="miBody" style="<?php echo $theme; ?>">
        <div class="container" style="width:100%" >
            <div class="page-header">
                <?php
                echo "<a class='btn btn-success animated bounceInLeft' href='#' onclick='Home()'><span class='glyphicon glyphicon-home'>&nbsp;</span>Home</a>";
                echo "<a class='btn btn-default animated bounceInLeft' href='#' onclick='MostrarGrilla()'><span class='glyphicon glyphicon-th'>&nbsp;</span>Grilla&nbsp;</a>";
                echo "<a class='btn btn-warning animated bounceInLeft' href='#' onclick='MostrarGrillaEliminados()' " . (($objUser->perfil != "administrador")? "style ='display:none'" : "") . "><span class='glyphicon glyphicon-warning-sign'>&nbsp;</span>Grilla Eliminados&nbsp;</a>";
				echo "<a class='btn btn-primary animated bounceInLeft' href='#' onclick='EditarUsuario(" . $_SESSION["Usuario"] . ")' " . (($objUser->perfil == "invitado")? "style ='display:none'" : "") . "><span class='glyphicon glyphicon-user'></span>Editar Perfil&nbsp;</a>";
				echo "<a class='btn btn-info animated bounceInLeft' href='#' onclick='CargarFormUsuario()'" . (($objUser->perfil != "administrador")? "style ='display:none'" : "") . "><span class='glyphicon glyphicon-user'>&nbsp;</span><span class='glyphicon glyphicon-plus-sign'></span>Agregar Usuario&nbsp;</a>";
				echo "<a class='btn btn-warning animated bounceInLeft' href='#' onclick='ElegirTheme()'><span class='glyphicon glyphicon-pencil'>&nbsp;</span>Elegir Theme</a>";
				echo "<a class='btn btn-danger animated bounceInLeft' href='#' onclick='Logout()'><span class='glyphicon glyphicon-off'></span>LogOut&nbsp;</a>";        	  
                ?>
                <span id="spanFoto" class="animated bounceInRight" style='margin-top:-38px' ><img src="./fotos/<?php echo $objUser->foto; ?>" width='80px' height='80px'/></span>
                <span id="spanDatos" class="animated bounceInRight" style='margin-top:-10px' ><h3><?php //IMPLEMENTAR...
                    echo $objUser->nombre . " [" . $objUser->perfil . "]"; ?>&nbsp;&nbsp;</h3></span>
            </div>
            <h1 style="font-size:28px">PRINCIPAL</h1>
            <hr/>
            <div id="divAbm"  style='border-style:none;float:left;width:30%'>

            </div>
            <div id="divGrilla"  style='border-style:none;float:right;width:70%'>

            </div>
        </div>
    </body>
</html>