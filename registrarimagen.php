<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$errores = array();	
	if(!empty($_GET))
	{
		$id_tema=$_GET['id'];
	}
	
	if(!empty($_POST))
	{
		$nombre = $mysqli->real_escape_string($_POST['nombre']);
		$id_tema = $_POST['id'];
		if(isNullnombreimg($nombre))
		{
			$errores[] = "Debe ingresar el nombre de la imagen";
		}
		if(nombreimgExiste($nombre))
		{
			$errores[] = "El nombre $nombre ya está asociado a otra imagen";
		}
		if (is_uploaded_file($_FILES["userfile"]["tmp_name"]))
		{
			if ($_FILES["userfile"]["type"]=="image/jpeg" || $_FILES["userfile"]["type"]=="image/pjpeg" || $_FILES["userfile"]["type"]=="image/gif" || $_FILES["userfile"]["type"]=="image/bmp" || $_FILES["userfile"]["type"]=="image/png")
			{
				$info=getimagesize($_FILES["userfile"]["tmp_name"]);
				$imagenEscapes=$mysqli->real_escape_string(file_get_contents($_FILES["userfile"]["tmp_name"]));
				$ancho=$info[0];
				$alto=$info[1];
				$tipo=$_FILES["userfile"]["type"];
				$imagen=$imagenEscapes;
				$tamano=$_FILES["userfile"]["size"];
				$nombreoriginal=$_FILES["userfile"]["name"];
				}else{
				$errores[] = "El formato de archivo tiene que ser JPG, GIF, BMP o PNG";
			}
		}
		else{
			$errores[] = "Debe insertar una imagen";
		}
		
		if(count($errores) == 0)
		{
			$registro = registraImagen($nombre, $ancho, $alto, $tipo, $imagen, $tamano, $nombreoriginal, $id_tema);	
			
			if($registro) { 
				$_SESSION['tipomensajedevuelto']='exito';
				$_SESSION['mensajedevuelto']='Imagen registrada exitosamente';
				$vloc="Location: administrarimagenes.php?id=".$id_tema;
				header($vloc);
				}else{
				$_SESSION['tipomensajedevuelto']='error';
				$_SESSION['mensajedevuelto']='Error al registrar la imagen';
				$errores[] = "Error al registrar la imagen";
				$vloc="Location: administrarimagenes.php?id=".$id_tema;
				header($vloc);
			}	
		}
	}
	
	$sqltm = "SELECT titulo FROM ovatemas WHERE id = '$id_tema'";
	$resultadotm = $mysqli->query($sqltm);
	$rowtm = $resultadotm->fetch_array(MYSQLI_ASSOC);	
?>
<html>
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Registro de Imagen</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="static/css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/ovamiestilo.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/colores.php">
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js" ></script>		
	</head>
	
	<body class="bodyadmin">
		<div class="container-fluid">
		<?php echo MenuPrincipal("contenido"); ?>	
			<div class="row">
				<div class="imgslidertmcn">					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 secciontitulos secciontitulosadmin">
						<div class="container tituloadmin">Administración de Imágenes</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row areasuperioradmin">
				<div class="container infotemaaux">
					<div class="row titulodetemaadmin">
						<a href="administrarimagenes.php?id=<?php echo $id_tema; ?>" data-toggle="tooltip" title="Regresar"><span class="glyphicon glyphicon-chevron-left"></span></a>
						Tema: <span><?php echo $rowtm['titulo']; ?></span>
					</div>
				</div>
				<div id="signupbox" class="col-lg-12">
				<div class="formulario">
					<div id="cabeceraformulario">
						<div>Registro de imagen</div>
					</div>  
					<div class="panel-body" >
						<form id="signupform" class="form-horizontal" role="form" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST" autocomplete="off">
							<div id="signupalert" style="display:none" class="alert alert-danger">
								<p>Error:</p>
								<span></span>
							</div>
							<div class="form-group">
								<label for="userfile" class="col-md-3 control-label">Imagen</label>
								<div class="col-md-9">
									<input class="form-control" name="userfile" type="file">
								</div>
							</div>
							<div class="form-group">
								<label for="nombre" class="col-md-3 control-label">Nombre</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php if(isset($nombre)) echo $nombre; ?>" required>
								</div>
							</div>
							<input type="hidden" id="id" name="id" value="<?php echo $id_tema; ?>" />							
							<div class="form-group">                             
								<div class="col-md-offset-3 col-md-9">
									
									<button id="btn-signup" type="submit" class="btn"><i class="icon-hand-right"></i>Registrar</button> 
									<a href="administrarimagenes.php?id=<?php echo $id_tema; ?>" class="btn">Cancelar</a>
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
						Aquí va el texto de la ayuda.
					</div>
				</div>
			</div>
		</div>	
	</body>
</html>																																																																												