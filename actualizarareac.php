<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$id = $_POST['id'];
	$titulo = $_POST['titulo'];
	$status = $_POST['status'];	
	
	$sql = "SELECT titulo FROM ovaareasc WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
	
	$sql = "UPDATE ovaareasc SET titulo='$titulo', status='$status' WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	if($resultado) { 
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Área de conocimiento modificado exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al modificar el área de conocimiento';
		if(areacExiste($titulo) && $titulo!=$row['titulo'])
		{
			$_SESSION['mensajedevuelto'] = $_SESSION['mensajedevuelto']." El nombre $titulo ya existe para otra área de conocimiento";
		}
	}	
	header("Location: administrarareasc.php");	
?>