<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$errores = array();
	if(!empty($_POST))
	{
		$nombres = $mysqli->real_escape_string($_POST['nombres']);
		$apellidos = $mysqli->real_escape_string($_POST['apellidos']);
		$cedula = $mysqli->real_escape_string($_POST['cedula']);
		$nick = $mysqli->real_escape_string($_POST['nick']);
		$password = $mysqli->real_escape_string($_POST['password']);
		$email = $mysqli->real_escape_string($_POST['email']);
		$tipo_usuario = $mysqli->real_escape_string($_POST['id_tipo']);
		
		if($tipo_usuario==1 || $tipo_usuario==2){
			$profesion = $mysqli->real_escape_string($_POST['profesion']);
			$carrera = "";
			$semestre = "";
		}
		if($tipo_usuario==3){
			$profesion = "";
			$carrera = $mysqli->real_escape_string($_POST['carrera']);
			$semestre = $mysqli->real_escape_string($_POST['semestre']);
		}		
		
		$status = 0;
		if(isNull($nombres, $apellidos, $cedula, $nick, $password, $email))
		{
			$errores[] = "Debe llenar todos los campos";
		}
		if(!isEmail($email))
		{
			$errores[] = "Dirección de correo inválida";
		}	
		if(cedulaExiste($cedula))
		{
			$errores[] = "El número de cédula $cedula ya existe";
		}
		if(nickExiste($nick))
		{
			$errores[] = "El nombre de usuario $nick ya existe";
		}
		if(emailExiste($email))
		{
			$errores[] = "El correo electrónico $email ya existe";
		}
		if($tipo_usuario==0)
		{
			$errores[] = "Debe elegir un tipo de usuario";
		}
		if(count($errores) == 0)
		{
			$pass_hash = hashPassword($password);
			$token = generateToken();
			$registro = registraUsuario($nombres, $apellidos, $cedula, $nick, $pass_hash, $email, $profesion, $carrera, $semestre, $status, $token, $tipo_usuario);			
			if($registro > 0) { 
				$_SESSION['cualtu']=$tipo_usuario;
				$_SESSION['tipomensajedevuelto']='exito';
				$_SESSION['mensajedevuelto']='Usuario registrado exitosamente';
				}else{
				$_SESSION['tipomensajedevuelto']='error';
				$_SESSION['mensajedevuelto']='Error al registrar el usuario';
				$errores[] = "Error al registrar el usuario";
			}	
			header("Location: administrarusuarios.php");
		}
	}
	
	$wheretu = "";
	$sqltu = "SELECT * FROM ovatipousuario $wheretu";
	$resultadotu = $mysqli->query($sqltu);	
	
	$resultadotu2 = $mysqli->query($sqltu);	 
