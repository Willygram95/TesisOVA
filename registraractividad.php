<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	
	$id_tema = $_GET['id'];
	
	$errores = array();
	if(!empty($_POST))
	{
		$tipo = $mysqli->real_escape_string($_POST['tipo']);		
		$enunciado = $_POST['enunciado'];
		$id_tema = $mysqli->real_escape_string($_POST['id']);				
		
		switch($tipo){
			case 1:
			$numopciones = $mysqli->real_escape_string($_POST['numopciones']);
			$opcion1 = $mysqli->real_escape_string($_POST['opcion1']);
			$opcion2 = $mysqli->real_escape_string($_POST['opcion2']);
			$opcion3 = $mysqli->real_escape_string($_POST['opcion3']);
			
			if($numopciones==3){
				$opcioncorrecta = $mysqli->real_escape_string($_POST['opcioncorrecta3o']);
				$opcion4 = "";
			}
			
			if($numopciones==4){
				$opcioncorrecta = $mysqli->real_escape_string($_POST['opcioncorrecta4o']);
				$opcion4 = $mysqli->real_escape_string($_POST['opcion4']);
			}
			
			break;
			case 2:
			$numopciones=2;
			$opcion1 = "Verdadero";
			$opcion2 = "Falso";	
			$opcion3 = "";
			$opcion4 = "";	
			$opcioncorrecta = $mysqli->real_escape_string($_POST['opcioncorrectavof']);
			
			break;
			
		}
		
		$numerogrupo = 1;
		if(isNullactividad($tipo,$enunciado,$numopciones,$opcion1,$opcion2,$opcion3,$opcion4))
		{
			$errores[] = "Debe ingresar toda la información solicitada";
		}
		if(count($errores) == 0)
		{
			$registro = registraActividad($tipo,$enunciado,$numopciones,$opcion1,$opcion2,$opcion3,$opcion4,$opcioncorrecta,$id_tema,$numerogrupo);			
			if($registro > 0) { 
				$_SESSION['tipomensajedevuelto']='exito';
				$_SESSION['mensajedevuelto']='Actividad registrada exitosamente';
				$vloc="Location: administraractividades.php?id=".$id_tema;
				header($vloc);
				}else{
				$_SESSION['tipomensajedevuelto']='error';
				$_SESSION['mensajedevuelto']='Error al registrar la actividad';
				$errores[] = "Error al registrar la actividad";
				$vloc="Location: administraractividades.php?id=".$id_tema;
				header($vloc);
			}	
		}
	}
	$sqlte = "SELECT * FROM ovatiposactividades";
	$resultadote = $mysqli->query($sqlte);
	$resultadote2 = $mysqli->query($sqlte);
	
	$sqltm = "SELECT titulo FROM ovatemas WHERE id = '$id_tema'";
	$resultadotm = $mysqli->query($sqltm);
	$rowtm = $resultadotm->fetch_array(MYSQLI_ASSOC);	
