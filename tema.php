<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	/*if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index.php");
	}*/
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	
	$id = $_GET['id'];
	$sql = "SELECT * FROM ovatemas WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
	$idareac= $row['id_areac'];
	$titulovideo= $row['titulovideo'];
	$tituloaudio= $row['tituloaudio'];
	$tituloexterno= $row['tituloexterno'];
	$enlacevideo= $row['enlacevideo'];
	$archivoaudio= $row['archivoaudio'];
	/*$archivoaudio= "prueba.mp3";*/
	$contenidoexterno= $row['contenidoexterno'];
	$_SESSION['cualtu']="";
	$_SESSION['cualareac']="";	
	
	$sqlcl = "SELECT * FROM ovadiseno";
	$resultadocl = $mysqli->query($sqlcl);
	$rowcl = $resultadocl->fetch_array(MYSQLI_ASSOC);

	$colorprincipal=$rowcl['colorprincipal'];
	$colorresaltado=$rowcl['colorsecundario'];
	
	
	$sqlac = "SELECT titulo FROM ovaareasc WHERE id='$idareac'";
	$resultadoac = $mysqli->query($sqlac);
	$rowac = $resultadoac->fetch_array(MYSQLI_ASSOC);
	
	$sqlbi = "SELECT * FROM ovabibliografia ORDER BY titulo ASC";
	$resultadobi = $mysqli->query($sqlbi);
	
	$sqlen = "SELECT * FROM ovaenlaces WHERE id_tema='$id' ORDER BY titulo ASC";
	$resultadoen = $mysqli->query($sqlen);
	$numfilasen=$resultadoen->num_rows;
	
	$sqltc = "SELECT * FROM ovatemascontenidos WHERE id_tema='$id' ORDER BY orden";
	$resultadotc = $mysqli->query($sqltc);
	
	$sqlar = "SELECT id FROM ovaarchivos WHERE id_tema='$id'";
	$resultadoar = $mysqli->query($sqlar);
	$rowar = $resultadoar->fetch_array(MYSQLI_ASSOC);
	$numfilasar=$resultadoar->num_rows;
	
	//Selección de actividad
	//$tipoej=$_SESSION['tipoej']=1;
	$numerogpej=$_SESSION['numerogpej']=1;
	$sqlej = "SELECT * FROM ovaseleccion WHERE id_tema='$id' AND status=1 AND numerogrupo=$numerogpej AND categoria=1 ORDER BY orden ASC";
	$resultadoej = $mysqli->query($sqlej);
	$numfilasej=$resultadoej->num_rows;
	
	if($numfilasej>0){
		$_SESSION['conteoej']=1;
		$_SESSION['nummaxej']=$numfilasej;
	}
	
	while($rowej = $resultadoej->fetch_array(MYSQLI_ASSOC)) { 
		$ejseleccionados[]=$rowej['id'];	
	}
	$_SESSION['ejseleccionados']=$ejseleccionados;

	//Selección de evaluación
	$numerogpev=$_SESSION['numerogpev']=1;
	$sqlev = "SELECT * FROM ovaseleccion WHERE id_tema='$id' AND status=1 AND numerogrupo=$numerogpev AND categoria=2 ORDER BY orden ASC";
	$resultadoev = $mysqli->query($sqlev);
	$numfilasev=$resultadoev->num_rows;
	
	if($numfilasev>0){
		$_SESSION['conteoev']=1;
		$_SESSION['nummaxev']=$numfilasev;
	}
	
	while($rowev = $resultadoev->fetch_array(MYSQLI_ASSOC)) { 
		$evseleccionados[]=$rowev['id'];	
	}
	$_SESSION['evseleccionados']=$evseleccionados;
	
