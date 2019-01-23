<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$id = $_POST['id'];
	$termino = $_POST['termino'];
	$definicion = $_POST['definicion'];	
	
	$sql = "SELECT termino FROM ovaglosario WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
	
	$sql = "UPDATE ovaglosario SET termino='$termino', definicion='$definicion' WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	if($resultado) { 
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Término modificado exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al modificar el término';
		if(terminoExiste($termino) && $termino!=$row['termino'])
		{
			$_SESSION['mensajedevuelto'] = $_SESSION['mensajedevuelto']." El término $termino ya existe";
		}
	}	
	header("Location: administrarglosario.php");	
?>