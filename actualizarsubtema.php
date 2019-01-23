<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$id = $_POST['id'];
	$id_tema=$_POST['id_tema'];
	$titulo = $_POST['titulo'];
	$contenido = $_POST['contenido'];
	$status = $_POST['status'];	
	$sql = "UPDATE ovatemascontenidos SET titulo='$titulo', contenido='$contenido', status='$status' WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	if($resultado) { 
		//$_SESSION['cualareac']=$id_areac;
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Subtema modificado exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al modificar el subtema';
	}	
	$vloc="Location: temaregistrado.php?id=".$id_tema;
	header($vloc);
?>