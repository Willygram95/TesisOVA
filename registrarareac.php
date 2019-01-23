<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$errores = array();
	if(!empty($_POST))
	{
		$titulo = $mysqli->real_escape_string($_POST['titulo']);
		$status = 0;
		if(isNullareac($titulo))
		{
			$errores[] = "Debe ingresar el título del área de conocimiento";
		}
		if(areacExiste($titulo))
		{
			$errores[] = "El nombre $titulo ya existe para otra área de conocimiento";
		}
		if(count($errores) == 0)
		{
			$registro = registraAreac($titulo, $status);			
			if($registro > 0) { 
				$_SESSION['tipomensajedevuelto']='exito';
				$_SESSION['mensajedevuelto']='Área de conocimiento registrado exitosamente';
				}else{
				$_SESSION['tipomensajedevuelto']='error';
				$_SESSION['mensajedevuelto']='Error al registrar el área de conocimiento';
				$errores[] = "Error al registrar el área de conocimiento";
			}	
			header("Location: administrarareasc.php");
		}
	}
?>
<html>
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Registro de Área de Conocimiento</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="static/css/bootstrap.min.css" >
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
						<div class="container tituloadmin">Administración de Áreas de Conocimiento</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row areasuperioradmin">
				<div id="signupbox" class="col-lg-12">
					<div class="formulario">
						<div id="cabeceraformulario" class="">
							<div class="">Registro de  área de conocimiento</div>
						</div>   
					<div class="panel-body" >
						<form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
							<div id="signupalert" style="display:none" class="alert alert-danger">
								<p>Error:</p>
								<span></span>
							</div>
							<div class="form-group">
								<label for="titulo" class="col-md-3 control-label">Título</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="titulo" placeholder="Título" value="<?php if(isset($titulo)) echo $titulo; ?>" required >
								</div>
							</div>
							<div class="form-group">                             
								<div class="col-md-offset-3 col-md-9">									
									<button id="btn-signup" type="submit" class="btn"><i class="icon-hand-right"></i>Registrar</button>
									<a href="administrarareasc.php" class="btn">Cancelar</a>
								</div>
							</div>
						</form>
						<?php echo mostrarErrores($errores); ?>
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
						<p ALIGN="justify">Esta área se encarga de <b>Registro de área de conocimiento</b>, el cual consiste en colocar el título de la nueva área, luego le da clic en registrar.</p>

					  						        
							  <p ALIGN="justify">También se encuentra en la parte superior derecha el botón de <b> Cerrar Sesión </b> para salir de la sessión.</p>
					</div>
				</div>
			</div>
		</div>	
	</body>
</html>																																																		