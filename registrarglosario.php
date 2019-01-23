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
		$termino = $mysqli->real_escape_string($_POST['termino']);
		$definicion = $_POST['definicion'];
		if(isNullglosario($termino,$definicion))
		{
			$errores[] = "Debe llenar todos los campos";
		}
		if(terminoExiste($termino))
		{
			$errores[] = "El término $termino ya existe en el glosario";
		}
		if(count($errores) == 0)
		{
			$registro = registraGlosario($termino, $definicion);			
			if($registro > 0) { 
				$_SESSION['tipomensajedevuelto']='exito';
				$_SESSION['mensajedevuelto']='Término registrado exitosamente';
				}else{
				$_SESSION['tipomensajedevuelto']='error';
				$_SESSION['mensajedevuelto']='Error al registrar el término';
				$errores[] = "Error al registrar el término";
			}	
			header("Location: administrarglosario.php");
		}
	}
?>
<html>
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Registro de Glosario</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="static/css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/ovamiestilo.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/colores.php">
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js" ></script>
		<?php 
			insertareditor("definicion");
		?>	
		
	</head>
	
	<body class="bodyadmin">
		<div class="container-fluid">
			<?php echo MenuPrincipal("contenido"); ?>	
			<div class="row">
				<div class="imgslidertmcn">					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 secciontitulos secciontitulosadmin">
						<div class="container tituloadmin">Administración de Glosario</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row areasuperioradmin">
				<div id="signupbox" class="col-lg-12">
					<div class="formulario">
						<div id="cabeceraformulario" class="">
							<div class="">Registro de término</div>
						</div> 
					<div class="panel-body" >
						<form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
							<div id="signupalert" style="display:none" class="alert alert-danger">
								<p>Error:</p>
								<span></span>
							</div>
							<div class="form-group">
								<label for="termino" class="col-md-3 control-label">Término</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="termino" placeholder="Término" value="<?php if(isset($termino)) echo $termino; ?>" required >
								</div>
							</div>
							<div class="form-group">
								<label for="definicion" class="col-md-3 control-label">Definición</label>
								<div class="col-md-9">
									<textarea rows="20" class="form-control enunciadocorto" id="definicion" name="definicion" placeholder="Definición"><?php if(isset($definicion)) echo $definicion; ?></textarea>
								</div>
							</div>
							<div class="form-group">                             
								<div class="col-md-offset-3 col-md-9">
									
									<button id="btn-signup" type="submit" class="btn"><i class="icon-hand-right"></i>Registrar</button> 
									<a href="administrarglosario.php" class="btn">Cancelar</a>
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
						
						<p ALIGN="justify">Esta área se encarga de <b>Registro de términos</b>, el cual consiste en llenar los datos para editar términos.</p>
						<p ALIGN="justify">El área central de la página le muestra el formulario con los item necesario para el registro, los cuales son:</p><br/>
							  
							  <p ALIGN="justify"><b>Término:</b> el nombre del tema que se va a definir.</p>
							  <p ALIGN="justify"><b>Definición:</b> se coloca el contenido.</p><br/>
							  <p ALIGN="justify"> Luego se le da clic al botón <b>Registrar</b> para guardar el contenido o <b>Cancelar</b> para salir del formulario.</p><br/>
							  <p ALIGN="justify">En caso de no realizar ningún registro, se puede regresar al contenido y salir del área. </p>
						      <p ALIGN="justify">Dándole clic en "<b><FONT SIZE=5> < </font></b>" al lado de la palabra <b>Tema</b>, del lado izquierdo del área central. </p><br/>
					</div>
				</div>
			</div>
		</div>	
	</body>
</html>																																																		