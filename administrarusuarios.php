<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';	
	require 'funciones/funciones.php';		
	
	
	$orden="nombres";
	if(!empty($_GET))
	{
		$orden=$_GET['orden'];
		if(empty($orden)){
			$orden="nombres";
		}
	}
	$where = "";	
	if(!empty($_POST))
	{
		$valor = $_POST['termino'];
		if(!empty($valor)){
			$where = "AND ( nombres LIKE '%$valor%' || apellidos LIKE '%$valor%' || cedula LIKE '%$valor%' || nick LIKE '%$valor%' || email LIKE '%$valor%')";
		}
		$valortu = $_POST['id_tipo'];	
		if(!empty($valortu) || $valortu=='0'){
			$_SESSION['cualtu']=$valortu;			
		}
	}	
	if($_SESSION["tipo_usuario"]==2){
		$_SESSION['cualtu']=3;
	}
	$cualtu2=$_SESSION['cualtu'];
	if(strlen(trim($cualtu2)) > 0 && $cualtu2!='0'){
		$where2 = "WHERE id_tipo = '$cualtu2'";
	}
	else{
		$where2 = "WHERE id_tipo LIKE '%'";
	}
	$idusuario=$_SESSION['id_usuario'];
	$sql = "SELECT nick FROM ovausuarios WHERE id='$idusuario'";
	$resultado = $mysqli->query($sql);
	$rownu=$resultado->fetch_array(MYSQLI_ASSOC);
	$sql = "SELECT * FROM ovausuarios $where2 $where ORDER BY $orden ASC";
	$resultado = $mysqli->query($sql);
	$wheretu = "";
	$sqltu = "SELECT * FROM ovatipousuario $wheretu";
	$resultadotu = $mysqli->query($sqltu);	
	$_SESSION['cualareac']="";	
