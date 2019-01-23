<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';	
	require 'funciones/funciones.php';	
	$id = $_GET['id'];
	$sql = "SELECT * FROM ovausuarios WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
	
	$wheretu = "";
	$sqltu = "SELECT * FROM ovatipousuario $wheretu";
	$resultadotu = $mysqli->query($sqltu);	
	
	$resultadotu2 = $mysqli->query($sqltu);	 
?>
<html lang="es">
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Modificación de <?php if($_SESSION["tipo_usuario"]==1){?>Usuarios<?php }else{?>Estudiantes<?php } ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="static/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="css/ovamiestilo.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/colores.php">
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js"></script>	
		
		<?php 			
			while($rowtu2 = $resultadotu2->fetch_array(MYSQLI_ASSOC)) { 							
				$tipou[]= $rowtu2['id'];
			} 	
		echo "<script language='javascript'>"; ?>
		$(document).ready(function(){
		$("#id_tipo").change(function () {
		seleccion = $(this).val();
		switch(seleccion) {
		case '0':
		var diveste = document.getElementById("divprofesion");
		diveste.style.display = "none";
		var diveste = document.getElementById("divcarrera");
		diveste.style.display = "none";
		var diveste = document.getElementById("divsemestre");
		diveste.style.display = "none";  						
		break;
		case '<?php echo $tipou[0]; ?>':
		var diveste = document.getElementById("divprofesion");
		diveste.style.display = "inherit";
		var diveste = document.getElementById("divcarrera");
		diveste.style.display = "none";
		var diveste = document.getElementById("divsemestre");
		diveste.style.display = "none";  						
		break;
		case '<?php echo $tipou[1]; ?>':						
		var diveste = document.getElementById("divprofesion");
		diveste.style.display = "inherit";
		var diveste = document.getElementById("divcarrera");
		diveste.style.display = "none";
		var diveste = document.getElementById("divsemestre");
		diveste.style.display = "none";
		break;
		case '<?php echo $tipou[2]; ?>':
		var diveste = document.getElementById("divprofesion");
		diveste.style.display = "none";
		var diveste = document.getElementById("divcarrera");
		diveste.style.display = "inherit";
		var diveste = document.getElementById("divsemestre");
		diveste.style.display = "inherit";
		break;
		}
		
		});
		});
		<?php echo "</script>"; ?>	
		
		<script language="javascript">
			function lanzadera(){
				seleccion = $("#id_tipo").val();
				switch(seleccion) {
					case '0':
					var diveste = document.getElementById("divprofesion");
					diveste.style.display = "none";
					var diveste = document.getElementById("divcarrera");
					diveste.style.display = "none";
					var diveste = document.getElementById("divsemestre");
					diveste.style.display = "none";  						
					break;
					case '<?php echo $tipou[0]; ?>':
					var diveste = document.getElementById("divprofesion");
					diveste.style.display = "inherit";
					var diveste = document.getElementById("divcarrera");
					diveste.style.display = "none";
					var diveste = document.getElementById("divsemestre");
					diveste.style.display = "none";  						
					break;
					case '<?php echo $tipou[1]; ?>':						
					var diveste = document.getElementById("divprofesion");
					diveste.style.display = "inherit";
					var diveste = document.getElementById("divcarrera");
					diveste.style.display = "none";
					var diveste = document.getElementById("divsemestre");
					diveste.style.display = "none";
					break;
					case '<?php echo $tipou[2]; ?>':
					var diveste = document.getElementById("divprofesion");
					diveste.style.display = "none";
					var diveste = document.getElementById("divcarrera");
					diveste.style.display = "inherit";
					var diveste = document.getElementById("divsemestre");
					diveste.style.display = "inherit";
					break;
				}
			}
			
			window.onload = lanzadera;
		</script>
	</head>
	
	<body class="bodyadmin">
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
				<div id="signupbox" class="col-lg-12">
					<div class="formulario">
						<div id="cabeceraformulario" class="modificacion">
							<div class="">Modificación de <?php if($_SESSION["tipo_usuario"]==1){?>usuario<?php }else{?>estudiante<?php } ?></div>
						</div> 
					<div class="panel-body" >	
						<form class="form-horizontal" method="POST" action="actualizarusuario.php" autocomplete="off">
							<div class="form-group">
								<label for="nombres" class="col-md-3 control-label">Nombres</label>
								<div class="col-md-9">
									<input <?php if($row['nick']=='admin'){ echo "readonly"; } ?> type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" value="<?php echo $row['nombres']; ?>" required>
								</div>
							</div>
							<div class="form-group">
								<label for="apellidos" class="col-md-3 control-label">Apellidos</label>
								<div class="col-md-9">
									<input <?php if($row['nick']=='admin'){ echo "readonly"; } ?> type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" value="<?php echo $row['apellidos']; ?>" required>
								</div>
							</div>
							<div class="form-group">
								<label for="cedula" class="col-md-3 control-label">Cédula</label>
								<div class="col-md-9">
									<input <?php if($row['nick']=='admin'){ echo "readonly"; } ?> type="text" class="form-control" id="cedula" name="cedula" placeholder="Cédula" value="<?php echo $row['cedula']; ?>" required>
								</div>
							</div>
							<div class="form-group">
								<label for="nick" class="col-md-3 control-label">Nick</label>
								<div class="col-md-9">
									<input <?php if($row['nick']=='admin' || $row['id']==$_SESSION["id_usuario"]){ echo "readonly"; } ?> type="text" class="form-control" id="nick" name="nick" placeholder="Nick" value="<?php echo $row['nick']; ?>" required>
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-md-3 control-label">Password</label>
								<div class="col-md-9">
									<input type="password" class="form-control" id="password" name="password" placeholder="Password" value="Sin cambios" required>
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-md-3 control-label">Email</label>
								<div class="col-md-9">
									<input <?php if($row['nick']=='admin'){ echo "readonly"; } ?> type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $row['email']; ?>" required>
								</div>
							</div>
							<div class="form-group" <?php if($_SESSION["tipo_usuario"]!=1){echo 'style="display:none;"';}?>>
								<label for="id_tipo" class="col-md-3 control-label">Tipo de usuario</label>
								<div class="col-md-9">
									<?php if($row['nick']!='admin' && $row['id']!=$_SESSION["id_usuario"]){ ?>
									<select class="form-control" id="id_tipo" name="id_tipo">		
										<?php while($rowtu = $resultadotu->fetch_array(MYSQLI_ASSOC)) { ?>							
											<option value=<?php echo $rowtu['id']; if($rowtu['id']==$row['id_tipo']) echo ' selected';?>><?php echo $rowtu['tipo']; ?></option>
										<?php } ?>
									</select>
									<?php }else{ ?>
										<input type="hidden" id="id_tipo" name="id_tipo" value="1" />
										<input readonly type="text" class="form-control" value="Administrador" placeholder="Administrador" />
									<?php } ?>	
								</div>
							</div>	
							<div class="form-group" id="divprofesion" style="display:none;">
								<label for="profesion" class="col-md-3 control-label">Profesión</label>
								<div class="col-md-9">
									<input <?php if($row['nick']=='admin'){ echo "readonly"; } ?> type="text" class="form-control" id="profesion" name="profesion" placeholder="Profesión" value="<?php echo $row['profesion']; ?>">
								</div>
							</div>
							<div class="form-group" id="divcarrera" style="display:none;">
								<label for="carrera" class="col-md-3 control-label">Carrera</label>
								<div class="col-md-9">
									<input <?php if($row['nick']=='admin'){ echo "readonly"; } ?> type="text" class="form-control" id="carrera" name="carrera" placeholder="Carrera" value="<?php echo $row['carrera']; ?>">
								</div>
							</div>
							<div class="form-group" id="divsemestre" style="display:none;">
								<label for="semestre" class="col-md-3 control-label">Semestre</label>
								<div class="col-md-9">
									<input <?php if($row['nick']=='admin'){ echo "readonly"; } ?> type="text" class="form-control" id="semestre" name="semestre" placeholder="Semestre" value="<?php echo $row['semestre']; ?>">
								</div>
							</div>
							<input type="hidden" id="id" name="id" value="<?php echo $row['id']; ?>" />
							<?php if($row['nick']!='admin' && $row['id']!=$_SESSION["id_usuario"]){ ?>
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
							<?php }else{ ?>
									<input type="hidden" id="status" name="status" value="1" />
							<?php } ?>
							<div class="form-group">
								<div class="col-md-offset-3 col-md-9">									
									<button type="submit" class="btn">Guardar</button>
									<a href="administrarusuarios.php" class="btn">Cancelar</a>
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
						<p ALIGN="justify">Esta área se encarga de <b>Modificar de subtemas</b>, el cual consiste en editar las actividades del OVA.</p>

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
	</body>
</html>														