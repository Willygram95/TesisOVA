<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';	
	include 'funciones/funciones.php';
	$id = $_GET['id'];
	$sql = "SELECT * FROM ovaareasc WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
?>
<html lang="es">
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Modificación de Área de Conocimiento</title>
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
						<div class="container tituloadmin">Administración de Áreas de Conocimiento</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row areasuperioradmin">
				<div id="signupbox" class="col-lg-12">
					<div class="formulario">
						<div id="cabeceraformulario" class="modificacion">
							<div class="">Modificación de área de conocimiento</div>
						</div>  
					<div class="panel-body" >	
						<form class="form-horizontal" method="POST" action="actualizarareac.php" autocomplete="off">
							<div class="form-group">
								<label for="titulo" class="col-md-3 control-label">Título</label>
								<div class="col-md-9">
									<input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título" value="<?php echo $row['titulo']; ?>" required>
								</div>
							</div>
							<input type="hidden" id="id" name="id" value="<?php echo $row['id']; ?>" />
							<div class="form-group">
								<label for="status" class="col-md-3 control-label">Status</label>
								<div class="col-md-9">
									<label class="radio-inline">
										<input type="radio" id="status" name="status" value="1" <?php if($row['status']=='1') echo 'checked'; ?>> Activo
									</label>
									<label class="radio-inline">
										<input type="radio" id="status" name="status" value="0" <?php if($row['status']=='0') echo 'checked'; ?>> Inactivo
									</label>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-3 col-md-9">									
									<button type="submit" class="btn">Guardar</button>
									<a href="administrarareasc.php" class="btn">Cancelar</a>
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
						<p ALIGN="justify">Esta área se encarga de <b>Modificación de área de conocimiento</b>, el cual consiste en editar las áreas del OVA que están registrada.</p><br/>
						<p ALIGN="justify">En caso de no realizar ningún registro, se puede regresar al contenido y salir del área. </p>
						      <p ALIGN="justify">Dándole clic en "<b><FONT SIZE=5> < </font></b>" al lado de la palabra <b>Tema</b>, del lado izquierdo del área central. </p><br/>
					</div>
				</div>
			</div>
		</div>	
	</body>
</html>							