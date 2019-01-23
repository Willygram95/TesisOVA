<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$id = $_POST['id'];
	$ayuda = $_POST['ayuda'];	
	$sql = "UPDATE ovatemas SET ayuda='$ayuda' WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	if($resultado) { 
		//$_SESSION['cualareac']=$id_areac;
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Ayuda modificada exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al modificar la ayuda';
	}	
	header("Location: administrartemas.php");	
?>