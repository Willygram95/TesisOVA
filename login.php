<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(isset($_SESSION["id_usuario"])){ //En caso de existir la sesión redireccionamos
		header("Location: areadeusuario.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';
	$errores = array();
	if(!empty($_POST))
	{
		$nick = $mysqli->real_escape_string($_POST['nick']);
		$password = $mysqli->real_escape_string($_POST['password']);
		if(isNullLogin($nick, $password))
		{
			$errores[] = "Debe llenar todos los campos";
		}
		$errores[] = login($nick, $password);	
	}
	$sqlas = "SELECT nombre FROM ovaasignatura";
	$resultadoas = $mysqli->query($sqlas);
	$rowas = $resultadoas->fetch_array(MYSQLI_ASSOC);
	$_SESSION["id_asignatura"]=$rowas['nombre'];
?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<title><?php echo $_SESSION["id_asignatura"];?></title>
		<link rel="stylesheet" href="static/css/bootstrap.min.css" >
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/ovamiestilo.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/colores.php">
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js"></script>	
	</head>
	<body class="bodyadmin">
	<?php echo mostrarErrores($errores); ?>
	<div style="display:none" id="login-alert" class="alert alert-danger"></div>
		<div class="container">    
		<?php echo MenuPrincipal("login"); ?>
			<div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
				<div class="formulariologin" >   
					<div class="panel-body" >						
						<form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
							<div class="input-group areacampotexto">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input id="nick" type="text" class="campotexto" name="nick" value="" placeholder="Nick o email" required>                                 
							</div>
							<div class="input-group areacampotexto">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input id="password" type="password" class="campotexto" name="password" placeholder="Password" required>
							</div>
							<div class="form-group" style="margin-top: 35px">
								<div class="col-sm-12 controls">
									<button id="btn-login" type="submit" class="boton">INICIAR SESIÓN</button>
								</div>
							</div>   
						</form>						
					</div>                     
				</div>  
				</div>
		</div>
		<div class="row">
			<nav class="navbar navbar-inverse navbar-fixed-bottom">
				<div class="container-fluid barrainferior">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbartema">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span> 
						</button>
					</div>
					<div class="collapse navbar-collapse" id="navbartema">
						<ul class="nav navbar-nav menuinferior">
							<li><a href="#" data-toggle="modal" data-target="#mdayuda">Ayuda</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</div>	
		<!-- Modal -->
		<div class="modal fade" id="mdayuda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Ayuda</h4>
					</div>
					<div class="modal-body">
						Aquí va el texto de la ayuda.
					</div>
				</div>
			</div>
		</div>	
	</body>
</html>