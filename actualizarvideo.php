<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$id = $_POST['id'];
	$titulovideo = $_POST['titulovideo'];	
	$enlacevideo = $_POST['enlacevideo'];	
	$sql = "UPDATE ovatemas SET titulovideo='$titulovideo',enlacevideo='$enlacevideo' WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	if($resultado) { 
		//$_SESSION['cualareac']=$id_areac;
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Video modificado exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al modificar el video';
	}	
	$vloc="Location: administrarenlaces.php?id=".$id;
	header($vloc);	
?>