?>
<html lang="es">
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Administración de <?php if($_SESSION["tipo_usuario"]==1){?>Usuarios<?php }else{?>Estudiantes<?php } ?></title>
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
			<?php echo MenuPrincipal("usuarios"); ?>	
			<div class="row">
				<div class="imgslidertmcn">					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 secciontitulos secciontitulosadmin">
						<div class="container tituloadmin">Administración de <?php if($_SESSION["tipo_usuario"]==1){?>Usuarios<?php }else{?>Estudiantes<?php } ?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row areasuperioradmin">
				<div class="col-lg-4 col-md-4 col-sm-2 col-xs-12 text-left colseguntam">
					<div class="row">
						<div class="col-lg-12 filaovf">
							<?php if($_SESSION["tipo_usuario"]==1){?><a href="registrarusuario.php" class="btn botonnuevo btnseguntam">Nuevo usuario</a><?php } ?>
							<?php if($_SESSION["tipo_usuario"]==2){?><a href="registrarusuario.php" class="btn botonnuevo btnseguntam">Nuevo estudiante</a><?php } ?>
						</div>	
					</div>
				</div>	
				<div class="col-lg-8 col-md-8 col-sm-10 text-right colseguntam">
					<div class="row">		
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right colseguntam">
							<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="selectortipo btnseguntam">
								<input class="selector btnseguntamtermbus" type="text" id="termino" name="termino" placeholder="Término de búsqueda"/>
								<input type="submit" id="enviar" name="enviar" value="Buscar" class="btn botonbuscar btnseguntambtnbus"/>
							</form>	
							<?php if($_SESSION["tipo_usuario"]==1){?>		
							<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="selectortipo btnseguntam">
								<select class="form-control selector btnseguntam" id="id_tipo" name="id_tipo" onchange="this.form.submit()">		
									<option value=0>Todos</option>
									<?php while($rowtu = $resultadotu->fetch_array(MYSQLI_ASSOC)) { ?>							
										<option value=<?php echo $rowtu['id']; if($rowtu['id']==$_SESSION['cualtu']) echo ' selected';?>><?php echo $rowtu['tipo']; ?></option>
									<?php } ?>
								</select>
							</form>	
							<?php } ?>							
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
								<th><a href="administrarusuarios.php?orden=nombres">Nombres</a></th>
								<th><a href="administrarusuarios.php?orden=apellidos">Apellidos</a></th>
								<th><a href="administrarusuarios.php?orden=cedula">Cédula</a></th>
								<th><a href="administrarusuarios.php?orden=nick">Nick</a></th>
								<th><a href="administrarusuarios.php?orden=email">Email</a></th>
								<?php if($_SESSION["tipo_usuario"]!=3){?>	
								<?php if($_SESSION["tipo_usuario"]==1){?><th><a href="administrarusuarios.php?orden=id_tipo">Tipo</a></th><?php } ?>
								<th class="colstatus"><a href="administrarusuarios.php?orden=status">Status</a></th>
								<th></th>
								<th></th>
								<?php } ?>
							</tr>						
						</thead>
						<tbody id="tfilas">		
						<?php $numero_filas = $resultado->num_rows; if($numero_filas<=0){echo "<tr><td class='listadovacio'>El listado está vacío</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";}else{?>	
							<script>var cborrar=[]; nfilaj=1;</script>				
							<?php $nfila=1; while($row = $resultado->fetch_array(MYSQLI_ASSOC)) { if($row['nick']!='admin' || $rownu['nick']=='admin'){ ?>				
								<tr>								
									<td><strong><a href="areadeusuario.php?idu=<?php echo $row['id']; ?>"><?php echo $row['nombres']; ?></a></strong></td>
									<td><strong><a href="areadeusuario.php?idu=<?php echo $row['id']; ?>"><?php echo $row['apellidos']; ?></a></strong></td>
									<td><?php echo $row['cedula']; ?></td>
									<td><?php echo $row['nick']; ?></td>
									<td><?php echo $row['email']; ?></td>	
									<?php if($_SESSION["tipo_usuario"]!=3){?>								
									<?php if($_SESSION["tipo_usuario"]==1){?>	
									<td><?php
										$cuals=$row['id_tipo'];
										$sqltu2 = "SELECT tipo FROM ovatipousuario WHERE id = '$cuals'";
										$resultadotu2 = $mysqli->query($sqltu2);	
										$rowtu2 = $resultadotu2->fetch_array(MYSQLI_ASSOC);
									echo $rowtu2['tipo']; ?>
									</td>	
									<?php } ?>
									<!--<td><span class=<?php switch($row['id_tipo']){case 1:echo '"glyphicon glyphicon-cog"';break; case 2:echo '"glyphicon glyphicon-book"';break; case 3:echo '"glyphicon glyphicon-education"';break;}?>></span></td>-->
									<td class="colstatus"><?php if($row['nick']!='admin' && $row['id']!=$idusuario){ ?><a href="cambiarstatususuario.php?id=<?php echo $row['id']; ?>"><span data-toggle="tooltip" title="<?php if($row['status']==0){echo 'Usuario inactivo';}else{echo 'Usuario activo';}?>" class=<?php if($row['status']==0){echo '"glyphicon glyphicon-ban-circle"';}else{echo '"glyphicon glyphicon-ok-circle"';}?>></span></a><?php }else{echo '<span class="glyphicon glyphicon-ok-circle deshabilitado"></span>';} ?></td>
									<td><a href="modificarusuario.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" title="Editar usuario"><span class="glyphicon glyphicon-pencil"></span></a></td>
									<td><?php if($row['nick']!='admin' && $row['id']!=$idusuario){ ?><span data-toggle="tooltip" title="Eliminar <?php if($_SESSION['tipo_usuario']==1){?>usuario<?php }else{?>estudiante<?php } ?>"><a href="#" data-href="eliminarusuario.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete"><span id="fila<?php echo $nfila; ?>" class="glyphicon glyphicon-trash"></span></a></span><?php }else{echo '<span id="fila'.$nfila.'" class="glyphicon glyphicon-trash deshabilitado"></span>';} $nfila=$nfila+1; ?><script>cborrar[nfilaj]="<?php echo $row['nombres'].' '.$row['apellidos'];?>"; nfilaj=nfilaj+1;</script></td>
									<?php } } ?>
								</tr>
							<?php } } ?>
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
							<h4 class="modal-title" id="myModalLabel">Eliminar <?php if($_SESSION["tipo_usuario"]==1){?>usuario<?php }else{?>estudiante<?php } ?></h4>
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
						      <p ALIGN="justify">Esta área de encarga de <b>Administrar usuarios</b>, el cual consiste en agregar, modificar, buscar y eliminar usuarios.</p>

						      <p ALIGN="justify">Al darle clic en el nombre del usuario, este le muestra la información acerca de las evaluaciones realizadas en el OVA. </p><br/>
							
							  <p ALIGN="justify">Para el llenado de los datos del usuario, debe darle clic en <b>Nuevo usuario</b>, luego llenará el formulario correspondiente.</p>

							  <p ALIGN="justify">El área central de la página le muestra la cantidad de usuarios registrado, además le permite modificar, eliminar o buscar.</p><br/>
							
							  <p ALIGN="justify">También se encuentra en la parte superior derecha el botón de <b> Cerrar Sesión </b> para salir de la sesión.</p><br/>

							  
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
				    document.getElementById("elmsj").innerHTML = "¿Desea eliminar al <?php if($_SESSION['tipo_usuario']==1){?>usuario<?php }else{?>estudiante<?php } ?> <strong>"+cborrar[res[1]]+"</strong>?";
				});				
			</script>				
		</body>
	</html>																																													