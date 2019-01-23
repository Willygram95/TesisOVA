<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$id = $_POST['id'];
	$titulo = $_POST['titulo'];
	$autor = $_POST['autor'];	
	$info = $_POST['info'];	
	$sql = "UPDATE ovabibliografia SET titulo='$titulo', autor='$autor', info='$info' WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	if($resultado) { 
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Libro modificado exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al modificar el libro';
	}	
	header("Location: administrarbibliografia.php");	
?>