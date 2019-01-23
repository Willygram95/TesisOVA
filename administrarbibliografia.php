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
	$sql = "SELECT * FROM ovabibliografia $where ORDER BY $orden ASC";
	$resultado = $mysqli->query($sql);
	$_SESSION['cualtu']="";
	$_SESSION['cualareac']="";	
?>
<html lang="es">
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Administración de Bibliografía</title>
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
						<div class="container tituloadmin">Administración de Bibliografía</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row areasuperioradmin">
				<div class="col-lg-4 col-md-4 col-sm-2 text-left">
					<div class="row">
						<div class="col-lg-4">
							<a href="registrarbibliografia.php" class="btn botonnuevo btnseguntam">Nueva referencia</a>
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
								<th><a href="administrarbibliografia.php?orden=titulo">Título</a></th>
								<th><a href="administrarbibliografia.php?orden=autor">Autor(es)</a></th>							
								<th>Más información</th>
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
									<td><?php echo $row['autor']; ?></td>
									<td><?php echo $row['info']; ?></td>
									<td><a href="modificarbibliografia.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" title="Editar libro"><span class="glyphicon glyphicon-pencil"></span></a></td>
									<td><span data-toggle="tooltip" title="Eliminar libro"><a href="#" data-href="eliminarbibliografia.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete"><span id="fila<?php echo $nfila; ?>" class="glyphicon glyphicon-trash"></span></a></span></td>
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
							<h4 class="modal-title" id="myModalLabel">Eliminar libro</h4>
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
						<p ALIGN="justify">Esta área se encarga de <b>Administración de bibliografías</b>, el cual consiste en editar las referencias del OVA.</p>
						<p ALIGN="justify">Al darle clic en <b>Nueva referencia</b>, luego llenará el formulario correspondiente.</p>
                        <p ALIGN="justify">Pase el cursor por los iconos de edición de las referencias registradas, luego éste le muestra el significado o su función. </p>
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
				    document.getElementById("elmsj").innerHTML = "¿Desea eliminar el libro/referencia <strong>"+cborrar[res[1]]+"</strong>?";
				});	
			</script>	
			
			<!-- <script>
				$(document).ready(function(){
					$('[data-toggle="tooltip"]').tooltip();   
				});
			</script> -->
		</body>
	</html>																																											