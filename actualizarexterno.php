<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$id = $_POST['id'];
	$tituloexterno = $_POST['tituloexterno'];	
	$contenidoexterno = $_POST['contenidoexterno'];	
	$sql = "UPDATE ovatemas SET tituloexterno='$tituloexterno',contenidoexterno='$contenidoexterno' WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	if($resultado) { 
		//$_SESSION['cualareac']=$id_areac;
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Contenido externo modificado exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al modificar el contenido externo';
	}	
	$vloc="Location: administrarenlaces.php?id=".$id;
	header($vloc);	
?>