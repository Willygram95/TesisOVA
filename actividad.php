<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	/*if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index.php");
	}*/
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';
	
	$resumenresultados=false;
	
	if(!empty($_POST))
	{
		$respuesta = $mysqli->real_escape_string($_POST['opcion']);
		$id = $mysqli->real_escape_string($_POST['id']);
		$idareac = $mysqli->real_escape_string($_POST['idareac']);
		$tareac = $mysqli->real_escape_string($_POST['tareac']);
		$ttema = $mysqli->real_escape_string($_POST['ttema']);
		$valor = $mysqli->real_escape_string($_POST['vl']);
		$rc = "opcion".$mysqli->real_escape_string($_POST['rc']);	
		
		
		$turespuesta="turespuesta".$_SESSION['conteoej'];
		$_SESSION[$turespuesta]=$respuesta;	
		
		$_SESSION['maxvalor']=$_SESSION['maxvalor']+$valor;	
		
		$pregunta="pregunta".$_SESSION['conteoej'];
		
		if($respuesta==$rc){
			$_SESSION[$pregunta]=true;	
			$_SESSION['valortotal']=$_SESSION['valortotal']+$valor;	
			$_SESSION['totalcorrectas']=$_SESSION['totalcorrectas']+1;	
			
		}
		else{
			$_SESSION[$pregunta]=false;		
		}
		
		$_SESSION['conteoej']=$_SESSION['conteoej']+1;
		
		if($_SESSION['conteoej']>$_SESSION['nummaxej']){
			$resumenresultados=true;
		}
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
	
	
	
	//$tipoej=$_SESSION['tipoej'];
	$numerogpej=$_SESSION['numerogpej'];
	$conteoej=$_SESSION['conteoej'];
	
	$cualej=$_SESSION['ejseleccionados'][$conteoej-1];
	
	$sqlej = "SELECT * FROM ovaseleccion WHERE id_tema='$id' AND status=1 AND numerogrupo='$numerogpej' AND id='$cualej'";
	$resultadoej = $mysqli->query($sqlej);
	$rowej = $resultadoej->fetch_array(MYSQLI_ASSOC);
	$numfilasej=$resultadoej->num_rows;
	$tipoej=$rowej['tipo'];
	
	
?>
<!DOCTYPE html>
<html lang="es">
    <head>		
		<meta http-equiv="Content-Type" content="text/html"; charset=utf-8"/> 
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
						<span>Actividades</span>
					</div>
				</div>
					<?php if(!$resumenresultados){ ?>
						<form id="ejercicioform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">			
							<div class="col-md-12">	
								<div class="actividadcuadrocompleto">
									<div class="actividadcuadrosuperior"></div>
									<div class="row actividadcuadro">
										<div class="actividadinstrucciones" id="instrucciones">Lea detenidamente el enunciado presentado y seleccione la respuesta correcta de entre las distintas opciones que se le proponen:</div>
										<!-- Enunciado -->
										<div class="actividadenunciado"><?php echo $rowej['enunciado'];?></div>
										<?php if($tipoej==1){ ?>									
											<!-- Opciones -->
											<?php if(!$resumenresultados){?>
												<div class="actividadopciones">
													<?php for ($i = 1; $i <= $rowej['numopciones']; $i++) {  ?>
														<div class="actividadopcion">
															<input type="radio" name="opcion" id="opcion<?php echo $i;?>" value="opcion<?php echo $i;?>"/>
															<label onclick="clickradio()" class="etiquetaradio" id="etiqueta<?php echo $i;?>" for="opcion<?php echo $i;?>"><div id="btnradio1" class="btnradio"></div><?php $nbop='opcion'.$i; echo $rowej[$nbop];?></label>
														</div>
													<?php } ?>
												</div>																		
											<?php } ?>
											<? }else{ ?>
											<!-- Opciones -->
											<?php if(!$resumenresultados){?>
												<div class="actividadopciones">
													<div class="actividadopcion"><input type="radio" name="opcion" id="opcion1" value="opcion1"/>
													<label onclick="clickradio()" class="etiquetaradio" id="etiqueta1" for="opcion1"><div id="btnradio1" class="btnradio"></div><?php echo $rowej['opcion1'];?></label></div>
													<div class="actividadopcion"><input type="radio" name="opcion" id="opcion2" value="opcion2"/>
													<label onclick="clickradio()" class="etiquetaradio" id="etiqueta2" for="opcion2"><div id="btnradio2" class="btnradio"></div><?php echo $rowej['opcion2'];?></label></div>
												</div>																		
											<?php } ?>
										<? } ?>
										<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
										<input type="hidden" id="idareac" name="idareac" value="<?php echo $idareac; ?>" />
										<input type="hidden" id="tareac" name="tareac" value="<?php echo $tareac; ?>" />
										<input type="hidden" id="ttema" name="ttema" value="<?php echo $ttema; ?>" />
										<input type="hidden" id="rc" name="rc" value="<?php echo $rowej['opcioncorrecta']; ?>" />
										<input type="hidden" id="vl" name="vl" value="<?php echo $rowej['valor']; ?>" />
										<div class="contenedor"><input style="display:none" type="text" class="actividadmsjresultado" id="correccion" readonly></div>
									</div>	
									<div class="row actividadpiecuadro">
										<button style="display:none" onclick="clickcorregir()" id="btncorregir" class="btngeneral btncorregir" disabled>REVISAR</button> 
										<div class="actividadconteo"><span class="actividadcontador"><?php echo $conteoej?></span> de <?php echo $_SESSION['nummaxej']?></div>
										<button style="display:none" onclick="clicksiguiente()" id="btnsiguiente" class="btngeneral btnsiguiente <? if($conteoej>=$_SESSION['nummaxej']){echo "btnresumen";}?>" type="submit" class="btn btn-info" disabled><? if($conteoej<$_SESSION['nummaxej']){echo "SIGUIENTE";}else{echo "VER RESÚMEN";}?></button> 
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
										$tinc=$_SESSION['nummaxej']-$_SESSION['totalcorrectas'];
										echo "<div class='resumenpadre'><div class='actividadresumencuadrototal'>Respuestas correctas:<span class='actividadrespuestatotalresumen'>".$_SESSION['totalcorrectas']."/".$_SESSION['nummaxej']."</span></div>";
										echo "<div class='actividadresumencuadrototal'>Respuestas incorrectas:<span class='actividadrespuestatotalresumen'>".$tinc."/".$_SESSION['nummaxej']."</span></div>";
										echo "</div>";
										for ($i = 1; $i <= $_SESSION['nummaxej']; $i++) {  
											$cualej=$_SESSION['ejseleccionados'][$i-1];
											$sqlej = "SELECT * FROM ovaseleccion WHERE id=$cualej";
											$resultadoej = $mysqli->query($sqlej);
											$rowej = $resultadoej->fetch_array(MYSQLI_ASSOC);
											echo "<div class='actividadresumenfila'><div class='actividadencabzadofilaresumen'><span id='cuadronumeroresumen".$i."' class='cuadradoalrededor cuadronumresumen'>".$i."</span>";
											echo "<div class='actividadenunciadoresumen'>".$rowej['enunciado']."</div></div>";
											$trp="turespuesta".$i;
											$trp=$_SESSION[$trp];
											echo "<div>Tu respuesta:<span class='actividadrespuestaresumen'>".$rowej[$trp]."</span></div>";
											$pregunta="pregunta".$i;
											echo "<div>Revisión:<span class='actividadrespuestaresumen'>";
										
											if($_SESSION[$pregunta]){
												echo "Correcta</span></div></div>";
												echo "<script>document.getElementById('cuadronumeroresumen".$i."').style.backgroundColor='lightgreen';</script>";
												}else{
												$coc="opcion".$rowej['opcioncorrecta'];
												echo "<script>document.getElementById('cuadronumeroresumen".$i."').style.backgroundColor='red';</script>";
												echo "Incorrecta</span></div><div>Respuesta correcta:<span class='actividadrespuestaresumen'>".$rowej[$coc]."</span></div></div>";
											}
										}?>
									</div>
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
				<p ALIGN="justify"><b> Actividades</b></p><br/>

						      <p ALIGN="justify">Para responder las actividades solo debe seleccionar la respuesta correcta de la pregunta o enunciado presentado.</p>
						      <p ALIGN="justify">Luego de seleccionar la respuesta correcta, aparecerá un botón <b>"Revisar"</b>, el cual, al darle clic verificará si es correcta la respuesta.</p><br/>
						      <p ALIGN="justify">En caso de no realizar la actividad, se puede regresar al contenido y salir de la actividad. </p>
						      <p ALIGN="justify">Dándole clic en "<b><FONT SIZE=5> < </font></b>" al lado de la palabra actividades. </p><br/>
                                                      <p ALIGN="justify">Al terminar la actividad aparecerá el botón "<b>Ver Resumen</b>", el cual muestra el resultado y en caso de tener incorrecta le indica cual debió ser las correctas. </p>
			</div>
		</div>
	</div>
</div>	
<script language='javascript'>
	$(document).ready(function(){
		for (i = 1; i <= 4; i++) {
			$("#opcion"+i).change(function () {
				document.getElementById("btncorregir").disabled=false;	
				document.getElementById("btncorregir").style.display="inherit";
			});
		}
	});
	
	function clickcorregir() {
		var vopccorrecta=<?php echo $rowej['opcioncorrecta'];?>;
		document.getElementById("btnsiguiente").disabled=false;
		document.getElementById("btncorregir").disabled=true;
		document.getElementById("btnsiguiente").style.display="inherit";
		document.getElementById("correccion").style.display="inherit";
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
				if(resultado==opccorr){					
					document.getElementById("correccion").style.backgroundColor="lightgreen";
					document.getElementById("correccion").value="¡Correcto!";
				}
				else{
					document.getElementById("correccion").style.backgroundColor="red";
					document.getElementById("correccion").value="¡Incorrecto!";
				}
			}
		}
	}
	
	function clicksiguiente() {	
		for (i = 1; i <= 4; i++) {
			document.getElementById("opcion"+i).disabled = false;									
		}
	}	
	
	function clickradio(){
		/*for (i = 1; i <= 4; i++) {
			var opc=document.getElementById("opcion"+i);
			var etq=document.getElementById("etiqueta"+i);
			document.getElementById("btnradio"+i).style.backgroundColor="transparent";
			document.getElementById("btnradio"+i).style.borderColor="#AAAAAA";
			document.getElementById("etiqueta"+i).style.color="lightgray";
			if(opc.checked){
				document.getElementById("btnradio"+i).style.backgroundColor="lightblue";
				document.getElementById("btnradio"+i).style.borderColor="lightblue";
				document.getElementById("etiqueta"+i).style.color="lightblue";
			}
		}*/
	}
</script>
</body>
</html>																																																																														