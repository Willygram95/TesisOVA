<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]!=1){ //Si no ha iniciado sesión o no es un administrador redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$id = $_POST['id'];
	$colorprincipal = $_POST['colorprincipal'];
	$colorsecundario = $_POST['colorsecundario'];		
	$sql = "UPDATE ovadiseno SET colorprincipal='$colorprincipal', colorsecundario='$colorsecundario' WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	if($resultado) { 
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Diseño modificado exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al modificar el diseño';
	}	
	header("Location: administrardiseno.php");	
?>