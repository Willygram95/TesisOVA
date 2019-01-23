<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	require 'funciones/funciones.php';		
	
	
	$orden="titulo";
	if(!empty($_GET))
	{
		$_SESSION['cualareac']=$_GET['id'];
		$orden=$_GET['orden'];
		if(empty($orden)){
			$orden="titulo";
		}
	}
	
	$where = "";	
	if(!empty($_POST))
	{
		$valor = $_POST['termino'];
		if(!empty($valor)){
			$where = "AND ( titulo LIKE '%$valor%' )";
		}
		$valortt = $_POST['id_areac'];	
		if(!empty($valortt) || $valortt=='0'){
			$_SESSION['cualareac']=$valortt;			
		}
	}	
	$cualtt2=$_SESSION['cualareac'];
	if(strlen(trim($cualtt2)) > 0 && $cualtt2!='0'){
		$where2 = "WHERE id_areac = '$cualtt2'";
	}
	else{
		$where2 = "WHERE id_areac LIKE '%'";
	}
	$sql = "SELECT id, titulo, id_areac, status, orden FROM ovatemas $where2 $where ORDER BY $orden ASC";
	$resultado = $mysqli->query($sql);
	
	$sqlac = "SELECT * FROM ovaareasc";
	$resultadoac = $mysqli->query($sqlac);
	
	$eac=$_SESSION['cualareac'];
	$whereac = "WHERE id='$eac'";
	$sac = "SELECT titulo FROM ovaareasc $whereac";
	$rsac = $mysqli->query($sac);	
	$rwac = $rsac->fetch_array(MYSQLI_ASSOC);
	$_SESSION['cualtu']="";	