?>
<html>
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Registro de Actividad</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="static/css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/ovamiestilo.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/colores.php">
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js" ></script>
		<?php 
			insertareditor("enunciado");
		?>			
		
		<?php 			
			while($rowte2 = $resultadote2->fetch_array(MYSQLI_ASSOC)) { 							
				$tipoej[]= $rowte2['id'];
			} 	
		echo "<script language='javascript'>"; ?>
		$(document).ready(function(){
		$("#tipo").change(function () {
		seleccion = $(this).val();
		switch(seleccion) {
		case '0':
		var diveste = document.getElementById("tiposeleccion");
		diveste.style.display = "none";
		var diveste = document.getElementById("tipovof");
		diveste.style.display = "none";				
		break;
		case '<?php echo $tipoej[0]; ?>':
		var diveste = document.getElementById("tiposeleccion");
		diveste.style.display = "inherit";
		var diveste = document.getElementById("tipovof");
		diveste.style.display = "none";  						
		break;
		case '<?php echo $tipoej[1]; ?>':						
		var diveste = document.getElementById("tiposeleccion");
		diveste.style.display = "none";
		var diveste = document.getElementById("tipovof");
		diveste.style.display = "inherit";
		break;
		}		
		});
		});
		<?php echo "</script>"; ?>	
		
		<script language='javascript'>
			$(document).ready(function(){
				$("#numopciones").change(function () {
					seleccion = $(this).val();
					switch(seleccion) {
						case '3':
						var diveste = document.getElementById("cuartaopcion");
						diveste.style.display = "none";
						var diveste = document.getElementById("3opciones");
						diveste.style.display = "inherit";		
						var diveste = document.getElementById("4opciones");
						diveste.style.display = "none";				
						break;
						case '4':
						var diveste = document.getElementById("cuartaopcion");
						diveste.style.display = "inherit";
						var diveste = document.getElementById("3opciones");
						diveste.style.display = "none";	
						var diveste = document.getElementById("4opciones");
						diveste.style.display = "inherit";				
						break;
					}		
				});
			});
		</script>	
	</head>
	
	<body class="bodyadmin">

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
				<div class="container infotemaaux">
					<div class="row titulodetemaadmin">
						<a href="administraractividades.php?id=<?php echo $id_tema; ?>" data-toggle="tooltip" title="Regresar"><span class="glyphicon glyphicon-chevron-left"></span></a>
						Tema: <span><?php echo $rowtm['titulo']; ?></span>
					</div>
				</div>
				<div id="signupbox" class="col-lg-12">
					<div class="formulario">
						<div id="cabeceraformulario">
							<div>Registro de actividad</div>
						</div>  
					<div class="panel-body" >
						<form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
							<div id="signupalert" style="display:none" class="alert alert-danger">
								<p>Error:</p>
								<span></span>
							</div>
							<div class="form-group">
								<label for="tipo" class="col-md-3 control-label">Tipo de actividad</label>
								<div class="col-md-9">
									<select class="form-control" id="tipo" name="tipo">		
										<option value=0>Seleccione un tipo de actividad...</option>
										<?php while($rowte = $resultadote->fetch_array(MYSQLI_ASSOC)) { ?>							
											<option value=<?php echo $rowte['id'];?>><?php echo $rowte['tipo']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="enunciado" class="col-md-3 control-label">Enunciado</label>
								<div class="col-md-9">
									<textarea rows="20" class="form-control enunciadocorto" id="enunciado" name="enunciado" placeholder="Enunciado"><?php if(isset($enunciado)) echo $enunciado; ?></textarea>
								</div>
							</div>
							<div id="tiposeleccion" style="display:none;">
								<div class="form-group">
									<label for="numopciones" class="col-md-3 control-label">Número de opciones</label>
									<div class="col-md-9">
										<select class="form-control" id="numopciones" name="numopciones">
											<option value=3>3</option>
											<option value=4>4</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="opcion1" class="col-md-3 control-label">Opción 1</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="opcion1" placeholder="Opción 1" value="<?php if(isset($opcion1)) echo $opcion1; ?>" >
									</div>
								</div>	
								<div class="form-group">
									<label for="opcion2" class="col-md-3 control-label">Opción 2</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="opcion2" placeholder="Opción 2" value="<?php if(isset($opcion2)) echo $opcion2; ?>" >
									</div>
								</div>	
								<div class="form-group">
									<label for="opcion3" class="col-md-3 control-label">Opción 3</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="opcion3" placeholder="Opción 3" value="<?php if(isset($opcion3)) echo $opcion3; ?>" >
									</div>
								</div>	
								<div id="cuartaopcion" class="form-group" style="display:none;">
									<label for="opcion4" class="col-md-3 control-label">Opción 4</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="opcion4" placeholder="Opción 4" value="<?php if(isset($opcion4)) echo $opcion4; ?>" >
									</div>
								</div>	
								<div id ="3opciones" class="form-group">
									<label for="opcioncorrecta3o" class="col-md-3 control-label">Opción correcta</label>
									<div class="col-md-9">
										<select class="form-control" id="opcioncorrecta3o" name="opcioncorrecta3o">										
											<?php for($i=1;$i<=3;$i++) { ?>							
												<option value=<?php echo $i;?>><?php echo $i; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div id ="4opciones" class="form-group"  style="display:none;">
									<label for="opcioncorrecta4o" class="col-md-3 control-label">Opción correcta</label>
									<div class="col-md-9">
										<select class="form-control" id="opcioncorrecta4o" name="opcioncorrecta4o">										
											<?php for($i=1;$i<=4;$i++) { ?>							
												<option value=<?php echo $i;?>><?php echo $i; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div id ="tipovof" class="form-group" style="display:none;">
								<label for="opcioncorrectavof" class="col-md-3 control-label">Opción correcta</label>
								<div class="col-md-9">
									<select class="form-control" id="opcioncorrectavof" name="opcioncorrectavof">	
										<option value=1>Verdadero</option>
										<option value=2>Falso</option>
									</select>
								</div>
							</div>
							<input type="hidden" id="id" name="id" value="<?php echo $id_tema; ?>" />
							
							<div class="form-group">                             
								<div class="col-md-offset-3 col-md-9">
									
									<button id="btn-signup" type="submit" class="btn"><i class="icon-hand-right"></i>Registrar</button>
									<a href="administraractividades.php?id=<?php echo $id_tema; ?>" class="btn">Cancelar</a> 
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
						<p ALIGN="justify">Esta área se encarga de <b>Registro de actividades</b>, el cual consiste en llenar los datos de la actividad.</p>
						<p ALIGN="justify">El área central de la página le muestra el formulario con los item necesario para el registro, los cuales son:</p><br/>
							  
							  <p ALIGN="justify"><b>Tipo de actividad:</b> indicar si es simple o de selección (verdadero y falso).</p>
							  <p ALIGN="justify"><b>Enunciado:</b> colocar el texto, formular la pregunta.</p><br/>

							  <p ALIGN="justify">Si el tipo de actividad es <b>Simple</b>, entonces se activan los siguientes campos:</p>
                               <p ALIGN="justify"><b>Número de opciones:</b> que cantidad de opciones requiere.</p>
							  <p ALIGN="justify"><b>Opción 1, 2,3:</b> se colocan las posibles respuestas entre la correcta y las falsas.</p>
							  <p ALIGN="justify"><b>Opción correcta: cual de las opciones escrita en los campos anteriores es la correcta</b> .</p><br/>

							  <p ALIGN="justify">Si el tipo de actividad es <b>Verdadero y falso</b>, entonces se activa el siguiente campo:</p>
							  <p ALIGN="justify"><b>Opción correcta: indicar si el enunciado es verdadero o falso</b> .</p><br/>

							  <p ALIGN="justify"> Luego se le da clic al botón <b>Registrar</b> para guardar el contenido o <b>Cancelar</b> para salir del formulario.</p><br/>

							  <p ALIGN="justify">En caso de no realizar ningún registro, se puede regresar al contenido y salir del área. </p>
						      <p ALIGN="justify">Dándole clic en "<b><FONT SIZE=5> < </font></b>" al lado de la palabra <b>Tema</b>, del lado izquierdo del área central. </p><br/>
					</div>
				</div>
			</div>
		</div>	
	</body>
</html>																																																																									