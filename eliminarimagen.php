<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';	
	$id = $_GET['id'];
	$id_tema = $_GET['tm'];
	$sql = "DELETE FROM ovaimagenes WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	if($resultado) { 
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Imagen eliminada exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al eliminar la imagen';
	}	
	$vloc="Location: administrarimagenes.php?id=".$id_tema;
	header($vloc);
	
?>