<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	/*if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index.php");
	}*/
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$id = $_GET['id'];
	$sql = "SELECT nombre,codigo FROM ovaasignatura";	
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
	$_SESSION["id_asignatura"]=$row['nombre'];
	$_SESSION['cualtu']="";
	$_SESSION['cualareac']="";	
?>
<!DOCTYPE html>
<html lang="es">
    <head>		
		<meta http-equiv="Content-Type" content="text/html"; charset="utf-8" /> 
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="static/css/bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="./css/ovamiestilo.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/colores.php">
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js"></script>
		<title><?php echo $_SESSION["id_asignatura"];?></title>
	</head>
	<body>
		<div class="container-fluid">
			<nav class='navbar-default navbar-fixed-top'>
				<div class='cintilloudo'></div>
			</nav>
			<div class="row">
				<div class="imgsliderinicio">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 contenedorbotonesverovaacinicio">		
						<div class="zonamembreteinicio">
							<img class='logoudoheaderinicio' src='imagenes/iconotm.svg'>
							<div>
								<span class='membrete'>Universidad Autonoma del caribe</span>
								<span class='membrete'>Facultad de ingenieria</span>
								<span class='membrete'>Programa de ingenieria de sistemas</span>
							
							</div>
							<div class="asignaturainicio">
								<div class="aprende">APRENDE EN UN CLICK</div>
									<?php echo $_SESSION["id_asignatura"]; ?>
								</div>							
						</div>	
						<a href="verova.php" class="btninicio">
								INICIAR
						</a>						
					</div>						
				</div>
			</div>	
			<div class="row txtbienvenida">
				Bienvenidos a los Objetos Virtuales de Aprendizaje dedicado a la enseñanza de <?php echo $_SESSION["id_asignatura"];?>, donde aprenderás de forma totalmente online todo lo relacionado con el tema y además podrás reforzar los conocimientos que adquieras a través de actividades y evaluaciones.
			</div>
			<div class="row txtsubtemas">
				<div class="aprenderas">APRENDERÁS ACERCA DE:</div>				
				<?php 
					$sql = "SELECT * FROM ovatemas WHERE status = '1'";
					$resultado = $mysqli->query($sql);
					while($row = $resultado->fetch_array(MYSQLI_ASSOC)) { ?>							
						<span class="glyphicon glyphicon-ok"></span><?php echo ' '.$row['titulo'].'   '; ?>
				<?php } ?>
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
						<ul class='nav navbar-nav navbar-right menuinferior'>
							<li><a href="#" data-toggle="modal" data-target="#mdcreditos">Créditos</a></li>
						</ul>
						<ul class='nav navbar-nav navbar-right menuinferior'>
							<li><a href="#" data-toggle="modal" data-target="#mdmetadatos">Metadatos</a></li>
						</ul>
						<ul class='nav navbar-nav navbar-right menuinferior'>
							<li><a href="#" data-toggle="modal" data-target="#mdobj">Objetivos de aprendizaje</a></li>
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
						<p ALIGN="justify">Este es un Objeto Virtual de Aprendizaje (OVA) </p>
							
							<p ALIGN="justify">Para comenzar a interectuar con el OVA debe seleccionar el botón <b>INICIAR</b>, para empezar las consultas de contenido y el aprendizaje del tema determinado.</p>
							
							
					</div>
				</div>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="mdcreditos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Crèditos</h4>
					</div>
					<div class="modal-body">
					    <center>
							<p ALIGN="justify"><h4>Realizado por</h4></p>
					                <p>William Lemus Bula (91326096)</p>
					                <p>Deybison Toro Bohórquez (91526130)</p>
					    </center>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="mdmetadatos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Metadatos</h4>
					</div>
					<div class="modal-body">
					    <p ALIGN="center"><center><h3>GENERAL OBJETO VIRTUAL DE APRENDIZAJE</h3></center></p>
					    <p ALIGN="justify"><h4>Título</h4></p>
						<p ALIGN="justify">Sistemas masa resorte simple y masa resorte amortiguador</p><br/>
						<p ALIGN="justify"><h4>Descripción</h4></p>
						<p ALIGN="justify">Animación interactiva hecha en unity relacionado con los sistemas de masa resorte simple y amortiguador como recurso digital educativo con el objetivo de apoyar el proceso de enseñanza - aprendizaje de la física, donde a traves de ella se puede predecir variables de estados entre la frecuancia angular, las posiciones con respecto al tiempo y su amplitud de oscilacion mediante una grafica</p><br/>
						<p ALIGN="justify">La simplicidad con que la animación enuncia y presenta los sistemas en estudio la hacen apropiada para utilizarla en el contexto educativo por parte de estudiantes y docentes, así como por cualquier persona interesada en conocer sobre esta temática desarrollada en física. En el contexto universitario, la animación es un material indispensable para el entendimiento de los principios físicos necesarios que todo profesional necesita en su campo de acción.</p><br/>
						<p ALIGN="justify"><h4>Idioma</h4></p>
						<p ALIGN="justify">Español</p><br/>
						<p ALIGN="justify"><h4>Palabras Claves</h4></p>
						<p ALIGN="justify">Objeto Virtual de Aprendizaje, Sistemas dinámicos</p><br/>
						<p ALIGN="center"><center><h3>CICLO DE VIDA</h3></center></p>
						<p ALIGN="justify"><h4>Autores</h4></p>
						<p ALIGN="justify">William Lemus Bula</p>
						<p ALIGN="justify">Deybison Toro Bohórquez</p><br/>
						<p ALIGN="justify"><h4>Entidad</h4></p>
						<p ALIGN="justify">Universidad Autónoma del Caribe</p><br/>
						<p ALIGN="justify"><h4>Ubicación</h4></p>
						<p ALIGN="justify">www.walsystem.com</p><br/>
						<p ALIGN="justify"><h4>Versión</h4></p>
						<p ALIGN="justify">1.0</p><br/>
						<p ALIGN="justify"><h4>Fecha</h4></p>
						<p ALIGN="justify">22 de Octubre de 2018</p><br/>
						<p ALIGN="center"><center><h3>EDUCACIONAL</h3></center></p>
						<p ALIGN="justify"><h4>Contexto de aprendizaje</h4></p>
						<p ALIGN="justify">Educacion media y superior</p><br/>
						<p ALIGN="justify"><h4>Poblacion y objetivo</h4></p>
						<p ALIGN="justify">Docente y estudiantes</p><br/>
						<p ALIGN="center"><center><h3>DERECHOS</h3></center></p>
						<p ALIGN="justify"><h4>Costo</h4></p>
						<p ALIGN="justify">Libre</p><br/>
						<p ALIGN="justify"><h4>Derechos de autor</h4></p>
						<p ALIGN="justify">No permitir un uso comercial de la animación. Permitir modificaciones en el simulador y en el OVA en general</p><br/>
						<p ALIGN="center"><center><h3>CLASIFICACIÓN</h3></center></p>
						<p ALIGN="justify"><h4>Fuentes de clasificacion</h4></p>
						<p ALIGN="justify">Area de conocimiento fisica, sistemas dinamicos - uso educativo</p><br/>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="mdobj" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Objetivos de aprendizaje</h4>
					</div>
					<div class="modal-body">
						<p ALIGN="justify">1) Identificar la expresión matemática utilizada para hallar la posicion a traves del tiempo de una masa que oscila atada a un resorte. </p><br/>
						<p ALIGN="justify">2) Visualizar la gráfica que relaciona el periodo de oscilación con la amplitud de oscilación de un sistema masa resorte.</p><br/>
						<p ALIGN="justify">3) Deducir la ley que rige el periodo de oscilación y la amplitud de movimiento de una masa que oscila atada a un resorte.</p><br/>
						<p ALIGN="justify">4) Observar los comportamientos en cada sistema masa resorte.</p><br/>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>								