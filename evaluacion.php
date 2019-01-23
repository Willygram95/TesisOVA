<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';
	
	$resumenresultados=false;
	
	if(!empty($_POST))
	{
		$id = $_POST['id'];
		$idareac = $_POST['idareac'];		

		for($i=0;$i<$_SESSION['nummaxev'];$i++){			
			$j=$i+1;
			$cop='opcion'.$j;
			$respuesta[$i] = $_POST[$cop];
			
			
			$cop='vl'.$j;
			$valor[$i] = $_POST[$cop];
			$cop='rc'.$j;
			$rc[$i] = "opcion".$j."-".$_POST[$cop];	
			

			$turespuesta="turespuesta".$j;
			$respuestaaux=explode("-",$respuesta[$i]);
			$_SESSION[$turespuesta]="opcion".$respuestaaux[1];

			$_SESSION['maxvalor']=$_SESSION['maxvalor']+$valor[$i];		

			$pregunta="pregunta".$j;

			if($respuesta[$i]==$rc[$i]){
				$_SESSION[$pregunta]=true;	
				$_SESSION['valortotal']=$_SESSION['valortotal']+$valor[$i];	
				$_SESSION['totalcorrectas']=$_SESSION['totalcorrectas']+1;				
			}
			else{
				$_SESSION[$pregunta]=false;		
			}
				
		}		
		/*if($_SESSION[$j]>$_SESSION['nummaxev']){
			$resumenresultados=true;
		}*/
		$resumenresultados=true;
	}
	else{		
		$id = $_GET['id'];
		$sql = "SELECT * FROM ovatemas WHERE id = '$id'";
		$resultado = $mysqli->query($sql);
		$row = $resultado->fetch_array(MYSQLI_ASSOC);
		$idareac= $row['id_areac'];
		$ttema=$row['titulo'];
		$_SESSION['cualtu']="";
		$_SESSION['cualareac']="";	
		$_SESSION['valortotal']=0;
		$_SESSION['totalcorrectas']=0;
		$_SESSION['maxvalor']=0;		
		
		$sqlac = "SELECT titulo FROM ovaareasc WHERE id='$idareac'";
		$resultadoac = $mysqli->query($sqlac);
		$rowac = $resultadoac->fetch_array(MYSQLI_ASSOC);
		$tareac=$rowac['titulo'];
		$_SESSION['idareactitulo']=$idareac;
		$_SESSION['tituloareactitulo']=$tareac;
		$_SESSION['titulotematitulo']=$ttema;
	}
	$sqlcl = "SELECT * FROM ovadiseno";
	$resultadocl = $mysqli->query($sqlcl);
	$rowcl = $resultadocl->fetch_array(MYSQLI_ASSOC);

	$colorprincipal=$rowcl['colorprincipal'];
	$colorresaltado=$rowcl['colorsecundario'];
		
	/*$numerogpev=$_SESSION['numerogpev'];
	$conteoev=$_SESSION['conteoev'];	
	$cualev=$_SESSION['evseleccionados'][$conteoev-1];*/
	
	/*$sqlev = "SELECT * FROM ovaseleccion WHERE id_tema='$id' AND status=1 AND numerogrupo='$numerogpev' AND id='$cualev' AND categoria=2";
	$resultadoev = $mysqli->query($sqlev);
	$rowev = $resultadoev->fetch_array(MYSQLI_ASSOC);
	$numfilasev=$resultadoev->num_rows;
	$tipoev=$rowev['tipo'];	*/
	
