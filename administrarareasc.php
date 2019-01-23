<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	require 'funciones/funciones.php';		
	
	
	$orden="titulo";
	if(!empty($_GET))
	{
		$orden=$_GET['orden'];
		if(empty($orden)){
			$orden="titulo";
		}
	}
	$where = "";
	$sql = "SELECT * FROM ovaareasc $where ORDER BY $orden ASC";
	$resultado = $mysqli->query($sql);
	$_SESSION['cualtu']="";
	$_SESSION['cualareac']="";	
	$sqlas = "SELECT * FROM ovaasignatura";
	$resultadoas = $mysqli->query($sqlas);
	$rowas = $resultadoas->fetch_array(MYSQLI_ASSOC);
?>
<html lang="es">
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Administración de Áreas de Conocimiento</title>
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
						<div class="container tituloadmin">Administración de Áreas de Conocimiento</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row areasuperioradmin">
				<div class="col-lg-4 col-md-4 col-sm-2 col-xs-12 text-left colseguntam">
					<div class="row">
						<div class="col-lg-12">
							<a href="registrarareac.php" class="btn botonnuevo btnseguntam">Nuevo área de conocimiento</a>
						</div>	
					</div>
				</div>	<?php if($resultado->num_rows>0){?>
				<div class="col-lg-8 col-md-8 col-sm-10 text-right colseguntam">
					<div class="row">		
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right colseguntam">	
							<a href="ordenar.php?qo=ac&to=OVA" class="btn botonbuscar btnseguntam">Ordenar áreas de conocimiento</a>
						</div>
					</div>
				</div>					
				<?php } ?>
			</div>
		</div>
		<div class="container">
			<div class="contenedortabla">
				<div class="row table-responsive tablacentrada">
					<table class="table table-striped">
						<thead>
							<tr>
								<th><a href="administrarareasc.php?orden=titulo">Título</a></th>
								<th class="colstatus"><a href="administrarareasc.php?orden=status">Status</a></th>
								<th></th>
								<th></th>
								<th></th>								
							</tr>						
						</thead>
						<tbody id="tfilas">		
						<?php $numero_filas = $resultado->num_rows; if($numero_filas<=0){echo "<tr><td class='listadovacio'>El listado está vacío</td><td></td><td></td><td></td><td></td></tr>";}else{?>		
							<script>var cborrar=[]; nfilaj=1;</script>			
							<?php $nfila=1; while($row = $resultado->fetch_array(MYSQLI_ASSOC)) { ?>							
								<tr>								
									<td><?php echo $row['titulo']; ?></td>
									<td class="colstatus"><a href="cambiarstatusareac.php?id=<?php echo $row['id']; ?>"><span data-toggle="tooltip" title="<?php if($row['status']==0){echo 'Área de conocimiento inactivo';}else{echo 'Área de conocimiento activo';}?>" class=<?php if($row['status']==0){echo '"glyphicon glyphicon-ban-circle"';}else{echo '"glyphicon glyphicon-ok-circle"';}?>></span></a></td>
									<td><a href="administrartemas.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" title="Administrar temas del área de conocimiento"><span class="glyphicon glyphicon-th-large"></span></a></td>
									<td><a href="modificarareac.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" title="Editar área de conocimiento"><span class="glyphicon glyphicon-pencil"></span></a></td>
									<td><span data-toggle="tooltip" title="Eliminar área de conocimiento"><a href="#" data-href="eliminarareac.php?id=<?php echo $row['id']; ?>&orden=<?php echo $row['orden']; ?>" data-toggle="modal" data-target="#confirm-delete"><span id="fila<?php echo $nfila; ?>" class="glyphicon glyphicon-trash"></span></a></span></td>
								</tr>
								<script>cborrar[nfilaj]="<?php echo $row['titulo'];?>"; nfilaj=nfilaj+1;</script>
							<?php $nfila=$nfila+1;} } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
			<!-- Modal -->
			<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel">Eliminar área de conocimiento</h4>
						</div>
						<div class="modal-body">
							<span id="elmsj"></span>
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

				 $('#tfilas').click(function(e){
				    var id = e.target.id;
				    var res = id.split("fila");
				    document.getElementById("elmsj").innerHTML = "¿Desea eliminar el área de conocimiento <strong>"+cborrar[res[1]]+"</strong>?";
				});		
			</script>	
			<!-- Modal -->
			<div class="modal fade" id="mdprerequisitos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel">Prerequisitos</h4>
						</div>
						<div class="modal-body">
							<?php echo $rowas['prerequisitos']; ?>
						</div>
					</div>
				</div>
			</div>		
			<!-- Modal -->
			<div class="modal fade" id="mdprograma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel">Contenido programático</h4>
						</div>
						<div class="modal-body">
							<?php echo $rowas['programa']; ?>
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
						<p ALIGN="justify">Esta área se encarga de <b>Administración de áreas de conocimiento</b>, el cual consiste en editar los datos de las áreas en las que se clasifica los temas del OVA.</p>

						      <p ALIGN="justify">Al darle clic en <b>Nueva área de conocimiento</b>, luego llenará el formulario correspondiente.</p>

						      <p ALIGN="justify">Pase el cursor por los iconos de edición de las áreas registradas, luego éste le muestra el significado o su función. </p>
						      <p ALIGN="justify">El botón <b>Ordenar áreas de conocimiento</b>, permite ordenar las áreas como quiere que aparezcan en el inicio. </p>
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