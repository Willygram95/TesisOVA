<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';	
	$id = $_GET['id'];
	$ca=$_GET['a'];
	$sql = "UPDATE ovatemas SET tituloaudio='',archivoaudio='' WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	if($resultado) { 
		unlink($ca);
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Audio eliminado exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al eliminar el audio';
	}	
	$vloc="Location: administrarenlaces.php?id=".$id;
	header($vloc);
	
?>