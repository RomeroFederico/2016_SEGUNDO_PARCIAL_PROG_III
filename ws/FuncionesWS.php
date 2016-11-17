<?php

	require_once '../lib/nusoap.php'; 
	
	$server = new nusoap_server(); 

	$server->configureWSDL('FuncionesWS', 'urn:FuncionesWS'); 

	$server->wsdl->addComplexType("InfoEliminado", "complexType", "struct", "all", "",
		array(
			"idEliminado" => array('name' => 'idEliminado', "type" => "xsd:int"),
			"nombreEliminado" => array('name' => 'nombreEliminado', "type" => "xsd:string"),
			"emailEliminado" => array('name' => 'emailEliminado', "type" => "xsd:string"),
			"perfilEliminado" => array('name' => 'perfilEliminado', "type" => "xsd:string"),
			"idSesion" => array('name' => 'idSesion', "type" => "xsd:int"),
			"nombreSesion" => array('name' => 'nombreSesion', "type" => "xsd:string"),
			"fechaEliminacion" => array('name' => 'fechaEliminacion', "type" => "xsd:string"))
		);

	$server->register('AgregarEliminadoJSON',
				array('InfoEliminado' => "tns:InfoEliminado"),
				array('return' => "xsd:bool"),
				'urn:FuncionesWS',
				'urn:FuncionesWS#AgregarEliminadoJSON',
				'rpc',
				'encoded',
				'Guardo la informacion del usuario eliminado en el archivo JSON.'
				);

	$server->register('TraerEliminadosJSONYMostrarGrilla',
				array(),
				array('return' => "xsd:string"),
				'urn:FuncionesWS',
				'urn:FuncionesWS#TraerEliminadosJSONYMostrarGrilla',
				'rpc',
				'encoded',
				'Lectura del archivo JSON de eliminados y retorno de la tabla con estos datos.'
				);

	function AgregarEliminadoJSON($infoEliminado)
	{
		$ruta = "./usuariosEliminados.JSON";

		$eliminados = "";

		if (!file_exists($ruta))
		{
			$archivo = fopen($ruta, "w");
			$eliminados = "[]";
			fclose($archivo);
		}

		$archivo = fopen("./usuariosEliminados.JSON", "r");

		while (!feof($archivo))
			$eliminados .= fgets($archivo);

		fclose($archivo);

		$eliminados = trim($eliminados, "\n\r");
		$eliminados = trim($eliminados, "]");

		if ($eliminados != "[")
			$eliminados = $eliminados . ",\n\r";

		$archivo = fopen($ruta, "w");

		fwrite($archivo, $eliminados . json_encode($infoEliminado) . "]");

		fclose($archivo);
	}

	function TraerEliminadosJSONYMostrarGrilla()
	{
		$ruta = "./usuariosEliminados.JSON";

		if (!file_exists($ruta))
			return "ERROR";
	
		$archivo = fopen($ruta, "r");

		$objetoJSON = "";

		while (!feof($archivo))
			$objetoJSON .= fgets($archivo);

		fclose($archivo);

		$obj = json_decode($objetoJSON);

		$retorno = "";

		$retorno .= '<div class="animated bounceInRight" style="height:460px;overflow:auto;border-style:solid;background:#000" >';
        $retorno .= '<table class="table" >';
        $retorno .= '<thead style="background:crimson;color:#fff;">';
        $retorno .= '<tr>';
        $retorno .=  	'<th> ID </th>';
        $retorno .=		'<th> NOMBRE </th>';
        $retorno .= 	'<th> E-MAIL </th>';
        $retorno .= 	'<th> PERFIL </th>';
        $retorno .=		'<th> ID ADM</th>';
        $retorno .=		'<th> NOMBRE ADM </th>';
        $retorno .=		'<th> FECHA ELIMINACION </th>';
        $retorno .= '</tr>';
        $retorno .= '</thead>';

        foreach ($obj as $informacion)
        {
        	$retorno .= "<tr>";
        	$retorno .= "<td>" . $informacion->idEliminado . "</td>";
        	$retorno .= "<td>" . $informacion->nombreEliminado . "</td>";
        	$retorno .= "<td>" . $informacion->emailEliminado . "</td>";
        	$retorno .= "<td>" . $informacion->perfilEliminado . "</td>";
        	$retorno .= "<td>" . $informacion->idSesion . "</td>";
        	$retorno .= "<td>" . $informacion->nombreSesion . "</td>";
        	$retorno .= "<td>" . $informacion->fechaEliminacion . "</td>";
        	$retorno .= "</tr>";

        }

   		$retorno .= '</table>';
		$retorno .= '</div>';

		return $retorno;
	}

	$HTTP_RAW_POST_DATA = file_get_contents("php://input");
	
	$server->service($HTTP_RAW_POST_DATA);

?>