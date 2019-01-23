<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';	
	require 'funciones/funciones.php';	
	
	$id = $_GET['id'];
	$sql = "SELECT id,titulo,titulovideo,enlacevideo FROM ovatemas WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
?>
<html lang="es">
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Administración de Video</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="static/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="css/ovamiestilo.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/colores.php">
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js"></script>	
	</head>
	
	<body class="bodyadmin">
		<div class="container-fluid">
			<?php echo MenuPrincipal("contenido"); ?>	
			<div class="row">
				<div class="imgslidertmcn">					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 secciontitulos secciontitulosadmin">
						<div class="container tituloadmin">Administración de Video</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row areasuperioradmin">
				<div class="container infotemaaux">
					<div class="row titulodetemaadmin">
						<a href="administrarenlaces.php?id=<?php echo $row['id'];?>" data-toggle="tooltip" title="Regresar"><span class="glyphicon glyphicon-chevron-left"></span></a>
						Tema: <span><?php echo $row['titulo']; ?></span>
					</div>
				</div>
				<div id="signupbox" class="col-lg-12">
					<div class="formulario">
						<div id="cabeceraformulario">
							<div>Modificación de video</div>
						</div>   
					<div class="panel-body" >	
						<form class="form-horizontal" method="POST" action="actualizarvideo.php" autocomplete="off">
							<div class="form-group">
								<label for="titulovideo" class="col-md-3 control-label">Título del video</label>
								<div class="col-md-9">
									<input type="text" class="form-control" id="titulovideo" name="titulovideo" placeholder="Título del video" value="<?php echo $row['titulovideo']; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="enlacevideo" class="col-md-3 control-label">Enlace del video</label>
								<div class="col-md-9">
									<input type="text" class="form-control" id="enlacevideo" name="enlacevideo" placeholder="Enlace del video" value="<?php echo $row['enlacevideo']; ?>">
								</div>
							</div>
							<input type="hidden" id="id" name="id" value="<?php echo $row['id']; ?>" />
							<div class="form-group">
								<div class="col-md-offset-3 col-md-9">									
									<button type="submit" class="btn">Guardar</button>
									<a onclick="borrar();" href="#" class="btn btnborrar">Borrar</a>								
									<a href="administrarenlaces.php?id=<?php echo $row['id'];?>" class="btn">Cancelar</a>
								</div>
							</div>
						</form>
					</div>
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
						<p ALIGN="justify">Esta área se encarga de <b>Registro de video</b>, el cual consiste en llenar los datos del enlace de video.</p>


							  <p ALIGN="justify">El área central de la página le muestra el formulario con los item necesario para el registro, los cuales son:</p><br/>
							  
							  <p ALIGN="justify"><b>Título del video:</b> el nombre del enlace de video.</p>
							  <p ALIGN="justify"><b>Enlace del video:</b> Dirección del enlace de video en Youtube.</p><br/>
							  
							  <p ALIGN="justify"> Luego se le da clic al botón <b>Registrar</b> para guardar el contenido, <b>Borrar</b> para limpiar los campos o <b>Cancelar</b> para salir del formulario.</p>
					</div>
				</div>
			</div>
		</div>	
		<script>
			function borrar(){
				var campoeste = document.getElementById("titulovideo");
				campoeste.value="";
				var campoeste = document.getElementById("enlacevideo");
				campoeste.value="";
			}
		</script>	
	</body>
</html>																																						