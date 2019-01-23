<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	require 'funciones/funciones.php';		
	
	
	$_SESSION['cualtu']="";
	$_SESSION['cualareac']="";	
	$sqlas = "SELECT * FROM ovaasignatura";
	$resultadoas = $mysqli->query($sqlas);
	$rowas = $resultadoas->fetch_array(MYSQLI_ASSOC);
?>
<html lang="es">
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: <?php if($_SESSION["tipo_usuario"]==1){?>Administración<?php }else{?>Información<?php } ?> de Asignatura</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="static/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="css/ovamiestilo.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/colores.php">
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js"></script>	
	</head>
	
	<body class="bodyadmin">
		<?php if(strlen(trim($_SESSION['tipomensajedevuelto']))){ 
			if($_SESSION['tipomensajedevuelto']=='exito'){ ?>
			<div class="alert alert-success alert-dismissable fade in">
				<?php }else{ ?>
				<div class="alert alert-danger alert-dismissable fade in">
					<?php } ?>
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong><?php echo $_SESSION['mensajedevuelto']; ?></strong>
				</div>	
				<?php $_SESSION['tipomensajedevuelto']=''; } ?>
			</div>
		<div class="container-fluid">
			<?php echo MenuPrincipal("contenido"); ?>	
			<div class="row">
				<div class="imgslidertmcn">					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 secciontitulos secciontitulosadmin">
						<div class="container tituloadmin"><?php if($_SESSION["tipo_usuario"]==1){?>Administración<?php }else{?>Información<?php } ?> de Asignatura</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="static/js/nicEdit/nicEdit.js"></script> 
		<script type="text/javascript">
			//<![CDATA[
			bkLib.onDomLoaded(function() {
				new nicEditor({buttonList : []}).panelInstance('programa');
			});
			//]]>
		</script>
		<div class="container">
			<?php if($_SESSION["tipo_usuario"]==1){?>
			<div class="row areasuperioradmin">				
				<div class="col-lg-4 col-md-4 col-sm-2 text-left">					
					<div class="row">						
						<div class="col-lg-4">
							<a href="modificarasignatura.php" class="btn botonnuevo btnseguntam">Modificar asignatura</a>
						</div>						
					</div>					
				</div>				
			</div>
			<?php } ?>
		</div>
		<div class="container">
			<div class="contenedortabla info">
				<div class="row">
					<div class="col-lg-12">Código: </div><div class="col-lg-12"><?php echo $rowas['codigo']; ?></div>
				</div>
				<div class="row">
					<div class="col-lg-12">Nombre: </div><div class="col-lg-12"><?php echo $rowas['nombre']; ?></div>
				</div>
				<div class="row">
					<div class="col-lg-12">Prerequisitos: </div><div class="col-lg-12"><?php echo $rowas['prerequisitos']; ?></div>
				</div>
				<div class="row">
					<div class="col-lg-12">Contenido programático: </div><div class="col-lg-12"><?php echo $rowas['programa']; ?></div>
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
						<p ALIGN="justify">Esta área se encarga de <b>Administración de asignatura</b>, el cual consiste en editar los datos de la asignatura que corresponde al OVA.</p>

						      <p ALIGN="justify">Al darle clic en <b>Modificar asignatura</b>, activa los campos para editarlos. </p>


					</div>
				</div>
			</div>
		</div>	
	</body>
</html>																																