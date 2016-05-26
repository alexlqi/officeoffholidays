<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<link rel="stylesheet" type="text/css" href="css/normalize.css">
  <link rel="stylesheet" type="text/css" href="css/webflow.css">
  <link rel="stylesheet" type="text/css" href="css/officeoff.webflow.css">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
  <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="jqueryui/jquery-ui.min.js"></script>
  <link rel="stylesheet" type="text/css" href="jqueryui/jquery-ui.min.css">
  <link rel="stylesheet" type="text/css" href="jqueryui/jquery-ui.structure.min.css">
  <link rel="stylesheet" type="text/css" href="jqueryui/jquery-ui.theme.min.css">
  <script type="text/javascript" src="js/frontendFunctions.js"></script>
  <script type="text/javascript">
  	$(document).ready(function(e) {
        $(".calendario").datepicker();
    });
  </script>
  <script>
    WebFont.load({
      google: {
        families: ["Merriweather:300,400,700,900","Varela Round:400"]
      }
    });
	$(document).ready(function(){
		console.log($(".calendario"));
		alert();
		
		$(".calendario").datepicker();
		
		if((localStorage.getItem("puesto") === null)||(localStorage.getItem("puesto")==1))
		{
			console.log("logging out");
			logout();
		}
		else
		{
			//cargar info completa de usuario
			loadUser();
			$("#SalirLink").on("click",logout);
			$("#CargarImagenUsuarioEditarLink").on("click",function()
			{
				$("#CargarImagenUsuarioEditarBoton").trigger("click");
			});
			$("#CargarImagenUsuarioEditarBoton").change(newUserPic);
		}
	});
  </script>
  <script type="text/javascript" src="js/modernizr.js"></script>
  <link rel="shortcut icon" type="image/x-icon" href="https://daks2k3a4ib2z.cloudfront.net/img/favicon.ico">
  <link rel="apple-touch-icon" href="https://daks2k3a4ib2z.cloudfront.net/img/webclip.png">
</head>

<body>
<table>
                	<tr>
                    	<th>Tus vacaciones inician el:</th>
                        <th>Tus vacaciones terminan el:</th>
                    </tr>
                    <tr>
                    	<td><div class="calendario inician"></div></td>
                        <td><div class="calendario terminan"></div></td>
                    </tr>
                </table>
</body>
</html>