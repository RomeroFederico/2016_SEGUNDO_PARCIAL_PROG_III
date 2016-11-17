<?php
    //IMPLEMENTAR...
    require_once "verificar_sesion.php";

    if (!isset($_POST['queMuestro']))       //Evita entrar desde el navegador con ruta directa
        header("location:principal.php");
?>
<div class="animated bounceInRight" style="height:460px;overflow:auto;border-style:solid;background:#000" >
    <table class="table" >
        <thead style="background:rgb(14, 26, 112);color:#fff;">
            <tr>
                <th> NOMBRE </th>
                <th> MUESTRA </th>
                <th> APLICAR </th>
            </tr> 
        </thead>   
		<tr>
			<td>Defaul</td>
            <td><canvas width="100" height="25" style = "background-color:#3F5185"></canvas></td>
            <td><input type = 'radio' name = 'rdoTema' id = 'rdo1' value = '#3F51B5' checked onchange = "AplicarTheme('rdo1')"/></td> 
		</tr>
        <tr>
            <td>VERDE</td>
            <td><canvas width="100" height="25" style = "background-color:#73B53F"></canvas></td>
            <td><input type = 'radio' name = 'rdoTema' id = 'rdo2' value = '#73B53F' onchange = "AplicarTheme('rdo2')"/></td> 
        </tr>
        <tr>
            <td>MARRON</td>
            <td><canvas width="100" height="25" style = "background-color:#B55E3F"></canvas></td>
            <td><input type = 'radio' name = 'rdoTema' id = 'rdo3' value = '#B55E3F' onchange = "AplicarTheme('rdo3')"/></td> 
        </tr>
        <tr>
            <td>GRIS</td>
            <td><canvas width="100" height="25" style = "background-color:#BDBDBD"></canvas></td>
            <td><input type = 'radio' name = 'rdoTema' id = 'rdo4' value = '#BDBDBD' onchange = "AplicarTheme('rdo4')"/></td> 
        </tr>
        <tr>
            <td>VIOLETA</td>
            <td><canvas width="100" height="25" style = "background-color:#F781F3"></canvas></td>
            <td><input type = 'radio' name = 'rdoTema' id = 'rdo5' value = '#F781F3' onchange = "AplicarTheme('rdo5')"/></td> 
        </tr>
        <tr>
            <td>ROJO</td>
            <td><canvas width="100" height="25" style = "background-color:#FF0000"></canvas></td>
            <td><input type = 'radio' name = 'rdoTema' id = 'rdo6' value = '#FF0000' onchange = "AplicarTheme('rdo6')"/></td> 
        </tr>
    </table>
	<br><br><br>
	<input type="button" id="btnTheme" onclick="GuardarTheme()" value="GUARDAR THEME" style="color:#000;margin-left:350px"/>
</div>	