?>
<!DOCTYPE html>
<html lang="es">
    <head>		
		<meta http-equiv="Content-Type" content="text/html"; charset=UTF-8"/> 
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="static/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/ovamiestilo.css">
		<link rel="stylesheet" href="css/ovaactmiestilo.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/colores.php">
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js"></script>
		<title><?php echo $_SESSION["id_asignatura"];?></title>		
	</head>
	<body class="actividadcuerpo bodyadmin">
		<div class="container-fluid">
			<?php echo MenuPrincipal("verova"); ?>	
			<div class="row">
				<div class="imgslidertm imgslidertmcn">					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 secciontitulos">
						<div><a href="verova.php">Inicio</a> · <a href="verac.php?id=<?php echo $_SESSION['idareactitulo']; ?>"><?php echo $_SESSION['tituloareactitulo']; ?></a> · <a href="tema.php?id=<?php echo $id; ?>" class="enlaceprincipal"><?php echo $_SESSION['titulotematitulo']; ?></a></div>
					</div>
				</div>
			</div>
		</div>		
		<div class="container">			
			<div class="row areasuperioradmin">
				<div class="container">
					<div class="row titulodetemaadmin">
						<a href="tema.php?id=<?php echo $id;?>" data-toggle="tooltip" title="Regresar"><span class="glyphicon glyphicon-chevron-left"></span></a>
						<span>Evaluación</span>
					</div>
				</div>
					<?php if(!$resumenresultados){ ?>
						<form id="ejercicioform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">			
							<div class="col-md-12">	
								<div class="actividadcuadrocompleto">
									<div class="actividadcuadrosuperior"></div>
									<div class="row actividadcuadro">
										<div class="actividadinstrucciones enunciadoinstrucciones" id="instrucciones">Lea detenidamente cada enunciado presentado y seleccione la respuesta correcta para cada uno:</div>
									</div>
									<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
									<input type="hidden" id="idareac" name="idareac" value="<?php echo $idareac; ?>" />
									<?php for ($iev = 1; $iev <= $_SESSION['nummaxev']; $iev++) {  
											$cualev=$_SESSION['evseleccionados'][$iev-1];
											$sqlev = "SELECT * FROM ovaseleccion WHERE id=$cualev";
											$resultadoev = $mysqli->query($sqlev);
											$rowev = $resultadoev->fetch_array(MYSQLI_ASSOC);
											$numopcionesce[$iev-1]=$rowev['numopciones'];
											$tipoev=$rowev['tipo'];?>							
									<div class="actividadcuadrosuperior"></div>
									<div class="row actividadcuadro">
										<!-- Enunciado -->
										<?php echo "<div class='actividadresumenfila'><div class='actividadencabzadofilaresumen'><span id='cuadronumeroresumen".$iev."' class='cuadradoalrededor cuadronumresumen'>".$iev."</span>";
											echo "<div class='actividadenunciadoresumen'>".$rowev['enunciado']."</div></div></div>";?>
										<?php if($tipoev==1){ ?>									
											<!-- Opciones -->
											<?php if(!$resumenresultados){?>
												<div class="actividadopciones">
													<?php for ($i = 1; $i <= $numopcionesce[$iev-1]; $i++) {  ?>
														<label onclick="clickradio()" class="enunciadoevaluacion" id="etiqueta<?php echo $iev.'-'.$i;?>" for="opcion<?php echo $iev.'-'.$i;?>"><div class="actividadopcion">
															<div class="radioevaluacion"><input type="radio" name="opcion<?php echo $iev;?>" id="opcion<?php echo $iev.'-'.$i;?>" value="opcion<?php echo $iev.'-'.$i;?>"/></div>
															<?php $nbop='opcion'.$i; echo $rowev[$nbop];?>
														</div>
														</label>
													<?php } ?>
												</div>																		
											<?php } ?>
											<? }else{ ?>
											<!-- Opciones -->
											<?php if(!$resumenresultados){?>
												<div class="actividadopciones">
													<label onclick="clickradio()" class="enunciadoevaluacion" id="etiqueta<?php echo $iev.'-';?>1" for="opcion<?php echo $iev.'-';?>1"><div class="actividadopcion"><div class="radioevaluacion"><input type="radio" name="opcion<?php echo $iev;?>" id="opcion<?php echo $iev.'-';?>1" value="opcion<?php echo $iev.'-';?>1"/></div>
													<?php echo $rowev['opcion1'];?></div></label>
													<label onclick="clickradio()" class="enunciadoevaluacion" id="etiqueta<?php echo $iev.'-';?>2" for="opcion<?php echo $iev.'-';?>2"><div class="actividadopcion"><div class="radioevaluacion"><input type="radio" name="opcion<?php echo $iev;?>" id="opcion<?php echo $iev.'-';?>2" value="opcion<?php echo $iev.'-';?>2"/></div>
													<?php echo $rowev['opcion2'];?></div></label>
												</div>																		
											<?php } ?>
										<? } ?>										
										<input type="hidden" id="rc<?php echo $iev;?>" name="rc<?php echo $iev;?>" value="<?php echo $rowev['opcioncorrecta']; ?>" />
										<input type="hidden" id="vl<?php echo $iev;?>" name="vl<?php echo $iev;?>" value="<?php echo $rowev['valor']; ?>" />
									</div>	
									<? } ?>	
									<div class="actividadpiecuadroeval">
										<input style="display:none" id="btncorregir" class="btngeneral btncorregir btncorregireval" type="submit" value="REVISAR" disabled />
									</div>									
								</div>								
							</div>												
						</form>																
						<?php }else{ ?>
						<div class="col-md-12">	
							<div class="actividadcuadrocompleto">
								<div class="actividadresultadosuperior"></div>
								<div class="row actividadresultado">
									<div class="actividadresumen">RESÚMEN DE RESULTADOS OBTENIDOS:</div>									
									<?php 
										$tinc=$_SESSION['nummaxev']-$_SESSION['totalcorrectas'];
										echo "<div class='resumenpadre'><div class='actividadresumencuadrototal'>Respuestas correctas:<span class='actividadrespuestatotalresumen'>".$_SESSION['totalcorrectas']."/".$_SESSION['nummaxev']."</span></div>";
										echo "<div class='actividadresumencuadrototal'>Respuestas incorrectas:<span class='actividadrespuestatotalresumen'>".$tinc."/".$_SESSION['nummaxev']."</span></div>";
										echo "<div class='actividadresumencuadrototal'>Total de puntos obtenidos:<span class='actividadrespuestatotalresumen'>".$_SESSION['valortotal']."/".$_SESSION['maxvalor']."</span></div></div>";
										$preguntas='';
										for ($i = 0; $i < $_SESSION['nummaxev']; $i++) {  
											$cualev=$_SESSION['evseleccionados'][$i];
											$sqlev = "SELECT * FROM ovaseleccion WHERE id=$cualev";
											$resultadoev = $mysqli->query($sqlev);
											$rowev = $resultadoev->fetch_array(MYSQLI_ASSOC);
											$j=$i+1;											
											echo "<div class='actividadresumenfila'><div class='actividadencabzadofilaresumen'><span id='cuadronumeroresumen".$j."' class='cuadradoalrededor cuadronumresumen'>".$j."</span>";
											echo "<div class='actividadenunciadoresumen'>".$rowev['enunciado']."</div></div>";
											$trp="turespuesta".$j;
											$trp=$_SESSION[$trp];
											echo "<div>Tu respuesta:<span class='actividadrespuestaresumen'>".$rowev[$trp]."</span></div>";
											$pregunta="pregunta".$j;
											echo "<div>Revisión:<span class='actividadrespuestaresumen'>";
											$coc="opcion".$rowev['opcioncorrecta'];
											if($_SESSION[$pregunta]){
												echo "Correcta</span></div></div>";
												echo "<script>document.getElementById('cuadronumeroresumen".$j."').style.backgroundColor='lightgreen';</script>";
												}else{												
												echo "<script>document.getElementById('cuadronumeroresumen".$j."').style.backgroundColor='red';</script>";
												echo "Incorrecta</span></div><div>Respuesta correcta:<span class='actividadrespuestaresumen'>".$rowev[$coc]."</span></div></div>";
											}
											if($_SESSION[$pregunta]){
												$correccion=1;
											}
											else{
												$correccion=0;
											}
											$preguntas=$preguntas.$j."*///*".$rowev['enunciado']."*///*".$rowev[$coc]."*///*".$rowev[$trp]."*///*".$correccion."*///*".$valor[$i];
											if($i<$_SESSION['nummaxev']-1){
												$preguntas=$preguntas."*+++*";
											}
										}?>
									</div>
								</div>
							</div>
						<?php 
							$usuariop=$_SESSION["id_usuario"];
							$acp=$_SESSION['tituloareactitulo'];
							$ttp=$_SESSION['titulotematitulo'];
							$sqlp = "SELECT id_usuario,repeticiones FROM ovapuntaje WHERE id_usuario = '$usuariop' AND areac = '$acp' AND tema = '$ttp'";
							$resultadop = $mysqli->query($sqlp);
							$rowp = $resultadop->fetch_array(MYSQLI_ASSOC);
							$numfilasp=$resultadop->num_rows;
							if($numfilasp>0){
								actualizaPuntaje($usuariop, $ttp, $acp, $preguntas, $_SESSION['nummaxev'],$rowp['repeticiones']);
							}
							else{
								registraPuntaje($usuariop, $ttp, $acp, $preguntas, $_SESSION['nummaxev'],1);
							}
						} ?>
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
				<p ALIGN="justify"><b> Evaluación</b></p><br/>

						      <p ALIGN="justify">Para responder la evaluación solo debe seleccionar la respuesta correcta de la pregunta o enunciado presentado.</p>
						      <p ALIGN="justify">Luego de seleccionar la respuesta correcta en cada pregunta, aparecerá un botón <b>"Revisar"</b>, el cual, al darle clic verificará si son correcta las respuestas del cuestionario.</p>
                                                      <p ALIGN="justify">Al terminar la evaluación mostrará un <b>Resumen</b>, el cual, se observa el resultado y en caso de tener incorrecta le indica cual debió ser las correctas, además el puntaje obtenido. </p><br/>
						      <p ALIGN="justify">En caso de no realizar ningún registro, se puede regresar al contenido y salir del área. </p>
						      <p ALIGN="justify">Dándole clic en "<b><FONT SIZE=5> < </font></b>" al lado de la palabra <b>Tema</b>, del lado izquierdo del área central. </p><br/>
                                                      
			</div>
		</div>
	</div>
