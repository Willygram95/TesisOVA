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
		$ttema=$_GET['tm'];
		$tareac=$_GET['ta'];
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
							<div class="col-lg-12"><?php if($areapropia){?>Bienvenid@<?php } else {/*?><a href="administrarusuarios.php" data-toggle="tooltip" title="Regresar"><span class="glyphicon glyphicon-chevron-left"></span></a><?php */}?></div>
							<div class="col-lg-12"><?php echo $row['nombres'].' '.$row['apellidos']; ?></div>
							<div class="col-lg-12"><?php echo $rowtu['tipo'];?></div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="row datos datosusuario">
							<div class="col-lg-3 dutitulo">Alias</div><div class="col-lg-9 duinfo"><?php echo $row['nick'];?></div>			
							<div class="col-lg-3 dutitulo">Cédula</div><div class="col-lg-9 duinfo"><?php echo $row['cedula'];?></div>
							<div class="col-lg-3 dutitulo">Correo</div><div class="col-lg-9 duinfo"><?php echo $row['email'];?></div>
							<?php if($tipousuario==1 || $tipousuario==2){if(strlen(trim($row['profesion'])) > 0){echo '<div class="col-lg-3 dutitulo">Profesión</div><div class="col-lg-9 duinfo">'.$row['profesion'].'</div>';} }?>
							<?php if($tipousuario==3){if(strlen(trim($row['carrera'])) > 0){echo '<div class="col-lg-3 dutitulo">Carrera</div><div class="col-lg-9 duinfo">'.$row['carrera'].'</div>';} if(strlen(trim($row['semestre'])) > 0){echo '<div class="col-lg-3 dutitulo">Semestre</div><div class="col-lg-9 duinfo">'.$row['semestre'].'</div>';}} ?>
						</div>
					</div>
				</div>
							<?php 
							$sqlpt = "SELECT * FROM ovapuntaje WHERE id_usuario = '$idUsuario' AND tema = '$ttema' AND areac = '$tareac'ORDER BY areac, tema";
							$resultpt = $mysqli->query($sqlpt);	
							$numfilaspt=$resultpt->num_rows;
							if($numfilaspt>0){
								$rowpt = $resultpt->fetch_array(MYSQLI_ASSOC);
								$ptpt = explode("*+++*", $rowpt['preguntas']);
								$npt=sizeof($ptpt);
								$totalpt=0;
								$maxpt=0;
								$totalrcpt=0;
								for($ipt=0;$ipt<$npt;$ipt++){
									$ptptaux = explode("*///*", $ptpt[$ipt]);
									$evpregunta[$ipt]=$ptptaux[1];
									$evrespuestacorrecta[$ipt]=$ptptaux[2];
									$evturespuesta[$ipt]=$ptptaux[3];
									$evcorreccion[$ipt]=$ptptaux[4];
									$maxpt=$maxpt+$ptptaux[5];
									if($ptptaux[4]==1){
										$totalpt=$totalpt+$ptptaux[5];
										$totalrcpt=$totalrcpt+1;
									}
								}
							?>
							<div>
								<div class="row revresumen">
									<div class="actividadresumen revtresumen"><span class="evregresardiv"><a href="areadeusuario.php?idu=<?php echo $idUsuario;?>" data-toggle="tooltip" title="Regresar" class="evregresar"><span class="glyphicon glyphicon-chevron-left"></span></a></span>RESÚMEN DE RESULTADOS OBTENIDOS:</div>
									<div class="revtituloacpq"><?php echo $tareac?></div>
									<div class="revtitulotemagd"><?php echo $ttema;?></div>	
									<div class="revfechahora"><?php echo $rowpt['fecha']." ".$rowpt['hora'];?></div>								
									<?php 
										$tinc=$npt-$totalrcpt;
										echo "<div class='resumenpadre'><div class='actividadresumencuadrototal'>Respuestas correctas:<span class='actividadrespuestatotalresumen'>".$totalrcpt."/".$npt."</span></div>";
										echo "<div class='actividadresumencuadrototal'>Respuestas incorrectas:<span class='actividadrespuestatotalresumen'>".$tinc."/".$npt."</span></div>";
										echo "<div class='actividadresumencuadrototal'>Total de puntos obtenidos:<span class='actividadrespuestatotalresumen'>".$totalpt."/".$maxpt."</span></div></div>";
										$preguntas='';
										for ($i = 0; $i < $npt; $i++) {  
											/*$cualev=$_SESSION['evseleccionados'][$i];
											$sqlev = "SELECT * FROM ovaseleccion WHERE id=$cualev";
											$resultadoev = $mysqli->query($sqlev);
											$rowev = $resultadoev->fetch_array(MYSQLI_ASSOC);*/
											$j=$i+1;											
											echo "<div class='actividadresumenfila'><div class='actividadencabzadofilaresumen'><span id='cuadronumeroresumen".$j."' class='cuadradoalrededor cuadronumresumen'>".$j."</span>";
											echo "<div class='actividadenunciadoresumen'>".$evpregunta[$i]."</div></div>";
											echo "<div class='revtcuadro'>Tu respuesta:<span class='actividadrespuestaresumen'>".$evturespuesta[$i]."</span></div>";
											echo "<div class='revtcuadro'>Revisión:<span class='actividadrespuestaresumen'>";
											if($evcorreccion[$i]=='1'){
												echo "Correcta</span></div></div>";
												echo "<script>document.getElementById('cuadronumeroresumen".$j."').style.backgroundColor='lightgreen';</script>";
												}else{												
												echo "<script>document.getElementById('cuadronumeroresumen".$j."').style.backgroundColor='red';</script>";
												echo "Incorrecta</span></div><div class='revtcuadro'>Respuesta correcta:<span class='actividadrespuestaresumen'>".$evrespuestacorrecta[$i]."</span></div></div>";
											}
										}?>
								</div>
							</div>
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
						<p ALIGN="justify">Esta área se encarga de <b>Resumen de evalución</b>, el cual consiste en un resumen de ejercicio del OVA e indicando su puntaje.</p>

						      <p ALIGN="justify">El área central de la página se muestra la serie de actividades registrada.</p><br/>

						     
						     
						      <p ALIGN="justify">En caso de no realizar ningún registro, se puede regresar al contenido y salir del área. </p>
						      <p ALIGN="justify">Dándole clic en "<b><FONT SIZE=5> < </font></b>" al lado de la palabra <b>Tema</b>, del lado izquierdo del área central. </p><br/>
					</div>
				</div>
			</div>
		</div>	
	</body>
</html>