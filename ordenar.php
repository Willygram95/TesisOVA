<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	require 'funciones/funciones.php';
	
	$aordenar= $_GET['qo'];
	$cualtema= $_GET['ct'];
	$tituloqo= $_GET['to'];
	switch($aordenar){
		case 'ac':{ 
			$cualtabla="ovaareasc";
			$donderegresar="administrarareasc.php";
			$queordenar="Áreas de Conocimiento"; 
			$where="";
			$qord="";
		}
		break;
		case 'tm':{ 
			$cualtabla="ovatemas";
			$donderegresar="administrartemas.php";
			$queordenar="Temas";
			$cac=$_SESSION['cualareac'];
			$where="WHERE id_areac='$cac'";
			$qord="Área de conocimiento: ";
		}
		break;
		case 'st':{ 
			$cualtabla="ovatemascontenidos";
			$donderegresar="temaregistrado.php?id=".$cualtema;
			$queordenar="Subtemas";
			$where="WHERE id_tema='$cualtema'";
			$qord="Tema: ";
		}
		break;
		case 'at':{ 
			$cualtabla="ovaseleccion";
			$donderegresar="administraractividades.php?id=".$cualtema;
			$queordenar="Actividades";
			$where="WHERE id_tema='$cualtema' AND categoria=1";
			$qord="Actividad del tema: ";
		}
		break;
		case 'ev':{ 
			$cualtabla="ovaseleccion";
			$donderegresar="administrarevaluaciones.php?id=".$cualtema;
			$queordenar="Evaluaciones";
			$where="WHERE id_tema='$cualtema' AND categoria=2";
			$qord="Evaluación del tema: ";
		}
		break;
	}
	
	if($aordenar!='at' && $aordenar!='ev'){
		$consulta = "SELECT id,titulo,orden,status FROM $cualtabla $where ORDER BY orden";
		$resultado = mysqli_query($mysqli, $consulta);
		$elementos = null;
		while ($datos = mysqli_fetch_assoc($resultado)){
			$elementos[$datos['id']] = $datos['titulo'];
			$stelementos[$datos['id']] = $datos['status'];
		}
	}
	else{
		$consulta = "SELECT id,enunciado,orden,status,valor,tipo FROM $cualtabla $where ORDER BY orden";
		$resultado = mysqli_query($mysqli, $consulta);
		$elementos = null;
		while ($datos = mysqli_fetch_assoc($resultado)){
			$elementos[$datos['id']] = $datos['enunciado'];
			$stelementos[$datos['id']] = $datos['status'];
			$vlelementos[$datos['id']] = $datos['valor'];
			$tipoej = $datos['tipo'];
			$sqlte = "SELECT * FROM ovatiposactividades WHERE id=$tipoej";
			$resultadote = $mysqli->query($sqlte);
			$rowte = $resultadote->fetch_array(MYSQLI_ASSOC);
			$tlelementos[$datos['id']] =  $rowte['tipo'];
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<title><?php echo $_SESSION["id_asignatura"];?>: Administración de <?php echo $queordenar; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="static/css/bootstrap.min.css" rel="stylesheet">
		<link href="static/css/bootstrap-theme.css" rel="stylesheet">
		<link rel="stylesheet" href="css/orden.css">
		<link rel="stylesheet" href="css/ovamiestilo.css">	
		<link rel="stylesheet" href="css/ovaactmiestilo.css">		
		<script src="static/js/jquery-3.2.0.min.js"></script>
		<script src="static/js/bootstrap.min.js"></script>	
	</head>
	
	<body class="bodyadmin">
	<div class="container-fluid">
			<?php echo MenuPrincipal("contenido"); ?>	
			<div class="row">
				<div class="imgslidertmcn">					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 secciontitulos secciontitulosadmin">
						<div class="container tituloadmin">Administración de <?php echo $queordenar; ?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row areasuperioradmin">
				<div class="container">
					<div class="row titulodetemaadmin">
						<a href=<?php echo $donderegresar; ?> data-toggle="tooltip" title="Regresar"><span class="glyphicon glyphicon-chevron-left"></span></a>
						<?php $row = $resultado->fetch_array(MYSQLI_ASSOC) ?>							
						<?php echo $qord;?> <span><?php echo $tituloqo;?></span>
					</div>
				</div>
				<div class="row actividadresumen revtresumen">
					Clic sostenido y arrastrar para ordenar los elementos
				</div>
					<ul id="lista">
						<?php 
							foreach ($elementos as $id => $nombre){
								$p1='<li ';
								$p2='';
								$p3='id="elemento-'.$id.'" contenteditable="false">'.$nombre;
								$p4='';
								$p5='<br/></li>';
								
								if($stelementos[$id]==0){
									$p2='style="background-color:lightgray;" ';
								}
								if($aordenar=='ev'){
									$p4=' <span>'.$tlelementos[$id].' | '.$vlelementos[$id].' puntos</span>';
								}
								echo $p1.$p2.$p3.$p4.$p5;								
							}
						?>
					</ul>
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
						<p ALIGN="justify">Esta área se encarga de <b>Ordenar </b>, permite organizar las actividades por un orden determinado OVA.</p>
						     

						      
						      <p ALIGN="justify">En caso de no realizar ningún registro, se puede regresar al contenido y salir del área. </p>
						      <p ALIGN="justify">Dándole clic en "<b><FONT SIZE=5> < </font></b>" al lado de la palabra <b>Tema</b>, del lado izquierdo del área central. </p><br/>
					</div>
				</div>
			</div>
		</div>	
	</body>
</html>	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script>
	$(function(){
		var ordenando = true, lista = $('#lista'),
		elementos = lista.find('li');
		lista.sortable({
			update: function(event,ui){
				var ordenPuntos = $(this).sortable('toArray').toString();
				$.ajax({
					type: 'POST',
					url: 'scriptorden.php',
					dataType: 'json',
					data: {
					puntos: ordenPuntos,
					qo: '<?php echo $aordenar;?>'
					}
				});
			}
		});
		lista.sortable('enable');
		elementos.attr('contenteditable',false);
	});
</script>								