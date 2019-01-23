<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	

	if(!empty($_GET))
	{
		$idUsuario=$_GET['idu'];
		$areapropia=false;
		if(empty($idUsuario)){
			$idUsuario = $_SESSION['id_usuario'];
			$areapropia=true;
		}
	}
	else{
		$idUsuario = $_SESSION['id_usuario'];
		$areapropia=true;
	}
	if($_SESSION["tipo_usuario"]==3){
		$idUsuario = $_SESSION['id_usuario'];
		$areapropia=true;	
	}
	$sql = "SELECT * FROM ovausuarios WHERE id = '$idUsuario'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	$tipousuario=$row['id_tipo'];
	$sqltu = "SELECT tipo FROM ovatipousuario WHERE id = '$tipousuario'";
	$resultadotu = $mysqli->query($sqltu);
	$rowtu = $resultadotu->fetch_array(MYSQLI_ASSOC);
	$_SESSION['cualtu']="";
	$_SESSION['cualareac']="";	
	
?>
<html>
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: <?php if($areapropia){?>Área de Usuario<?php } else { ?>Información de <?php if($_SESSION["tipo_usuario"]==1){?>Usuario<?php }else{?>Estudiante<?php } } ?></title>
		<link rel="stylesheet" href="static/css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/ovamiestilo.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/ovaactmiestilo.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/colores.php">
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js" ></script>
	</head>
	<body class="actividadcuerpo bodyadmin">
		<div class="container-fluid">
			<?php if($areapropia){echo MenuPrincipal("perfil");}else{echo MenuPrincipal("usuarios");} ?>	
			<div class="row">
				<div class="imgslidertmcn">					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 secciontitulos secciontitulosadmin">
						<div class="container tituloadmin"><?php if($areapropia){?>Área de Usuario<?php } else { ?>Información de <?php if($_SESSION["tipo_usuario"]==1){?>Usuario<?php }else{?>Estudiante<?php } } ?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="contenedortabla info">
				<div class="row">
					<div class="col-lg-6">
						<div class="row datos bienvenida">
							<div class="col-lg-12"><?php if($areapropia){?>Bienvenido(a)<?php } else {/*?><a href="administrarusuarios.php" data-toggle="tooltip" title="Regresar"><span class="glyphicon glyphicon-chevron-left"></span></a><?php */}?></div>
							<div class="col-lg-12"><?php echo $row['nombres'].' '.$row['apellidos']; ?></div>
							<div class="col-lg-12"><?php echo $rowtu['tipo'];?></div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="row datos datosusuario">
							<?php if($row['nick']!='admin'){ ?>
							<div class="col-lg-3 dutitulo">Alias</div><div class="col-lg-9 duinfo"><?php echo $row['nick'];?></div>			
							<div class="col-lg-3 dutitulo">Cédula</div><div class="col-lg-9 duinfo"><?php echo $row['cedula'];?></div>
							<div class="col-lg-3 dutitulo">Correo</div><div class="col-lg-9 duinfo"><?php echo $row['email'];?></div>
							<?php if($tipousuario==1 || $tipousuario==2){if(strlen(trim($row['profesion'])) > 0){echo '<div class="col-lg-3 dutitulo">Profesión</div><div class="col-lg-9 duinfo">'.$row['profesion'].'</div>';} }?>
							<?php if($tipousuario==3){if(strlen(trim($row['carrera'])) > 0){echo '<div class="col-lg-3 dutitulo">Carrera</div><div class="col-lg-9 duinfo">'.$row['carrera'].'</div>';} if(strlen(trim($row['semestre'])) > 0){echo '<div class="col-lg-3 dutitulo">Semestre</div><div class="col-lg-9 duinfo">'.$row['semestre'].'</div>';}} ?>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="row revresumen">
					<div class="col-lg-12">
						<?php
							$sqlpt = "SELECT * FROM ovapuntaje WHERE id_usuario = '$idUsuario' ORDER BY areac, tema";
							$resultpt = $mysqli->query($sqlpt);	
							$numfilaspt=$resultpt->num_rows;
							if($numfilaspt>0){
								$iac=0;
								while ($rowpt = $resultpt->fetch_array(MYSQLI_ASSOC)){
									$cac=$rowpt['areac'];
									$careac[$iac]=$cac;
									if($iac>0){
										if($careac[$iac]==$careac[$iac-1]){
											$mismaac=true;
										}
										else{
											$mismaac=false;
										}
									}
									if(!$mismaac){
										echo '<div class="row revtituloac">'.$cac.'</div>';
									}
									echo '<div class="row revinfo">';
									$ctm=$rowpt['tema'];									
									$sqltm = "SELECT id FROM ovatemas WHERE titulo = '$ctm'";
									$resulttm = $mysqli->query($sqltm);	
									$numfilastm=$resulttm->num_rows;						
									$rowtm = $resulttm->fetch_array(MYSQLI_ASSOC);								
									if($numfilastm>0){echo '<a href="tema.php?id='.$rowtm[id].'">';}
									echo '<div class="revtitulotema">'.$ctm.'</div>';
									if($numfilastm>0){echo '</a>';}
									echo "<a href='resumenev.php?idu=".$idUsuario."&tm=".$ctm."&ta=".$cac."'><div class='resumenpadre'>";
									echo "<div class='revcuadroinfo'>Fecha de evaluación:<span class='revcuadroinfotexto'><span class='revfecha'>".$rowpt['fecha']."</span><div class='revhora'>".$rowpt['hora']."</div></span></div>";
									/*echo "<div class='revcuadroinfo'>Cantidad de veces:<span class='revcuadroinfotexto'>".$rowpt['repeticiones']."</span></div>";*/
									$ptpt = explode("*+++*", $rowpt['preguntas']);
									$npt=sizeof($ptpt);
									$totalpt=0;
									$maxpt=0;
									$totalrcpt=0;
									for($ipt=0;$ipt<$npt;$ipt++){
										$ptptaux = explode("*///*", $ptpt[$ipt]);
										$maxpt=$maxpt+$ptptaux[5];
										if($ptptaux[4]==1){
											$totalpt=$totalpt+$ptptaux[5];
											$totalrcpt=$totalrcpt+1;
										}
									}
									$totalricpt=$rowpt['npreguntas']-$totalrcpt;
									echo "<div class='revcuadroinfo'>Respuestas correctas:<span class='revcuadroinfotexto'>".$totalrcpt.'/'.$rowpt['npreguntas']."</span></div>";
									echo "<div class='revcuadroinfo'>Respuestas incorrectas:<span class='revcuadroinfotexto'>".$totalricpt.'/'.$rowpt['npreguntas']."</span></div>";
									echo "<div class='revcuadroinfo'>Total de puntos:<span class='revcuadroinfotexto'>".$totalpt.'/'.$maxpt."</span></div>";
									echo '</div></a></div>';
									$iac=$iac+1;
								}								
							}
							else{
								echo "<div class='noevaluacion'>Aún no ha realizado ninguna evaluación</div>";
							}
						?>
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
						<p ALIGN="justify">Esta área de encarga de <b>Área de usuario</b>, el cual muestra la información del usuario y sus actividades.</p>

						      <p ALIGN="justify">Al darle clic a la fecha de la evaluación muestra la información acerca de las evaluaciones realizadas. </p>
							

							  <p ALIGN="justify">El área central de la página le muestra el resumen de actividades.</p> <br/> 
							
							  <p ALIGN="justify">También se encuentra en la parte superior derecha el botón de <b> Cerrar Sesión </b> para salir de la sesión.</p>
					</div>
				</div>
			</div>
		</div>	
	</body>
</html>