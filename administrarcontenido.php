<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';	
	require 'funciones/funciones.php';		
	
	$_SESSION['cualtu']="";
	$_SESSION['cualareac']="";		
?>
<html lang="es">
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Administración de Contenido</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="static/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="css/ovamiestilo.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/colores.php">
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js"></script>	
	</head>
	
	<body class="bodyadmin">
		<div class="container">
			<?php echo MenuPrincipal("contenido"); ?>			
			<div class="row">
				<h2 style="text-align:center">Administración de Contenido</h2>
			</div>
			<div class="row">
				<?php if($_SESSION["tipo_usuario"]==1){ ?> <a href="administrarasignatura.php" class="btn btn-primary">Administrar asignatura</a><? } ?>
				<a href="administrarareasc.php" class="btn btn-primary">Administrar áreas de conocimiento</a>				
				<a href="administrartemas.php" class="btn btn-primary">Administrar temas</a>
				<a href="administrarglosario.php" class="btn btn-primary">Administrar glosario</a>
				<a href="administrarbibliografia.php" class="btn btn-primary">Administrar bibliografía</a>
			</div>
			<br>			
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