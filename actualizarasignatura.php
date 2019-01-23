<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]!=1){ //Si no ha iniciado sesión o no es un administrador redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$id = $_POST['id'];
	$codigo = $_POST['codigo'];
	$nombre = $_POST['nombre'];	
	$prerequisitos = $_POST['prerequisitos'];
	$programa = $_POST['programa'];	
	$sql = "UPDATE ovaasignatura SET codigo='$codigo', nombre='$nombre', prerequisitos='$prerequisitos', programa='$programa' WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	if($resultado) { 
		$_SESSION["id_asignatura"]=$nombre;
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Ásignatura modificada exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al modificar la asignatura';
	}	
	header("Location: administrarasignatura.php");	
?>