function Login() 
{
	//IMPLEMENTAR...
	var email = $("#email").val();
	var password = $("#password").val();

	if (!ValidarCampos(email, password))
		alert("No se han completado correctamente los campos.");
	else
		VerificarSiExisteUsuario("adminLogin.php", email, password);
}

function ValidarCampos(email, password, nombre = 0)
{
	if (email.length == 0 || password.length < 6 || (nombre != 0 && nombre.length == 0))
		return false;
	return true;
}

function VerificarSiExisteUsuario(URL, email, password)
{
	var form = new FormData();

	form.append("email", email);
	form.append("password", password);

	$.ajax({
		type: "POST",
		url: URL,
		dataType: "text",
		data: form,
		contentType: false,
		processData: false,
		async: true
	})
	.done(function (resultado) {
		if (resultado != "Ok")
			alert("Error!!!\nNo coincide e-mail y/o password!!!");
		else
			window.location.href = "principal.php";
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function Registrarse()
{
	var form = new FormData();
	
	form.append("queMuestro", "4");
	form.append("queHago", "Agregar");
	form.append("IdUsuario", 0);
	form.append("registrar", 1);

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
        $(".container").css("border-style", "none");
        $(".container").css("float", "center");
        $(".container").css("width", "30%");

		$(".container").html(resultado);
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
		alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
	});
}

function AgregarUsuario() 
{
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
		if (!objeto.exito)
			alert(objeto.mensaje);
		else
		{
			alert("Usuario registrado con exito!!!");
			window.location.href = "login.php";
		}
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