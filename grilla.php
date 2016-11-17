<?php
    //IMPLEMENTAR...
    require_once "verificar_sesion.php";
    require_once "clases/AccesoDatos.php";
    require_once "clases/Usuario.php";

    if (!isset($_POST['queMuestro']))       //Evita entrar desde el navegador con ruta directa
        header("location:principal.php");
?>
<div class="animated bounceInRight" style="height:460px;overflow:auto;border-style:solid" >
    <table class="table">
        <thead style="background:rgb(14, 26, 112);color:#fff;">
            <tr>
                <th> NOMBRE </th>
                <th> MAIL </th>
                <th> PERFIL </th>
                <th> FOTO </th>
                <th> ACCION </th>
            </tr> 
        </thead>   	
        <?php
            //IMPLEMENTAR...
            $usuarios = Usuario::TraerTodosLosUsuarios();
            $usuarioEnSesion = json_decode($_SESSION["Usuario"]);

            foreach ($usuarios as $usuario)
            {
                echo "<tr>";
                echo "<td>" . $usuario->nombre ."</td>";
                echo "<td>" . $usuario->email . "</td>";
                echo "<td>" . $usuario->perfil . "</td>";
                echo "<td><img src = './fotos/" . $usuario->foto . "' width='80px' height='80px'/></td>";
                echo "<td>";
                if ($usuarioEnSesion->perfil == 'administrador' || $usuarioEnSesion->perfil == 'usuario')
                    echo "<input type = 'button' value = 'Modificar' id = 'btnModificar' onclick = 'CargarFormUsuario(1, " . $usuario->id . ")' style = 'color:black; width:100px'/>";
                if ($usuarioEnSesion->perfil == 'administrador')
                    echo "<br><input type = 'button' value = 'Eliminar' id = 'btnEliminar' onclick = 'CargarFormUsuario(2, " . $usuario->id . ")' style = 'color:black; width:100px'/>";
                echo "</td>";
                echo "</tr>";      
            }
		?>

    </table>
</div>	