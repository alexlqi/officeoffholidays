<?php
	if(isset($_POST['action']))
	{
		$action = $_POST['action'];
	}
	else
	{
		$action = $_GET['action'];
	}
	//$action = $_POST['action'];

	if ($action == "registro") 
	{
		registro();
	}
	else if($action == "imagen")
	{
		imagen();
	}
	else if ($action == "login")
	{	
		login();
	}
	else if ($action == "logout")
	{
		if(isset($_SESSION['idUsuario']))
		{
			session_unset();
			session_destroy();
		}
		echo 1;
	}
	else if ($action == "onboardingCompleto")
	{
		checkOnBoarding();
	}
	else if ($action == "agregarSolicitud")
	{
		agregarSolicitud(); //modificar ya que missia pase la correccion del SP
	}
	else if ($action == "mostrarSolicitudesDept")
	{
		//
	}
	else if ($action == "mostrarSolicitudesUsuario")
	{
		//
	}
	else if ($action == "autorizarSolicitud")
	{
		autorizarSolicitud();
	}
	else if ($action == "cargarUsuario")
	{
		cargarUsuario();
	}
	else if($action == "uploadImage")
	{
		uploadImage();
	}
	else
	{
		echo 'lel';
	}

	function connect() {
		$databasehost = "localhost";
		$databasename = "programacionmultimedia";
		$databaseuser = "usuarioPM";
		$databasepass = "Zelda2_34";

		$mysqli = new mysqli($databasehost, $databaseuser, $databasepass, $databasename);
		if ($mysqli->connect_errno) {
			echo "Problema con la conexion a la base de datos";
		}
		return $mysqli;
	}

	function disconnect($mysqli) {
		mysqli_close($mysqli);
	}
	
	function imagen()
	{
		$imgid = $_GET['imgid'];
		$mysqli = connect();
		$sql = "SELECT fotoUsuario FROM usuario WHERE idUsuario = ".$imgid.";";
		$sth = $mysqli->query($sql);
		if(!$sth)
		{
			echo -1;
		}
		else
		{
			$result=mysqli_fetch_array($sth,MYSQLI_NUM);
			echo $result[0];
		}
	}
	
	function login()
	{
		$user = $_POST["usuario"];
		$pass = $_POST["contrasenia"];
		$mysqli = connect();

		$result = $mysqli->query("call sp_iniciarSesion('".$user."','".$pass."');");
		if (!$result) {
			echo "Problema al hacer un query: " . $mysqli->error;
		}
		else
		{
			$row=mysqli_fetch_array($result,MYSQLI_NUM);
			if($row[0]>0)
			{
				session_start();
				$_SESSION["idUsuario"] = $row[0];
				$_SESSION["nombreUsuario"] = $row[1];
				$_SESSION["apellidosUsuario"] = $row[2];
				$_SESSION["numeroEmpleado"] = $row[3];
				$_SESSION["correoUsuario"] = $row[4];
				$_SESSION["puestoUsuario"] = $row[5];
				$_SESSION["saldoUsuario"] = $row[6];
				$_SESSION["idDepartamento"] = $row[7];
				$_SESSION["idEmpresa"] = $row[8];
				$_SESSION["onboarding"] = $row[9];
				if($_SESSION["puestoUsuario"]=="administrador")
				{
					echo 1;
				}
				else
				{
					echo 2;
				}
			}
			else
			{
				echo -1;
			}
		}
	}
	
	function cargarUsuario()
	{
		$user = $_POST["usuario"];
		$pass = $_POST["contrasenia"];
		$mysqli = connect();
		$result = $mysqli->query("call sp_iniciarSesion('".$user."','".$pass."');");
		
		if (!$result) {
			echo -1;
		} else {
			$rows = array();
			while( $r = $result->fetch_assoc()) {
				$rows[] = $r;
			}			
			echo json_encode($rows);
		}
		//$result->free();
		disconnect($mysqli);
	}
	
	function registro()
	{
		$username = $_POST["usuario"];
		$password = $_POST["contrasenia"];
		$userlastname = $_POST["apellido"];
		$usermail = $_POST["correo"];
		
		$mysqli = connect();

		$result = $mysqli->query("select idUsuario from usuario where correoUsuario = '".$usermail."';");
		
		if(!$result)
		{
			echo -5;
		}
		else
		{
			$row=mysqli_fetch_array($result,MYSQLI_NUM);
			if($row[0]>0)
			{
				echo -6;
			}
			else
			{
				disconnect($mysqli);
				$mysqli = connect();
				
				$result = $mysqli->query("call sp_altaUsuario('".$username."','".$userlastname."','".$password."','".$usermail."');");
				if (!$result) {
					//echo "Problema al hacer un query: " . $mysqli->error;
					echo -1;
				}
				else
				{
					disconnect($mysqli);
					$mysqli = connect();
					
					$result2 = $mysqli->query("call sp_iniciarSesion('".$usermail."','".$password."');");
					if (!$result2) {
						echo -2;
					}
					else
					{
						$row2 = mysqli_fetch_array($result2,MYSQLI_NUM);
						if($row2[0]>0)
						{
							$idusuario = $row2[0];
							
							disconnect($mysqli);
							$mysqli = connect();
							
							$result3 = $mysqli->query("call sp_cambiarRolUsuario(".$idusuario.",'administrador');");
							if(!$result3)
							{
								echo -4;
							}
							else
							{
								echo $idusuario;
							}
						}
						else
						{
							echo -3;
						}
					}
				}
			}
		}
	}
	
	function checkOnBoarding()
	{
		$userid = $_POST["usuario"];
		$mysqli = connect();

		$result = $mysqli->query("call sp_completoOnboarding(".$userid.");");
		if (!$result) {
			echo "Problema al hacer un query: " . $mysqli->error;
		}
		else
		{
			echo 1;
		}
	}
	
	function autorizarSolicitud()
	{
		$solicitud = $_POST["solicitud"];
		$nuevoEstado = $_POST["nuevoEstado"];
		$mysqli = connect();

		$result = $mysqli->query("call sp_autorizarSolicitud(".$solicitud.",".$nuevoEstado.");");
		if (!$result) {
			echo "Problema al hacer un query: " . $mysqli->error;
		}
		else
		{
			echo 1;
		}
	}
	
	function agregarSolicitud()
	{
		$fechaInicio = $_POST["fechaInicio"];
		$fechaFin = $_POST["fechaFin"];
		$usuarioid = $_POST["usuario"];
		$mysqli = connect();

		$result = $mysqli->query("call sp_registrarSolicitud('".$fechaInicio."','".$fechaFin."',".$usuarioid.","."5,0".");");
		if (!$result) {
			echo "Problema al hacer un query: " . $mysqli->error;
		}
		else
		{
			echo 1;
		}
	}
	
	function uploadImage()
	{
		if(isset($_FILES['photo']))
		{
			$tmpName  = $_FILES['photo']['tmp_name'];
			$userid = $_POST['idusuario'];

			$mysqli = connect();
			
			$stmt = $mysqli->prepare("call sp_subirImagenUsuario(?,?);");
			$null = NULL;
			$stmt->bind_param("ib",$userid,$null);
			$stmt->send_long_data(1, file_get_contents($tmpName));
			
			$stmt->execute();
			$check = mysqli_stmt_affected_rows($stmt);
			
			if($check!=1)
			{
				//echo $sql;
				echo -2;
			}
			else
			{
				echo 1;
			}
		}
		else
		{
			echo -1;
		}
	}
?>