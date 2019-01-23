<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$id = $_POST['id'];	
	$tipo = $mysqli->real_escape_string($_POST['tipo']);		
	$enunciado = $_POST['enunciado'];
	$id_tema = $mysqli->real_escape_string($_POST['id_tema']);	
	
	
	
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
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto'] = "Debe ingresar toda la información solicitada";
	}
	else{
		
		$sql = "UPDATE ovaseleccion SET tipo='$tipo', enunciado='$enunciado', numopciones='$numopciones', opcion1='$opcion1', opcion2='$opcion2', opcion3='$opcion3', opcion4='$opcion4', opcioncorrecta='$opcioncorrecta', id_tema='$id_tema', numerogrupo='$numerogrupo' WHERE id = '$id'";
		$resultado = $mysqli->query($sql);
		if($resultado) { 
			//$_SESSION['cualareac']=$id_areac;
			$_SESSION['tipomensajedevuelto']='exito';
			$_SESSION['mensajedevuelto']='Actividad modificada exitosamente';
			
			}else{
			$_SESSION['tipomensajedevuelto']='error';
			$_SESSION['mensajedevuelto']='Error al modificar la actividad';
			
		}	
	}
	$vloc="Location: administraractividades.php?id=".$id_tema;
	header($vloc);
?>