<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]!=1){ //Si no ha iniciado sesión o no es un administrador redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';	
	$id = $_GET['id'];
	$sql = "SELECT nick,id FROM ovausuarios WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
	if($row['nick']!='admin' && $row['id']!=$_SESSION["id_usuario"]){
		$sql = "DELETE FROM ovausuarios WHERE id = '$id'";
		$resultado = $mysqli->query($sql);
		if($resultado) { 
			$sql = "DELETE FROM ovapuntaje WHERE id_usuario = '$id'";
			$resultado = $mysqli->query($sql);

			$_SESSION['tipomensajedevuelto']='exito';
			$_SESSION['mensajedevuelto']='Usuario eliminado exitosamente';
			
			}else{
			$_SESSION['tipomensajedevuelto']='error';
			$_SESSION['mensajedevuelto']='Error al eliminar el usuario';
		}
	}	
	header("Location: administrarusuarios.php");
	
?>