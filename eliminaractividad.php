<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';	
	$id = $_GET['id'];
	$id_tema = $_GET['tm'];
	
	$sql = "SELECT orden FROM ovaseleccion WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);		
	$orden=$row['orden'];
	
	$sql = "DELETE FROM ovaseleccion WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	if($resultado) { 
		$sql = "UPDATE ovaseleccion SET orden=orden-1 WHERE id_tema=".$id_tema." AND orden > ".$orden;
		$resultado = $mysqli->query($sql);
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Actividad eliminada exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al eliminar la actividad';
	}	
	$vloc="Location: administraractividades.php?id=".$id_tema;
	header($vloc);
	
?>