?>
<html lang="es">
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Administración de Temas</title>
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
						<div class="container tituloadmin">Administración de Temas</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row areasuperioradmin">
				<div class="col-lg-4 col-md-2 col-sm-1 col-xs-12 text-left colseguntam">
					<div class="row">
						<div class="col-lg-12">
							<a href="registrartema.php" class="btn botonnuevo btnseguntam">Nuevo tema</a>
						</div>	
					</div>
				</div>	
				<div class="col-lg-8 col-md-10 col-sm-11 text-right colseguntam">
					<div class="row">		
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right colseguntam">	
							<?php if($_SESSION['cualareac']>0 && $resultado->num_rows>0){?>
								<a href="ordenar.php?qo=tm&to=<?php echo $rwac['titulo'];?>" class="btn botonbuscar btnseguntam btnmenospad">Ordenar temas</a>
							<?php } ?>							
							<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="selectortipo btnseguntam">
								<input class="selector selector2 btnseguntamtermbus btnmenospad" type="text" id="termino" name="termino" placeholder="Término a buscar"/>
								<input type="submit" id="enviar" name="enviar" value="Buscar" class="btn botonbuscar btnseguntambtnbus btnmenospad"/>
							</form>
							<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="selectortipo btnseguntam">
								<select class="form-control selector selector2 btnseguntam btnmenospad" id="id_areac" name="id_areac" onchange="this.form.submit()">		
									<option value=0>Todos</option>
									<?php while($rowac = $resultadoac->fetch_array(MYSQLI_ASSOC)) { ?>							
										<option value=<?php echo $rowac['id']; if($rowac['id']==$_SESSION['cualareac']) echo ' selected';?>><?php echo $rowac['titulo']; ?></option>
									<?php } ?>
								</select>
								<!-- <input type="submit" id="filtrar" name="filtrar" value="Filtrar" class="btn btn-info" /> -->					
							</form>
						</div>
					</div>
				</div>									
			</div>
		</div>
		<div class="container">
			<div class="contenedortabla">
				<div class="row table-responsive tablacentrada">
					<table class="table table-striped">
						<thead>
							<tr>
								<th><a href="administrartemas.php?orden=titulo">Título</a></th>
								<th><a href="administrartemas.php?orden=id_areac">Área</a></th>
								<th class="colstatus"><a href="administrartemas.php?orden=status">Status</a></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>						
						</thead>
						<tbody id="tfilas">
						<?php $numero_filas = $resultado->num_rows; if($numero_filas<=0){echo "<tr><td class='listadovacio'>El listado está vacío</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";}else{?>
							<script>var cborrar=[]; nfilaj=1;</script>									
							<?php  $nfila=1; while($row = $resultado->fetch_array(MYSQLI_ASSOC)) { ?>							
								<tr>								
									<td><?php echo $row['titulo']; ?></td>
									<td><?php
										$cuals=$row['id_areac'];
										$sqlac2 = "SELECT titulo FROM ovaareasc WHERE id = '$cuals'";
										$resultadoac2 = $mysqli->query($sqlac2);	
										$rowac2 = $resultadoac2->fetch_array(MYSQLI_ASSOC);
									echo $rowac2['titulo']; ?>
									</td>
									<td class="colstatus"><a href="cambiarstatustema.php?id=<?php echo $row['id']; ?>"><span data-toggle="tooltip" title="<?php if($row['status']==0){echo 'Tema inactivo';}else{echo 'Tema activo';}?>" class=<?php if($row['status']==0){echo '"glyphicon glyphicon-ban-circle"';}else{echo '"glyphicon glyphicon-ok-circle"';}?>></span></a></td>
									<td><a href="temaregistrado.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" title="Administrar subtemas del tema"><span class="glyphicon glyphicon-th-list"></span></a></td>
									<!--<td><a href="administrarimagenes.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" title="Administrar imágenes del tema"><span class="glyphicon glyphicon-picture"></span></a></td>-->							
									<td><a href="administrarenlaces.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" title="Administrar enlaces del tema"><span class="glyphicon glyphicon-link"></span></a></td>
									<td><a href="modificarayuda.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" title="Administrar ayuda del tema"><span class="glyphicon glyphicon-question-sign"></span></a></td>	
									<td><a href="modificarPDF.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" title="Administrar archivo PDF del tema"><span class="glyphicon glyphicon-file"></span></a></td>	
									<td><a href="administraractividades.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" title="Administrar actividades del tema"><span class="glyphicon glyphicon-tower"></span></a></td>
									<td><a href="administrarevaluaciones.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" title="Administrar evaluación del tema"><span class="glyphicon glyphicon-ok"></span></a></td>	
									<td><a href="tema.php?id=<?php echo $row['id']; ?>" target="_blank" data-toggle="tooltip" title="Ver tema"><span class="glyphicon glyphicon-eye-open"></span></a></td>	
									<td><a href="modificartema.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" title="Editar tema"><span class="glyphicon glyphicon-pencil"></span></a></td>
									<td><span data-toggle="tooltip" title="Eliminar tema"><a href="#" data-href="eliminartema.php?id=<?php echo $row['id']; ?>&orden=<?php echo $row['orden']; ?>&ac=<?php echo $row['id_areac']; ?>" data-toggle="modal" data-target="#confirm-delete"><span id="fila<?php echo $nfila; ?>" class="glyphicon glyphicon-trash"></span></a></span></td>
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
							<h4 class="modal-title" id="myModalLabel">Eliminar tema</h4>
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
						<p ALIGN="justify">Esta área se encarga de <b>Administración de temas</b>, el cual consiste en editar los contenidos del OVA.</p>

						      <p ALIGN="justify">Al darle clic en <b>Nuevo tema</b>, luego llenará el formulario correspondiente.</p>

						      <p ALIGN="justify">Pase el cursor por los iconos de edición de los temas registrados, luego éste le muestra el significado o su función. </p>
						      
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
				    document.getElementById("elmsj").innerHTML = "¿Desea eliminar el tema <strong>"+cborrar[res[1]]+"</strong>?";
				});		
			</script>	
			<!-- <script>
				$(document).ready(function(){
					$('[data-toggle="tooltip"]').tooltip();   
				});
			</script> -->
		</body>
	</html>																																																																							