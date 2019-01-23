<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';	
	include 'funciones/funciones.php';

	$id = $_GET['id'];
	$orden=$_GET['orden'];
	$id_areac=$_GET['ac'];
	$sql = "DELETE FROM ovatemas WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	
	if($resultado) { 
		$sql = "UPDATE ovatemas SET orden=orden-1 WHERE id_areac=".$id_areac." AND orden > ".$orden;
		$resultado = $mysqli->query($sql);
		eliminardetemas($id);

		$_SESSION['cualareac']=$id_areac;
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Tema eliminado exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al eliminar el tema';
	}	
	header("Location: administrartemas.php");
	
?>