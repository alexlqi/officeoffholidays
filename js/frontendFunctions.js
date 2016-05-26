var idUsuario;
var nombreUsuario;
var apellidosUsuario;
var numeroEmpleado;
var correoUsuario;
var puestoUsuario;
var saldoUsuario;
var idDepartamento;
var idEmpresa;
var onboarding;
var changedPic = false;

var newRegisterPic = function(event)
{
	var output = document.getElementById('ImagenUsuarioR');
	output.src = URL.createObjectURL(event.target.files[0]);
	changedPic = true;
}

var newUserPic = function(event)
{
	var output = document.getElementById('ImagenUsuarioEditar');
	output.src = URL.createObjectURL(event.target.files[0]);
	changedPic = true;
}

function loadUser()
{
	var userMail = localStorage.getItem("correo");
	var userPass = localStorage.getItem("contrasenia");
	var dataToSend = {action:"cargarUsuario",usuario: userMail, contrasenia: userPass};
	$.ajax({
		url: "ws.php",
		async: true,
		type: "post",
		dataType: "json",
		data: dataToSend,
		success: function(data) {
			//sabemos que en este caso el servicio responde con un JSON
			if(data != null)
			{
				if(data == -1)
				{
					console.log("error de cargado de usuario");
					logout();
				}
				else
				{
					idUsuario = data[0].idUsuario;
					nombreUsuario = data[0].nombreUsuario;
					apellidosUsuario = data[0].apellidosUsuario;
					numeroEmpleado = data[0].numeroEmpleado;
					correoUsuario = data[0].correoUsuario;
					puestoUsuario = data[0].puestoUsuario;
					saldoUsuario = data[0].saldoUsuario;
					idDepartamento = data[0].idDepartamento;
					idEmpresa = data[0].idEmpresa;
					onboarding = data[0].onboarding;
					//mostrar info en lugares correspondientes
					$("#NombreUsuarioB").append(nombreUsuario);
				}
			}
			else
			{
				console.log("error, json nulo al cargar usuario");
			}
		},
		error: function(x,y,z)
		{
			alert("Error de comunicacion con el servidor:" + x + y + z);
		}
	});
}

function logout()
{
	var dataToSend = {action:"logout"};
	$.ajax({
		url: "ws.php",
		async: true,
		type: "post",
		dataType: "json",
		data: dataToSend,
		success: function(data) {
			if(data != null)
			{
				if(data == 1)
				{
					localStorage.removeItem("correo");
					localStorage.removeItem("contrasenia");
					localStorage.removeItem("puesto");
					window.location="index.html";
				}
				else
				{
				}
			}
		},
		error: function(x,y,z)
		{
			console.log("Error de comunicacion con el servidor:" + x + y + z);
			localStorage.removeItem("correo");
			localStorage.removeItem("contrasenia");
			localStorage.removeItem("puesto");
			window.location="index.html";
		}
	});
}