?>
<html>
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Registro de <?php if($_SESSION["tipo_usuario"]==1){echo "Usuario";}else{echo "Estudiante";}?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="static/css/bootstrap.min.css" >
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
		<!-- <script language="javascript">
			$(document).ready(function(){
			$("#btn-signup").click(function () {
			alert();
			switch($("#id_tipo").val()) {
			case '1':
			$("#profesion").val('No aplica');
			$("#carrera").val('No aplica');
			$("#semestre").val('No aplica');						
			break;
			case '2':
			$("#profesion").val('No aplica');
			break;
			case '3':
			$("#carrera").val('No aplica');
			$("#semestre").val('No aplica');						
			break;
			}
			
			});
			});
		</script>	 -->
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
						<div class="container tituloadmin">Administración de <?php if($_SESSION["tipo_usuario"]==1){echo "Usuarios";}else{echo "Estudiantes";}?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row areasuperioradmin">
				<div id="signupbox" class="col-lg-12">
					<div class="formulario">
						<div id="cabeceraformulario" class="">
							<div class="">Registro de <?php if($_SESSION["tipo_usuario"]==1){echo "usuario";}else{echo "estudiante";}?></div>
						</div>  
						<div class="panel-body" >
							<form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
								<div id="signupalert" style="display:none" class="alert alert-danger">
									<p>Error:</p>
									<span></span>
								</div>
								<div class="form-group">
									<label for="nombres" class="col-md-3 control-label">Nombres</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="nombres" placeholder="Nombres" value="<?php if(isset($nombres)) echo $nombres; ?>" required >
									</div>
								</div>
								<div class="form-group">
									<label for="apellidos" class="col-md-3 control-label">Apellidos</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="apellidos" placeholder="Apellidos" value="<?php if(isset($apellidos)) echo $apellidos; ?>" required >
									</div>
								</div>
								<div class="form-group">
									<label for="cedula" class="col-md-3 control-label">Cédula</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="cedula" placeholder="Cédula" value="<?php if(isset($cedula)) echo $cedula; ?>" required >
									</div>
								</div>
								<div class="form-group">
									<label for="nick" class="col-md-3 control-label">Nick</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="nick" placeholder="Nick" value="<?php if(isset($nick)) echo $nick; ?>" required>
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-md-3 control-label">Password</label>
									<div class="col-md-9">
										<input type="password" class="form-control" name="password" placeholder="Password" required>
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="col-md-3 control-label">Email</label>
									<div class="col-md-9">
										<input type="email" class="form-control" name="email" placeholder="Email" value="<?php if(isset($email)) echo $email; ?>" required>
									</div>
								</div>
								<div class="form-group" <?php if($_SESSION["tipo_usuario"]!=1){echo 'style="display:none;"';}?>>
									<label for="tipo_usuario" class="col-md-3 control-label">Tipo de usuario</label>
									<div class="col-md-9">										
										<select class="form-control" id="id_tipo" name="id_tipo">		
											<option value=0>Seleccione un tipo</option>
											<?php while($rowtu = $resultadotu->fetch_array(MYSQLI_ASSOC)) { ?>							
												<option value=<?php echo $rowtu['id']; if($rowtu['id']==$_SESSION['cualtu']) echo ' selected';?>><?php echo $rowtu['tipo']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group" id="divprofesion" style="display:none;">
									<label for="profesion" class="col-md-3 control-label">Profesión</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="profesion" id="profesion" placeholder="Profesión" value="<?php if(isset($profesion)) echo $profesion; ?>">
									</div>
								</div>
								<div class="form-group" id="divcarrera" style="display:none;">
									<label for="carrera" class="col-md-3 control-label">Carrera</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="carrera" id="carrera" placeholder="Carrera" value="<?php if(isset($carrera)) echo $carrera; ?>">
									</div>
								</div>
								<div class="form-group" id="divsemestre" style="display:none;">
									<label for="semestre" class="col-md-3 control-label">Semestre</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="semestre" id="semestre" placeholder="Semestre" value="<?php if(isset($semestre)) echo $semestre; ?>">
									</div>
								</div>
								<div class="form-group">                             
									<div class="col-md-offset-3 col-md-9">										
										<button id="btn-signup" type="submit" class="btn"><i class="icon-hand-right"></i>Registrar</button>
										<a href="administrarusuarios.php" class="btn">Cancelar</a> 
									</div>
								</div>
							</form>
							<?php echo mostrarErrores($errores); ?>
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
						
						 <p ALIGN="justify">Esta área se encarga de <b>Registro de  <?php if($_SESSION["tipo_usuario"]==1){echo "usuarios";}else{echo "estudiantes";}?></b>, el cual consiste en llenar los datos del nuevo usuario.</p>


							  <p ALIGN="justify">El área central de la página le muestra el formulario con los ítems necesarios para el registro, los cuales son:</p><br/>
							  <p ALIGN="justify"><b>Nombre y apellido:</b> el nombre completo del nuevo usuario que se va a registrar.</p>
							  <p ALIGN="justify"><b>Cedula:</b> el número de identificación del nuevo usuario.</p>
							  <p ALIGN="justify"><b>Nick:</b> el apodo o alias.</p>
							  <p ALIGN="justify"><b>Email:</b> el correo electrónico.</p>
							  <p <?php if($_SESSION["tipo_usuario"]!=1){echo 'style="display:none;"';}?> ALIGN="justify"><b>Tipo de usuario:</b> indicar si es estudiante, administrador o profesor.</p><br/>

						      <p ALIGN="justify">El botón <b>Ordenar actividades</b>, permite organizar las actividades por un orden determinado. </p><br/>
						      <p ALIGN="justify">En caso de no realizar ningún registro, se puede regresar al contenido y salir del área. </p>
						      <p ALIGN="justify">Dándole clic en "<b><FONT SIZE=5> < </font></b>" al lado de la palabra <b>Tema</b>, del lado izquierdo del área central. </p><br/>
							  <p ALIGN="justify">También se encuentra en la parte superior derecha el botón de <b> Cerrar Sesión </b> para salir de la sessión.</p>
					</div>
				</div>
			</div>
		</div>	
	</body>
</html>																																																																																															