?>
<html lang="es">
    <head>		
		<meta http-equiv="Content-Type" content="text/html"; charset=utf-8"/> 
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="static/css/bootstrap.min.css">
		<link type="text/css" rel="stylesheet" href="css/ovamiestilo.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/colores.php">
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js"></script>
		<title><?php echo $_SESSION["id_asignatura"];?></title>		
	</head>
	<body class="bodycontenido">
		<div class="container-fluid">
			<?php echo MenuPrincipal("verova"); ?>	
			<div class="row">
				<div class="imgslidertm imgslidertmcn">					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 secciontitulos">
						<div><a href="verova.php">Inicio</a> · <a href="verac.php?id=<?php echo $idareac; ?>"><?php echo $rowac['titulo']; ?></a> <a class="" href="verac.php?id=<?php echo $idareac; ?>" data-toggle="tooltip" title="Regresar"><span class="glyphicon glyphicon-chevron-left"></span></a> <?php echo $row['titulo']; ?></div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="col-md-3">
					<div class="menulateral">
						<ul class="nav nav-pills nav-stacked opcionesmenulateral">
							<li id="opcionml1" class="opcionmenulateral" role="presentation" onmouseenter="encimaopcionlateral(1)" onmouseleave="saliropcionlateral(1)" onclick="clicopcionlateral(1)"><a href="#">Introducción</a></li>					
							<?php $ist=2; while($rowtc = $resultadotc->fetch_array(MYSQLI_ASSOC)) {	
								if($rowtc['status']==1) { ?>
								<li id="opcionml<?php echo $ist;?>" class="opcionmenulateral" role="presentation" onmouseenter="encimaopcionlateral(<?php echo $ist;?>)" onmouseleave="saliropcionlateral(<?php echo $ist;?>)" onclick="clicopcionlateral(<?php echo $ist;?>)"><a href="#"><?php echo $rowtc['titulo']; $ist++;?></a></li>
								<?php } 
							} ?> 
							<script language='javascript'>	
								numopcioneslaterales=<?php echo $ist;?>;
							</script>
						</ul>
					</div>
				</div>
				<div class="col-md-9 contenedorcontenido">	
					<div class="contenidoopcionlateral" id="1">						
						<h1><p class="titulobotonregresar">Introducción</p></h1>
						<p><?php echo prepararparaimagenes($row['introduccion']); ?></p>
					</div>
					<?php  $resultadotc->data_seek(0); $ist=2; while($rowtc = $resultadotc->fetch_array(MYSQLI_ASSOC)) {	
						if($rowtc['status']==1) { ?>
						<div class="contenidoopcionlateral" style="display:none" id="<?php echo $ist;?>">
							<h1><p class="titulobotonregresar"><?php echo $rowtc['titulo'];?></p></h1>
							<p><?php echo prepararparaimagenes($rowtc['contenido']); $ist++; ?></p>
						</div>
						<?php } 
					} ?> 
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
							<?php if($numfilasen>0){?><li><a href="#" data-toggle="modal" data-target="#mdenlaces">Enlaces</a></li><? } ?>
							<li><a href="#" data-toggle="modal" data-target="#mdayuda">Ayuda</a></li>
							<?php if($numfilasej>0){?><li><a href="actividad.php?id=<?php echo $id?>">Actividades</a></li><? } ?>
							<?php if(($numfilasev>0) && (isset($_SESSION["id_usuario"]))){?><li><a href="evaluacion.php?id=<?php echo $id?>">Evaluación</a></li><? } ?>
							<?php if(strlen(trim($enlacevideo)) > 0){?><li><a href="#" data-toggle="modal" data-target="#mdvideo">Video</a></li><? } ?>
							<?php if(strlen(trim($archivoaudio)) > 0){?><li><a href="#" data-toggle="modal" data-target="#mdaudio">Audio</a></li><? } ?>
							<?php if(strlen(trim($contenidoexterno)) > 0){?><li><a href="javascript:;" data-toggle="modal" data-target="#mdcontenidoexterno"><? echo $tituloexterno;?></a></li><? } ?>
						</ul>
						<?php if($numfilasar>0){?>
							<ul class="nav navbar-nav navbar-right menuinferior">
								<li><a href="descargarPDF.php?id=<?php echo $id?>"><span class="glyphicon glyphicon-save"></span> Descargar PDF</a></li>
							</ul>
						<? } ?>
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
						<?php echo prepararparaimagenes($row['ayuda']); ?>
					</div>
				</div>
			</div>
		</div>	
		<!-- Modal -->
		<div class="modal fade" id="mdvideo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-externo">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="pauseVideo();">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><?php echo $titulovideo;?></h4>
					</div>
					<div class="modal-body">
						<span id="bodyvideo">
							<div id='player'></div><?php $enlacevideo = str_replace('http://', '', $enlacevideo);$enlacevideo = str_replace('https://', '', $enlacevideo);$partes = explode('/', $enlacevideo);$partes = explode('=',$partes[1]);?>
						</span>
					</div>					
				</div>
			</div>
		</div>	
		<!-- Modal -->
		<div class="modal fade" id="mdaudio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><?php echo $tituloaudio;?></h4>
					</div>
					<div class="modal-body">
						<span id="bodyaudio">
							<audio id ="elaudio" style="width: 100%;" src="<?php echo 'audio/'.$archivoaudio;?>" preload="auto" controls><p>Tu navegador no implementa el elemento audio</p></audio>
						</span>								
					</div>
				</div>
			</div>
		</div>	
		<!-- Modal -->
		<div class="modal fade" id="mdcontenidoexterno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-externo">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><?php echo $tituloexterno;?></h4>
					</div>
					<div class="modal-body">
						<span id="bodyexterno"></span>
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
		<div class="modal fade" id="mdenlaces" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Enlaces</h4>
					</div>
					<div class="modal-body">
						<div class="row table-responsive tablacentrada">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Título</th>
										<th>URL</th>
									</tr>						
								</thead>
								<tbody>
									
									<?php while($rowen = $resultadoen->fetch_array(MYSQLI_ASSOC)) { ?>							
										<tr>								
											<td><?php echo $rowen['titulo']; ?></td>
											<td><a href="http://<?php echo $rowen['url']; ?>" target="_blank"><?php echo $rowen['url']; ?></a></td>
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
	<script language='javascript'>		
				var cualomlseleccionada="1";
				var opc=document.getElementById("opcionml1");
				opc.style.borderLeftColor="<?php echo $colorprincipal; ?>";
				var opca=document.getElementById("opcionml1").getElementsByTagName('a')[0];
				opca.style.color="<?php echo $colorprincipal; ?>";
			
			function saliropcionlateral(cual){
				if(cual!=cualomlseleccionada){
					var opc=document.getElementById("opcionml"+cual);
					opc.style.borderLeftColor="rgba(121,155,181,0.6)";
					var opca=document.getElementById("opcionml"+cual).getElementsByTagName('a')[0];
					opca.style.color="#5b778b";
				}
			}

			function encimaopcionlateral(cual){
				if(cual!=cualomlseleccionada){
					for (var i=1;i<numopcioneslaterales;i++){ 
					if(i!=cualomlseleccionada){
						var opc=document.getElementById("opcionml"+i);
						opc.style.backgroundColor="#eeeeee";
						opc.style.borderLeftColor="rgba(121,155,181,0.6)";
					}
					}
				
					var opc=document.getElementById("opcionml"+cual);
					opc.style.borderLeftColor="#2d3a44";
					var opca=document.getElementById("opcionml"+cual).getElementsByTagName('a')[0];
					opca.style.color="#2d3a44";
				}
			}
			
			function clicopcionlateral(cual) {
				cualomlseleccionada=cual;
				for (var i=1;i<numopcioneslaterales;i++){ 
					var diveste = document.getElementById(i.toString());
					diveste.style.display = "none";
					var opc=document.getElementById("opcionml"+i);
					opc.style.backgroundColor="#eeeeee";
					opc.style.borderLeftColor="rgba(121,155,181,0.6)";
					var opca=document.getElementById("opcionml"+i).getElementsByTagName('a')[0];
					opca.style.color="#5b778b";
				}
				var diveste = document.getElementById(cual);
				diveste.style.display = "inherit";
				var opc=document.getElementById("opcionml"+cual);
				opc.style.borderLeftColor="<?php echo $colorprincipal; ?>";
				var opca=document.getElementById("opcionml"+cual).getElementsByTagName('a')[0];
				opca.style.color="<?php echo $colorprincipal; ?>";
			}
		     

		      // This code loads the IFrame Player API code asynchronously.
			      var tag = document.createElement('script');

			      tag.src = "https://www.youtube.com/iframe_api";
			      var firstScriptTag = document.getElementsByTagName('script')[0];
			      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

		      // This function creates an <iframe> (and YouTube player)
		      // after the API code downloads.
		      var player;
		      function onYouTubeIframeAPIReady() {
		        player = new YT.Player('player', {
		          height: '80%',
		          width: '100%',
		          videoId: '<?php echo $partes[1];?>',
		          events: {
		            /*'onReady': onPlayerReady*/
		          }
		        });
		      }

		      // The API will call this function when the video player is ready.
		      /*function onPlayerReady(event) {
		        event.target.playVideo();
		      }*/

		      // The API calls this function when the player's state changes.
		      // The function indicates that when playing a video (state=1),
		      // the player should play for six seconds and then stop.
		      /*var done = false;
		      function onPlayerStateChange(event) {
		        if (event.data == YT.PlayerState.PLAYING && !done) {
		          setTimeout(stopVideo, 6000);
		          done = true;
		        }
		      }
		      function stopVideo() {
		        player.stopVideo();
		      }*/
		      function pauseVideo() {
		        player.pauseVideo();
		      }

		      $('#mdaudio').on('show.bs.modal', function (e) {
		      	
		      })

		      $('#mdaudio').on('hide.bs.modal', function (e) {
		      	var miaudio = document.getElementById("elaudio"); 
    			miaudio.pause(); 
		      })

		      $('#mdvideo').on('hide.bs.modal', function (e) {
		      	pauseVideo();
		      })

		      $('#mdcontenidoexterno').on('show.bs.modal', function (e) {
		      	document.getElementById("bodyexterno").innerHTML = "<?php echo '<iframe width=\"100%\" height=\"90%\" src=\"'.$contenidoexterno.'\" frameborder=\"0\" allowfullscreen></iframe>';?>";
		      })

		      $('#mdcontenidoexterno').on('hide.bs.modal', function (e) {
		      	document.getElementById("bodyexterno").innerHTML = " ";
		      })

		</script>
</html>																																																																																																																						