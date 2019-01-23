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
	$url = $_POST['url'];
	
	$sql = "SELECT url FROM ovaenlaces WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
	
	$sql = "UPDATE ovaenlaces SET titulo='$titulo', url='$url' WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	if($resultado) { 
		//$_SESSION['cualareac']=$id_areac;
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Enlace modificado exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al modificar el enlace';
		if(urlExiste($url) && $url!=$row['url'])
		{
			$_SESSION['mensajedevuelto'] = $_SESSION['mensajedevuelto']." La URL $url ya existe";
		}
	}	
	$vloc="Location: administrarenlaces.php?id=".$id_tema;
	header($vloc);
?>