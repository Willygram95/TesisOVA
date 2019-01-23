<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	require 'funciones/funciones.php';		
	
	$orden="nombre";	
	if(!empty($_GET))
	{
		$cualtm=$_GET['id'];
		$orden=$_GET['orden'];
		if(empty($orden)){
			$orden="nombre";
		}
	}
	$sql = "SELECT id, titulo FROM ovatemas WHERE id=$cualtm";
	$resultado = $mysqli->query($sql);
	$_SESSION['cualtu']="";	
	
	$sqltc = "SELECT * FROM ovaimagenes WHERE id_tema='$cualtm' ORDER BY $orden";
	$resultadotc = $mysqli->query($sqltc);
?>
<html lang="es">
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Administración de Imágenes</title>
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
						<div class="container tituloadmin">Administración de Imágenes</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row areasuperioradmin">
				<div class="container">
					<div class="row titulodetemaadmin">
						<a href="administrartemas.php" data-toggle="tooltip" title="Regresar"><span class="glyphicon glyphicon-chevron-left"></span></a>
						<?php $row = $resultado->fetch_array(MYSQLI_ASSOC) ?>							
						Tema: <span><?php echo $row['titulo']; ?></span>
					</div>
				</div>
				<div class="row">			
					<div class="col-lg-4 col-md-4 col-sm-2 text-left">
						<div class="row">
							<div class="col-lg-4">
								<a href="registrarimagen.php?id=<?php echo $row['id']; ?>" class="btn botonnuevo">Nueva imagen</a>	
							</div>	
						</div>
					</div>				
				</div>	
			</div>	
		</div>
		<div class="container contenedortabla">
			<div class="row table-responsive tablacentrada">
				<table id="timagenes" class="table table-striped">
					<thead>
						<tr>
							<th><a href="administrarimagenes.php?orden=nombre&id=<?php echo $cualtm;?>">Nombre</a></th>
							<th><a href="administrarimagenes.php?orden=imagen&id=<?php echo $cualtm;?>">Imagen</a></th>
							<th><a href="administrarimagenes.php?orden=nombreoriginal&id=<?php echo $cualtm;?>">Nombre de archivo</a></th>
							<th><a href="administrarimagenes.php?orden=tipo&id=<?php echo $cualtm;?>">Tipo</a></th>
							<th><a href="administrarimagenes.php?orden=ancho&id=<?php echo $cualtm;?>">Ancho</a></th>
							<th><a href="administrarimagenes.php?orden=alto&id=<?php echo $cualtm;?>">Alto</a></th>							
							<th><a href="administrarimagenes.php?orden=tamano&id=<?php echo $cualtm;?>">Tamaño</a></th>
							<th></th>
							<th></th>
						</tr>						
					</thead>
					<tbody>
					<?php $numero_filas = $resultadotc->num_rows; if($numero_filas<=0){echo "<tr><td class='listadovacio'>El listado está vacío</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";}else{?>						
						<?php while($rowtc = $resultadotc->fetch_array(MYSQLI_ASSOC)) { ?>							
							<tr>								
								<td><?php echo $rowtc['nombre']; ?></td>
								<!--<td id="<?php echo $rowtc['nombre']; ?>"><a onmousedown="clickimagen.call(this,event)" href="#" data-toggle="modal" data-target="#mdimagen"><?php echo "<img src='mostrarimagen.php?id=".$rowtc['id']."' height='150'>";?></a></td>-->
								<td><?php echo "<img class='img-responsive' src='mostrarimagen.php?id=".$rowtc['id']."' width='200' height='150'>";?></td>
								<td><?php echo $rowtc['nombreoriginal']; ?></td>
								<td><?php echo cualtipoimagen($rowtc['tipo']); ?></td>
								<td><?php echo $rowtc['ancho']." px"; ?></td>
								<td><?php echo $rowtc['alto']." px"; ?></td>
								<td><?php echo tamanoimagen($rowtc['tamano'])." KB"; ?></td>
								<td><a href="modificarimagen.php?id=<?php echo $rowtc['id']; ?>&tm=<?php echo $cualtm; ?>" data-toggle="tooltip" title="Editar imagen"><span class="glyphicon glyphicon-pencil"></span></a></td>
								<td><span data-toggle="tooltip" title="Eliminar imagen"><a href="#" data-href="eliminarimagen.php?id=<?php echo $rowtc['id']; ?>&tm=<?php echo $cualtm; ?>" data-toggle="modal" data-target="#confirm-delete"><span class="glyphicon glyphicon-trash"></span></a></span></td>
							</tr>
						<?php } } ?>
					</tbody>
				</table>
			</div>
			</div>	
			<!--<script>
				function clickimagen(event) {
				var fila = this.parentNode;
				clickid=fila.id;
				}
			</script>-->
			<!-- Modal -->
			<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel">Eliminar imagen</h4>
						</div>
						<div class="modal-body">
							¿Desea eliminar esta imagen?
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							<a class="btn btn-danger btn-ok">Eliminar</a>
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
			<!-- Modal -->
			<div class="modal fade" id="mdimagen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel">Imagen</h4>
						</div>
						<div class="modal-body">
							<!--<?php 
								$variablePHP = "<script>function clickimagen(event) {var fila = this.parentNode;clickid=fila.id;document.write(clickid);}</script>";
								echo "variablePHP = ".$variablePHP;
							echo "<img src='mostrarimagen.php?id=".$rowtc['id']."' height=".$rowtc['alto'].">";?>-->
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
			<!-- <script>
				$(document).ready(function(){
					$('[data-toggle="tooltip"]').tooltip();   
				});
			</script> -->
		</body>
	</html>																																																											