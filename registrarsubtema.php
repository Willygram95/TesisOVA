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
		$titulo = $mysqli->real_escape_string($_POST['titulo']);
		$contenido = $_POST['contenido'];
		$id_tema = $mysqli->real_escape_string($_POST['id']);
		$status = 0;
		if(isNullsubtema($titulo))
		{
			$errores[] = "Debe ingresar al menos el título del subtema";
		}
		if(count($errores) == 0)
		{
			$registro = registraSubTema($titulo, $contenido, $id_tema, $status);			
			if($registro > 0) { 
				$_SESSION['tipomensajedevuelto']='exito';
				$_SESSION['mensajedevuelto']='Subtema registrado exitosamente';
				$vloc="Location: temaregistrado.php?id=".$id_tema;
				header($vloc);
				}else{
				$_SESSION['tipomensajedevuelto']='error';
				$_SESSION['mensajedevuelto']='Error al registrar el subtema';
				$errores[] = "Error al registrar el subtema";
				$vloc="Location: temaregistrado.php?id=".$id_tema;
				header($vloc);
			}	
		}
	}
	$where = "";
	$sql = "SELECT * FROM tema $where";
	$resultado = $mysqli->query($sql);
	
	$sqltm = "SELECT titulo FROM ovatemas WHERE id = '$id_tema'";
	$resultadotm = $mysqli->query($sqltm);
	$rowtm = $resultadotm->fetch_array(MYSQLI_ASSOC);	
?>
<html>
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Registro de Subtema</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="static/css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/ovamiestilo.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/colores.php">
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js" ></script>
		<?php 
			insertareditor("contenido");
		?>			
	</head>
	
	<body class="bodyadmin">
		<div class="container-fluid">
			<?php echo MenuPrincipal("contenido"); ?>	
			<div class="row">
				<div class="imgslidertmcn">					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 secciontitulos secciontitulosadmin">
						<div class="container tituloadmin">Administración de Subtemas</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row areasuperioradmin">
				<div class="container infotemaaux">
					<div class="row titulodetemaadmin">
						<a href="temaregistrado.php?id=<?php echo $id_tema; ?>" data-toggle="tooltip" title="Regresar"><span class="glyphicon glyphicon-chevron-left"></span></a>
						Tema: <span><?php echo $rowtm['titulo']; ?></span>
					</div>
				</div>
			<div id="signupbox" class="col-lg-12">
				<div class="formulario">
					<div id="cabeceraformulario" class="">
						<div class="">Registro de subtema</div>
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
								<label for="contenido" class="col-md-3 control-label">Contenido</label>
								<div class="col-md-9">
									<textarea rows="20" class="form-control enunciadolargo" id="contenido" name="contenido" placeholder="Contenido"><?php if(isset($contenido)) echo $contenido; ?></textarea>
								</div>
							</div>
							<input type="hidden" id="id" name="id" value="<?php echo $id_tema; ?>" />							
							<div class="form-group">                             
								<div class="col-md-offset-3 col-md-9">
									
									<button id="btn-signup" type="submit" class="btn"><i class="icon-hand-right"></i>Registrar</button> 
									<a href="temaregistrado.php?id=<?php echo $id_tema; ?>" class="btn">Cancelar</a>
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
						<p ALIGN="justify">Esta área se encarga de <b>Registro de subtemas</b>, el cual consiste en llenar los datos para estructurar el contenido.</p>
						<p ALIGN="justify">El área central de la página le muestra el formulario con los item necesario para el registro, los cuales son:</p><br/>
							  
							  <p ALIGN="justify"><b>Título:</b> el nombre del subtema.</p>
							  <p ALIGN="justify"><b>Contenido:</b> contenido del desarrollo del subtema.</p><br/>
							  <p ALIGN="justify"> Luego se le da clic al botón <b>Registrar</b> para guardar el contenido o <b>Cancelar</b> para salir del formulario.</p><br/>
							  <p ALIGN="justify">En caso de no realizar ningún registro, se puede regresar al contenido y salir del área. </p>
						      <p ALIGN="justify">Dándole clic en "<b><FONT SIZE=5> < </font></b>" al lado de la palabra <b>Tema</b>, del lado izquierdo del área central. </p><br/>
					</div>
				</div>
			</div>
		</div>	
				</body>
				</html>																																																																					