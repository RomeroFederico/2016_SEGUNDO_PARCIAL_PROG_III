function Logout()
{
	//#2
	//IMPLEMENTAR...
	var form = new FormData();

	form.append("queMuestro", "2");

	$.ajax({
		type: "POST",
		url: "administracion.php",
		dataType: "text",
		data: form,
		contentType: false,
		processData: false,
		async: true
	})
	.done(function (resultado) {
		if (resultado != "Ok")
			alert("Ha ocurrido un error al querer cerrar la sesion. ");
		else
		{
			alert("Se ha cerrado la sesion actual. ");
			window.location.href = "login.php";
		}
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function MostrarGrilla()
{
	//#3
	//IMPLEMENTAR...
	var form = new FormData();

	form.append("queMuestro", "3");

	$.ajax({
		type: "POST",
		url: "administracion.php",
		dataType: "text",
		data: form,
		contentType: false,
		processData: false,
		async: true
	})
	.done(function (resultado) {
		$("#divGrilla").html(resultado);
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function Home()
{	
	//#3-sin case
	//IMPLEMENTAR...
	window.location.href = "principal.php";
}

function CargarFormUsuario(queHago = 0, id = 0) // Agrego el parametro id.
{
	//#4
	//IMPLEMENTAR...
	var form = new FormData();

	if ($("#divGrilla").html().length > 14)  //Cierro la grilla theme si esta abierta, pero no la de usuarios.
		if ($("#divGrilla").find("div").css("background-color") == 'rgb(0, 0, 0)')
			$("#divGrilla").html("");

	switch (queHago)
	{
		case 1:
			queHago = "Modificar";
			break;
		case 2:
			queHago = "Eliminar";
			break;
		case 3:
			queHago = "Editar Perfil";
			break;
		default:
			queHago = "Agregar";
	}

	form.append("queMuestro", "4");
	form.append("queHago", queHago);
	form.append("IdUsuario", parseInt(id));

	$.ajax({
		type: "POST",
		url: "administracion.php",
		dataType: "text",
		data: form,
		contentType: false,
		processData: false,
		async: true
	})
	.done(function (resultado) {
		$("#divAbm").html(resultado);
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function SubirFoto() 
{
	//#5
	//IMPLEMENTAR...
	var formData = new FormData();

	var imagen = $("#archivo")[0];
	formData.append("imagenModificada", imagen.files[0]);
	formData.append("queMuestro", "5");
	formData.append("fotoAnterior", $("#fotoTmp").attr("src"));
	formData.append("idFoto", $("#hdnIdUsuario").val());

	$.ajax({
		type: "POST",
		url: "administracion.php",
		dataType: "JSON",
		data: formData,
		contentType: false,
		processData: false,
		async: true
	})
	.done(function (objeto) {
		if (!objeto.exito)
			alert(objeto.mensaje);
		else
		{
			$("#fotoTmp").attr("src", objeto.imagenSubidaRuta);
			$("#hdnFotoSubir").val(objeto.imagenSubida);
		}
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function AgregarUsuario() 
{
	//#6
	//IMPLEMENTAR...
	var nombre = $("#txtNombre").val();
	var email = $("#txtEmail").val();
	var password = $("#txtPassword").val();

	if (!ValidarCampos(nombre, email, password))
	{
		alert("No se han completado los campos correctamente.");
		return;
	}

	var formData = new FormData();

	var nuevoRegistro = {"id" : $("#hdnIdUsuario").val(),
						 "nombre" : nombre,
						 "email" : email,
						 "perfil" : $("#cboPerfiles").val(),
						 "password" : password,
						 "foto" : $("#hdnFotoSubir").val()};

	formData.append("nuevoUsuario", JSON.stringify(nuevoRegistro));
	formData.append("queMuestro", "6");
	formData.append("fotoNueva", $("#fotoTmp").attr("src"));

	$.ajax({
		type: "POST",
		url: "administracion.php",
		dataType: "JSON",
		data: formData,
		contentType: false,
		processData: false,
		async: true
	})
	.done(function (objeto) {
		alert(objeto.mensaje);
		if (objeto.exito)
		{
			$("#divAbm").html("");

			if ($("#divGrilla").html().length > 14)
				MostrarGrilla();
		}
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function EditarUsuario(obj) 
{
	//#7 sin case
	//IMPLEMENTAR...
	CargarFormUsuario(3, obj.id);
}

function EliminarUsuario()
{
	//#7
	//IMPLEMENTAR...
	var formData = new FormData();

	formData.append("idEliminar", $("#hdnIdUsuario").val());
	formData.append("fotoEliminar", $("#fotoTmp").attr("src"));
	formData.append("queMuestro", "7");

	$.ajax({
		type: "POST",
		url: "administracion.php",
		dataType: "JSON",
		data: formData,
		contentType: false,
		processData: false,
		async: true
	})
	.done(function (objeto) {
		alert(objeto.mensaje);
		if (objeto.exito)
		{
			$("#divAbm").html("");
			MostrarGrilla();	
		}
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function ModificarUsuario() 
{
	//#8
	//IMPLEMENTAR...
	var nombre = $("#txtNombre").val();
	var email = $("#txtEmail").val();

	if (!ValidarCampos(nombre, email))
	{
		alert("No se han completado los campos correctamente.");
		return;
	}

	var formData = new FormData();

	var registroModificado = {"id" : $("#hdnIdUsuario").val(),
							  "nombre" : nombre,
							  "email" : email,
							  "perfil" : $("#cboPerfiles").val(),
							  "foto" : $("#hdnFotoSubir").val()};

	formData.append("usuarioModificado", JSON.stringify(registroModificado));
	formData.append("queMuestro", "8");
	formData.append("fotoNueva", $("#fotoTmp").attr("src"));

	$.ajax({
		type: "POST",
		url: "administracion.php",
		dataType: "JSON",
		data: formData,
		contentType: false,
		processData: false,
		async: true
	})
	.done(function (objeto) {
		alert(objeto.mensaje);
		if (objeto.exito)
		{
			if (objeto.usuarioEnSesionModificado)
			{
                $("#spanDatos").children("h3").html(objeto.usuarioEnSesionNombre + " [" + objeto.usuarioEnSesionPerfil + "]");
                $("#spanFoto").children("img").attr("src", objeto.usuarioEnSesionFoto);
                if (objeto.usuarioEnSesionPerfil != "administrador")
                {
                	$('.btn.btn-info.animated.bounceInLeft').hide();
                	if (objeto.usuarioEnSesionPerfil != "usuario")
                		$(".btn.btn-primary.animated.bounceInLeft").hide();
                }
			}

			$("#divAbm").html("");

			if ($("#divGrilla").html().length > 14)
				MostrarGrilla();
		}
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function ElegirTheme() 
{
	//#9
	//IMPLEMENTAR...
	var form = new FormData();

	if ($("#divAbm").html().length > 14) // Cierro cualquier form, solo se vera esta grilla.
		$("#divAbm").html("");

	form.append("queMuestro", "9");

	$.ajax({
		type: "POST",
		url: "administracion.php",
		dataType: "text",
		data: form,
		contentType: false,
		processData: false,
		async: true
	})
	.done(function (resultado) {
		$("#divGrilla").html(resultado);
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function AplicarTheme(radio) 
{
	//sin case
	//IMPLEMENTAR...
	var color = $("#" + radio).val();
	$("#miBody").css("background-color", color);
}

function GuardarTheme() 
{
	//#10
	//IMPLEMENTAR...
	var color = $("#miBody").css("background-color");

	var form = new FormData();

	form.append("queMuestro", "10");
	form.append("tema", color);

	$.ajax({
		type: "POST",
		url: "administracion.php",
		dataType: "JSON",
		data: form,
		contentType: false,
		processData: false,
		async: true
	})
	.done(function (objeto) {
		alert(objeto.mensaje);
		if (objeto.exito)
			$("#divGrilla").html("");
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function MostrarGrillaEliminados()
{
	var form = new FormData();

	if ($("#divAbm").html().length > 14) // Cierro cualquier form, solo se vera esta grilla.
		$("#divAbm").html("");

	form.append("queMuestro", "11");

	$.ajax({
		type: "POST",
		url: "administracion.php",
		dataType: "JSON",
		data: form,
		contentType: false,
		processData: false,
		async: true
	})
	.done(function (objeto) {
		if (objeto.exito)
			$("#divGrilla").html(objeto.tabla);
		else
			alert(objeto.mensaje);
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function ValidarCampos(nombre, email, password = 0)
{
	if (nombre.length == 0 || email.length == 0 || (password !== 0 && password.length < 6))
		return false;
	else if (email.length >= 50 || nombre.length >= 25 || password.length >= 16)
		return false;
	return true;
}