<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';	
	require 'funciones/funciones.php';	
	
	$id_tema = $_GET['id'];
	$sql = "SELECT id,titulo FROM ovatemas WHERE id = '$id_tema'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
	
	$sqlpdf = "SELECT * FROM ovaarchivos WHERE id_tema = '$id_tema'";
	$resultadopdf = $mysqli->query($sqlpdf);
	$rowpdf = $resultadopdf->fetch_array(MYSQLI_ASSOC);
	$numfilaspdf=$resultadopdf->num_rows;
?>
<html lang="es">
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Inserción/Modificación de PDF</title>
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
						<div class="container tituloadmin">Administración de PDF</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row areasuperioradmin">
				<div class="container infotemaaux">
					<div class="row titulodetemaadmin">
						<a href="administrartemas.php" data-toggle="tooltip" title="Regresar"><span class="glyphicon glyphicon-chevron-left"></span></a>
						Tema: <span><?php echo $row['titulo']; ?></span>
					</div>
				</div>
				<div id="signupbox" class="col-lg-12">
					<div class="formulario">
						<div id="cabeceraformulario">
							<div>Inserción/modificación de PDF</div>
						</div> 
					<div class="panel-body" >	
						<form class="form-horizontal" enctype="multipart/form-data" method="POST" action="actualizarPDF.php" autocomplete="off">
							<div class="form-group">
								<label for="preview" class="col-md-3 control-label"><?php if ($numfilaspdf>0){echo $rowpdf['nombreoriginal'];}else{echo "No hay PDF asociado";}?></label>
								<div class="col-md-9">
									<?php if ($numfilaspdf>0){?><span data-toggle="tooltip" title="Eliminar PDF"><a href="#" data-href="eliminarPDF.php?id=<?php echo $rowpdf['id']; ?>" data-toggle="modal" data-target="#confirm-delete"><p class="eliminar">Eliminar PDF</p></a></span><? } ?>
								</div>
							</div>							
							<div class="form-group">
								<label for="userfile" class="col-md-3 control-label">PDF</label>
								<div class="col-md-9">
									<input class="form-control" name="userfile" type="file">
								</div>
							</div>
							<div class="form-group">
								<label for="nombre" class="col-md-3 control-label">Nombre</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php echo $rowpdf['nombre'] ?>" required>
								</div>
							</div>
							<input type="hidden" id="id" name="id" value="<?php echo $rowpdf['id']; ?>" />
							<input type="hidden" id="id_tema" name="id_tema" value="<?php echo $id_tema; ?>" />	
							<div class="form-group">                             
								<div class="col-md-offset-3 col-md-9">									
									<button type="submit" class="btn">Guardar</button>
									<a href="administrartemas.php" class="btn">Cancelar</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Eliminar PDF</h4>
					</div>
					<div class="modal-body">
						¿Desea eliminar este PDF?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<a class="btn btn-danger btn-ok">Eliminar</a>
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
						<p ALIGN="justify">Esta área se encarga de <b>Inserción/Modificación de PDF</b>, el cual consiste en llenar los datos del archivo de PDF referente al OVA y cargarlo a la página.</p>


							  <p ALIGN="justify">El área central de la página le muestra el formulario con los item necesario para el registro, los cuales son:</p><br/>
							  
							  <p ALIGN="justify"><b>PDF:</b> Selecciona el archivo PDF en el directorio.</p>
							  <p ALIGN="justify"><b>Nombre:</b> Nombre del archivo en PDF.</p><br/>
							  
							  <p ALIGN="justify"> Luego se le da clic al botón <b>Registrar</b> para guardar el contenido o <b>Cancelar</b> para salir del formulario.</p><br/>
							  <p ALIGN="justify">En otro caso, si ya esta insertado el archivo la página muestra el nombre del archivo PDF cargado y seguido la opción eliminar, si el usuario desea borrar e insertar otro.</p>

							  		<p ALIGN="justify">En caso de no realizar ningún registro, se puede regresar al contenido y salir del área. </p>
						      <p ALIGN="justify">Dándole clic en "<b><FONT SIZE=5> < </font></b>" al lado de la palabra <b>Tema</b>, del lado izquierdo del área central. </p><br/>
					</div>
				</div>
			</div>
		</div>		
		<script>
			$('#confirm-delete').on('show.bs.modal', function(e) {
				$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
				$('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
			});
		</script>
		<!-- <script>
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();   
			});
		</script> -->
	</body>
</html>																																						