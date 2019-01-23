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
		$autor = $mysqli->real_escape_string($_POST['autor']);
		$info = $mysqli->real_escape_string($_POST['info']);
		if(isNullbibliografia($titulo,$autor,$info))
		{
			$errores[] = "Debe llenar todos los campos";
		}
		if(count($errores) == 0)
		{
			$registro = registraBibliografia($titulo, $autor, $info);			
			if($registro > 0) { 
				$_SESSION['tipomensajedevuelto']='exito';
				$_SESSION['mensajedevuelto']='Libro registrado exitosamente';
				}else{
				$_SESSION['tipomensajedevuelto']='error';
				$_SESSION['mensajedevuelto']='Error al registrar el libro';
				$errores[] = "Error al registrar el libro";
			}	
			header("Location: administrarbibliografia.php");
		}
	}
?>
<html>
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Registro de Bibliografía</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="static/css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/ovamiestilo.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/colores.php">
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js" ></script>		
		<?php 
			insertareditor("info");
		?>	
	</head>
	
	<body class="bodyadmin">
		<div class="container-fluid">
			<?php echo MenuPrincipal("contenido"); ?>	
			<div class="row">
				<div class="imgslidertmcn">					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 secciontitulos secciontitulosadmin">
						<div class="container tituloadmin">Administración de Bibliografía</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row areasuperioradmin">
				<div id="signupbox" class="col-lg-12">
					<div class="formulario">
						<div id="cabeceraformulario" class="">
							<div class="">Registro de referencia</div>
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
								<label for="autor" class="col-md-3 control-label">Autor(es)</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="autor" placeholder="Autor(es)" value="<?php if(isset($autor)) echo $autor; ?>" required >
								</div>
							</div>
							<div class="form-group">
								<label for="info" class="col-md-3 control-label">Más info</label>
								<div class="col-md-9">
									<textarea rows="20" class="form-control enunciadocorto" id="info" name="info" placeholder="Más info"><?php if(isset($info)) echo $info; ?></textarea>
								</div>
							</div>
							<div class="form-group">                             
								<div class="col-md-offset-3 col-md-9">									
									<button id="btn-signup" type="submit" class="btn"><i class="icon-hand-right"></i>Registrar</button>
									<a href="administrarbibliografia.php" class="btn">Cancelar</a> 
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
						<p ALIGN="justify">Esta área se encarga de <b>Registro de referencia</b>, el cual consiste en llenar los datos para editar las bibliografías.</p>
						<p ALIGN="justify">El área central de la página le muestra el formulario con los item necesario para el registro, los cuales son:</p><br/>
							  
							  <p ALIGN="justify"><b>Título:</b> el nombre de la referencia bibliográfica.</p>
							  <p ALIGN="justify"><b>Autores:</b> se coloca el autor bibliográfico.</p>
							  <p ALIGN="justify"><b>Más info:</b> se coloca la descripción de la bibliografía.</p><br/>
							  <p ALIGN="justify"> Luego se le da clic al botón <b>Registrar</b> para guardar el contenido o <b>Cancelar</b> para salir del formulario.</p><br/>
							  <p ALIGN="justify">En caso de no realizar ningún registro, se puede regresar al contenido y salir del área. </p>
						      <p ALIGN="justify">Dándole clic en "<b><FONT SIZE=5> < </font></b>" al lado de la palabra <b>Tema</b>, del lado izquierdo del área central. </p><br/>
					</div>
				</div>
			</div>
		</div>	
	</body>
</html>																																																		