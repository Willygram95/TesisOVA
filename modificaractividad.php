<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';	
	require 'funciones/funciones.php';		
	$id = $_GET['id'];
	$id_tema = $_GET['tm'];
	$sql = "SELECT * FROM ovaseleccion WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
	
	$sqlte = "SELECT * FROM ovatiposactividades";
	$resultadote = $mysqli->query($sqlte);
	$resultadote2 = $mysqli->query($sqlte);
	
	$sqltm = "SELECT titulo FROM ovatemas WHERE id = '$id_tema'";
	$resultadotm = $mysqli->query($sqltm);
	$rowtm = $resultadotm->fetch_array(MYSQLI_ASSOC);	
?>
<html lang="es">
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Modificación de Actividad</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="static/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="css/ovamiestilo.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/colores.php">
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js"></script>
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
		
		<?php 			
		echo "<script language='javascript'>"; ?>
		$(document).ready(function(){
		seleccion = $("#tipo").val();
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
		<?php echo "</script>"; ?>	
		
		<script language='javascript'>
			$(document).ready(function(){
				seleccion = $("#numopciones").val();
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
							<div>Modificación de actividad</div>
						</div>  
					<div class="panel-body" >	
						<form class="form-horizontal" method="POST" action="actualizaractividad.php" autocomplete="off">
							<div class="form-group">
								<label for="enunciado" class="col-md-3 control-label">Enunciado</label>
								<div class="col-md-9">
									<textarea rows="20" class="form-control enunciadocorto" id="enunciado" name="enunciado" placeholder="Enunciado"><?php echo $row['enunciado']; ?></textarea>
								</div>
							</div>
							<div id="tiposeleccion" style="display:none;">
								<div class="form-group">
									<label for="numopciones" class="col-md-3 control-label">Número de opciones</label>
									<div class="col-md-9">
										<select class="form-control" id="numopciones" name="numopciones">
											<option value=3 <?php if($row['numopciones']==3) echo ' selected';?>>3</option>
											<option value=4 <?php if($row['numopciones']==4) echo ' selected';?>>4</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="opcion1" class="col-md-3 control-label">Opción 1</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="opcion1" placeholder="Opción 1" value="<?php echo $row['opcion1']; ?>" >
									</div>
								</div>	
								<div class="form-group">
									<label for="opcion2" class="col-md-3 control-label">Opción 2</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="opcion2" placeholder="Opción 2" value="<?php echo $row['opcion2']; ?>" >
										</div>
										</div>	
										<div class="form-group">
									<label for="opcion3" class="col-md-3 control-label">Opción 3</label>
									<div class="col-md-9">
									<input type="text" class="form-control" name="opcion3" placeholder="Opción 3" value="<?php echo $row['opcion3']; ?>" >
									</div>
								</div>	
								<div id="cuartaopcion" class="form-group" style="display:none;">
									<label for="opcion4" class="col-md-3 control-label">Opción 4</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="opcion4" placeholder="Opción 4" value="<?php echo $row['opcion4']; ?>" >
									</div>
								</div>	
								<div id ="3opciones" class="form-group">
									<label for="opcioncorrecta3o" class="col-md-3 control-label">Opción correcta</label>
									<div class="col-md-9">
										<select class="form-control" id="opcioncorrecta3o" name="opcioncorrecta3o">										
											<?php for($i=1;$i<=3;$i++) { ?>							
												<option value=<?php echo $i; if($row['opcioncorrecta']==$i) echo ' selected';?>><?php echo $i; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div id ="4opciones" class="form-group"  style="display:none;">
									<label for="opcioncorrecta4o" class="col-md-3 control-label">Opción correcta</label>
									<div class="col-md-9">
										<select class="form-control" id="opcioncorrecta4o" name="opcioncorrecta4o">										
											<?php for($i=1;$i<=4;$i++) { ?>							
												<option value=<?php echo $i; if($row['opcioncorrecta']==$i) echo ' selected';?>><?php echo $i; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div id ="tipovof" class="form-group" style="display:none;">
								<label for="opcioncorrectavof" class="col-md-3 control-label">Opción correcta</label>
								<div class="col-md-9">
									<select class="form-control" id="opcioncorrectavof" name="opcioncorrectavof">	
										<option value=1 <?php if($row['opcioncorrecta']==1) echo ' selected';?>>Verdadero</option>
										<option value=2 <?php if($row['opcioncorrecta']==2) echo ' selected';?>>Falso</option>
									</select>
								</div>
							</div>
							
							<input type="hidden" id="id" name="id" value="<?php echo $row['id']; ?>" />
							<input type="hidden" id="id_tema" name="id_tema" value="<?php echo $id_tema; ?>" />	
							<input type="hidden" id="tipo" name="tipo" value="<?php echo $row['tipo']; ?>" />	
							
							<div class="form-group">
								<div class="col-md-offset-3 col-md-9">									
									<button type="submit" class="btn">Guardar</button>
									<a href="administraractividades.php?id=<?php echo $id_tema; ?>" class="btn">Cancelar</a>
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
						<p ALIGN="justify">Esta área se encarga de <b>Modificación de actividad</b>, el cual consiste en editar las actividades del OVA que están registrada.</p><br/>
						<p ALIGN="justify">En caso de no realizar ningún registro, se puede regresar al contenido y salir del área. </p>
						      <p ALIGN="justify">Dándole clic en "<b><FONT SIZE=5> < </font></b>" al lado de la palabra <b>Tema</b>, del lado izquierdo del área central. </p><br/>
					</div>
				</div>
			</div>
		</div>	
	</body>
</html>																													