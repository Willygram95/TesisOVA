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
	$_SESSION["id_codasignatura"]=$row['codigo'];
	$sql = "SELECT * FROM ovatemas WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
	$_SESSION['cualtu']="";
	$_SESSION['cualareac']="";	

	$sqlbi = "SELECT * FROM ovabibliografia ORDER BY titulo ASC";
	$resultadobi = $mysqli->query($sqlbi);
	
	$sqlac = "SELECT * FROM ovaareasc ORDER BY orden";
	$resultadoac = $mysqli->query($sqlac);	
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
			<?php echo MenuPrincipal("verova"); ?>	
			<div class="row">
				<div class="imgslider">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 contenedorbotonesverovaac">						
						<?php $contador=1; while($rowac = $resultadoac->fetch_array(MYSQLI_ASSOC)) { ?>							
							<?php if($rowac['status']==1) { /*if($contador==1){ echo "<div class='botonacgrupo'>";}*/?>
									<a class="abotonac" href="verac.php?id=<?php echo $rowac['id']; ?>">
										<div class="botonac">									
											<img class="iconoac" src="imagenes/iconoac.svg"/>
											<p class="textobotonac"><?php echo $rowac['titulo']; ?></p>
											<div class="lineabotonac"></div>
											<div class="fondobotonac"></div>
											<div class="fondobotonacizq"></div>
											<div class="fondobotonacder"></div>	
										</div>							
									</a>
							<?php /*$contador=$contador+1;if($contador==4){$contador=1;echo "</div>";}*/} ?>
						<?php } /*if($contador!=1){echo "</div>";}*/?>
						<div class="divauxinferior"></div>							
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
							<li><a href="#" data-toggle="modal" data-target="#mdglosario">Glosario</a></li>
							<li><a href="#" data-toggle="modal" data-target="#mdbibliografia">Bibliografía</a></li>
							<li><a href="#" data-toggle="modal" data-target="#mdayuda">Ayuda</a></li>
						</ul>
						<ul class='nav navbar-nav navbar-right menuinferior'>
							<li><a href="#" data-toggle="modal" data-target="#mdcreditos">Créditos</a></li>
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
						<p ALIGN="justify">Este es un Objeto Virtual de Aprendizaje (OVA) en apoyo al proceso didactico de Programación Lineal.</p>
							
							<p ALIGN="justify">Para consultas de contenido elige una de las áreas que se presenta en la entrada del OVA, ubicada en el centro de la página.</p>
							
							<p ALIGN="justify">También se encuentra en la parte superior derecha el botón de <button> Iniciar Sesión </button> para entrar como estudiante o profesor y obtener los privilegios que le consede el OVA.</p>
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
						<h4 class="modal-title" id="myModalLabel">Créditos</h4>
					</div>
					<div class="modal-body">
						<p ALIGN="justify">Objeto Virtual de Aprendizaje (OVA) </p><br/>
							
							<p ALIGN="justify">CREDITOS AQUI</p>
							
					</div>
				</div>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="mdbibliografia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Bibliografía</h4>
					</div>
					<div class="modal-body">
						<div class="row table-responsive tablacentrada">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Título</th>
										<th>Autor(es)</th>
										<th>Más información</th>										
									</tr>						
								</thead>
								<tbody>
									
									<?php while($rowbi = $resultadobi->fetch_array(MYSQLI_ASSOC)) { ?>							
										<tr>								
											<td><?php echo $rowbi['titulo']; ?></td>
											<td><?php echo $rowbi['autor']; ?></td>
											<td><?php echo $rowbi['info']; ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>	
		<!-- Modal -->
		<div class="modal fade" id="mdglosario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Glosario</h4>						
						<ul class="nav nav-tabs">
							
							<?php $letras="abcdefghijklmnopqrstuvwxyz";
								for($i=0;$i<strlen($letras);$i++)
								{ ?>
								
								<li <?php if($letras[$i]=='a'){?>class="bntglosario active"<?php }else{?>class="bntglosario"<?php } ?>><a data-toggle="tab" href="#letra<?php echo $letras[$i];?>"><?php echo $letras[$i];?></a></li>
								
							<?php } ?>
						</ul>							
						<div class="tab-content">
							<?php $letras="abcdefghijklmnopqrstuvwxyz";
								for($i=0;$i<strlen($letras);$i++)
								{ ?>
								
								<div id="letra<?php echo $letras[$i];?>" <?php if($letras[$i]=='a'){?>class="tab-pane fade in active"<?php }else{?> class="tab-pane fade"<?php }?>>
									<div class="row table-responsive tablacentrada">
										<table class="table table-striped">
											<tbody>									
												<?php 		
													$valor=$letras[$i];
													$sqlgl = "SELECT * FROM ovaglosario WHERE termino LIKE '$valor%' ORDER BY termino ASC";
													$resultadogl = $mysqli->query($sqlgl);
													if($resultadogl->num_rows>0){
														while($rowgl = $resultadogl->fetch_array(MYSQLI_ASSOC)) { ?>							
														<tr>								
															<td><strong><?php echo $rowgl['termino']; ?></strong>
															</br><?php echo prepararparaimagenes($rowgl['definicion']); ?></td>
														</tr>
													<?php }}else{echo "<div class='sincontenido'>No hay términos por la letra <span style='text-transform:uppercase;'>".$letras[$i]."</span></div>";} ?>
											</tbody>
										</table>
									</div>								
								</div>								
							<?php } ?>
						</div>								
					</div>
					<div class="modal-body">						
					</div>
				</div>
			</div>
		</div>		
	</body>
</html>								