</div>	
<script language='javascript'>
	$(document).ready(function(){
		var maxnumeva=<?php echo $_SESSION['nummaxev'];?>;
		var crespondida=[];
		nrespondidas=0;		
		for (k = 0; k < maxnumeva; k++) {
			crespondida[k]=0;
		}
		for (j = 1; j <= maxnumeva; j++) {	
			for (i = 1; i <= 4; i++) {
				var elemento = document.getElementById("opcion"+j+"-"+i);
				if(elemento!==null){
					$(elemento).change(function () {
						str=this.id;
						var res = str.split("opcion");
						var res = res[1].split("-");
						cres=parseInt(res[0]);
						if(crespondida[cres-1]==0){
							nrespondidas++;
							crespondida[cres-1]=1;
						}		
						if(nrespondidas==maxnumeva){
							document.getElementById("btncorregir").disabled=false;	
							document.getElementById("btncorregir").style.display="inherit";
						}
					});
				}
			}
	}
	});

	$('.enunciadoevaluacion').on('mouseover', function() {
		nmb=this.id;
		nmb = nmb.replace("etiqueta", "opcion");
		opc=document.getElementById(nmb);
		if(!opc.checked){
	    	$(this).css("border-color", "#333333");
	    	$(this).css("color", "#333333");
    	}
  	});
  	$('.enunciadoevaluacion').on('mouseout', function() {
  		nmb=this.id;
		nmb = nmb.replace("etiqueta", "opcion");
		opc=document.getElementById(nmb);
		if(!opc.checked){
	    	$(this).css("border-color", "#e0e0e0");
	    	$(this).css("color", "#808080");
	    }
  	});
	
	/*function clickcorregir() {
		var vopccorrecta=<?php echo $rowev['opcioncorrecta'];?>;
		document.getElementById("btncorregir").disabled=true;
		document.getElementById("btncorregir").style.display="none";
		document.getElementById("instrucciones").style.visibility="hidden";
		for (i = 1; i <= 4; i++) {
			var opc=document.getElementById("opcion"+i);
			var etq=document.getElementById("etiqueta"+i);
			opc.disabled = true;
			opc.style.cursor="default";
			etq.disabled = true;
			etq.style.cursor="default";
			if(opc.checked){
				resultado=opc.value;
				opccorr="opcion"+vopccorrecta;
			}
		}
	}*/
	
	function clickradio(){
		var maxnumeva=<?php echo $_SESSION['nummaxev'];?>;
		for (jc = 1; jc <= maxnumeva; jc++) {
			for (i = 1; i <= 4; i++) {				
				var opc=document.getElementById("opcion"+jc+"-"+i);
				if(opc!==null){
					var etq=document.getElementById("etiqueta"+jc+"-"+i);
					etq.style.borderColor="#e0e0e0";
					etq.style.color="#808080";
					
					if(opc.checked){
						var colorprincipal="<?php echo $colorprincipal;?>";
						etq.style.borderColor=colorprincipal;
						etq.style.color=colorprincipal;
					}
				}
			}
		}
	}
</script>
</body>
</html>																																																																														