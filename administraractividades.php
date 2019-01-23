<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	require 'funciones/funciones.php';		
	
	$orden="enunciado";	
	if(!empty($_GET))
	{
		$cualtm=$_GET['id'];
		$orden=$_GET['orden'];
		if(empty($orden)){
			$orden="enunciado";
		}
	}
	$sql = "SELECT id, titulo FROM ovatemas WHERE id=$cualtm";
	$resultado = $mysqli->query($sql);
	$_SESSION['cualtu']="";	
	
	$sqltc = "SELECT * FROM ovaseleccion WHERE id_tema='$cualtm' AND categoria=1 ORDER BY $orden ASC";
	$resultadotc = $mysqli->query($sqltc);
	
	$sqlte = "SELECT * FROM ovatiposactividades";
	$resultadote = $mysqli->query($sqlte);
	$rowte = $resultadote->fetch_array(MYSQLI_ASSOC);
	
?>
<html lang="es">
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Administración de Actividades</title>
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
						<div class="container tituloadmin">Administración de Actividades</div>
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
					<div class="col-lg-4 col-md-4 col-sm-2 col-xs-12 text-left colseguntam">
						<div class="row">
							<div class="col-lg-12">
								<a href="registraractividad.php?id=<?php echo $row['id']; ?>" class="btn botonnuevo btnseguntam">Nueva actividad</a>
							</div>	
						</div>
					</div>
					<?php if($resultadotc->num_rows>0){?>
					<div class="col-lg-8 col-md-8 col-sm-10 text-right colseguntam">
						<div class="row">		
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right colseguntam">	
								<a href="ordenar.php?qo=at&ct=<?php echo $cualtm; ?>&to=<?php echo $row['titulo']; ?>" class="btn botonbuscar btnseguntam">Ordenar actividades</a>
							</div>
						</div>
					</div>					
					<?php } ?>					
				</div>	
			</div>
		</div>	
			<div class="container contenedortabla">			
				<div class="row table-responsive tablacentrada">
					<table class="table table-striped">
						<thead>
							<tr>
								<th><a href="administraractividades.php?orden=enunciado&id=<?php echo $cualtm;?>">Enunciado</a></th>
								<th><a href="administraractividades.php?orden=tipo&id=<?php echo $cualtm;?>">Tipo</a></th>
								<th><a href="administraractividades.php?orden=numopciones&id=<?php echo $cualtm;?>">Número de opciones</a></th>
								<th></th>
								<th class="colstatus"><a href="administraractividades.php?orden=status&id=<?php echo $cualtm;?>">Status</a></th>
								<th></th>
								<th></th>
							</tr>						
						</thead>
						<tbody id="tfilas">
						<?php $numero_filas = $resultadotc->num_rows; if($numero_filas<=0){echo "<tr><td class='listadovacio'>El listado está vacío</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";}else{?>								
							<?php $nfila=1; while($rowtc = $resultadotc->fetch_array(MYSQLI_ASSOC)) { ?>							
								<tr>								
									<td id="enunciado<?php echo $nfila; ?>"><?php echo $rowtc['enunciado']; ?></td>
									<td><?php $tipoej=$rowtc['tipo']; $sqlte = "SELECT * FROM ovatiposactividades WHERE id=$tipoej";$resultadote = $mysqli->query($sqlte);
									$rowte = $resultadote->fetch_array(MYSQLI_ASSOC);echo $rowte['tipo']; ?></td>									
									<td><?php if($rowtc['tipo']=='1'){echo $rowtc['numopciones'];}else{echo 'No aplica';}?></td>
									<td></td>
									<td class="colstatus"><a href="cambiarstatusactividad.php?id=<?php echo $rowtc['id']; ?>&tm=<?php echo $cualtm; ?>"><span data-toggle="tooltip" title="<?php if($rowtc['status']==0){echo 'Actividad inactiva';}else{echo 'Actividad activa';}?>" class=<?php if($rowtc['status']==0){echo '"glyphicon glyphicon-ban-circle"';}else{echo '"glyphicon glyphicon-ok-circle"';}?>></span></a></td>
									<td><a href="modificaractividad.php?id=<?php echo $rowtc['id']; ?>&tm=<?php echo $cualtm; ?>" data-toggle="tooltip" title="Editar actividad"><span class="glyphicon glyphicon-pencil"></span></a></td>
									<td><span data-toggle="tooltip" title="Eliminar actividad"><a href="#" data-href="eliminaractividad.php?id=<?php echo $rowtc['id']; ?>&tm=<?php echo $cualtm; ?>" data-toggle="modal" data-target="#confirm-delete"><span id="fila<?php echo $nfila; ?>" class="glyphicon glyphicon-trash"></span></a></span></td>
								</tr>
							<?php $nfila=$nfila+1;} } ?>
						</tbody>
					</table>
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
			<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel">Eliminar actividad</h4>
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
				
		<!-- Modal -->
		<div class="modal fade" id="mdayuda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Ayuda</h4>
					</div>
					<div class="modal-body">
						<p ALIGN="justify">Esta área se encarga de <b>Administración de actividad</b>, el cual consiste en editar las actividades del OVA.</p>

						      <p ALIGN="justify">Al darle clic en <b>Nueva actividad</b>, luego se llenará el formulario correspondiente.</p><br/>
						      <p ALIGN="justify">El área central de la página se muestra la serie de actividades registrada.</p><br/>

						      <p ALIGN="justify">Pase el cursor por los iconos de edición de las actividades registrada, éste le muestra el significado o su función. </p><br/>
						      <p ALIGN="justify">El botón <b>Ordenar actividades</b>, permite organizar las actividades por un orden determinado. </p><br/>
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

				$('#tfilas').click(function(e){
				    var id = e.target.id;
				    var res = id.split("fila");
					var txt= "enunciado"+res[1];
					var txt = document.getElementById(txt).innerHTML;
				    document.getElementById("elmsj").innerHTML = "¿Desea eliminar la pregunta con el siguiente enunciado?<br/><br/><strong>"+txt+"</strong>";
				});	
				</script>	
				<!-- <script>
				$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();   
				});
				</script> -->
				</body>
				</html>																																																												