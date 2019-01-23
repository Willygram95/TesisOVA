<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$id = $_POST['id'];
	$titulo = $_POST['titulo'];
	$introduccion = $_POST['introduccion'];
	$prerequisitos = $_POST['prerequisitos'];
	$status = $_POST['status'];	
	$id_areac = $_POST['id_areac'];	
	
	$sqlac = "SELECT id_areac,orden FROM ovatemas WHERE id = '$id'";
	$resultadoac = $mysqli->query($sqlac);	
	$rowac = $resultadoac->fetch_array(MYSQLI_ASSOC);
	
	$sql = "UPDATE ovatemas SET titulo='$titulo', introduccion='$introduccion', prerequisitos='$prerequisitos', status='$status', id_areac='$id_areac' WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	if($resultado) { 
		
		if($id_areac!=$rowac['id_areac']){
			$sql = "UPDATE ovatemas SET orden=orden-1 WHERE id_areac=".$rowac['id_areac']." AND orden > ".$rowac['orden'];
			$resultado = $mysqli->query($sql);
			
			$sql = "SELECT id FROM ovatemas WHERE id_areac='$id_areac'";
			$resultado = $mysqli->query($sql);
			$orden=$resultado->num_rows;
			
			$sql = "UPDATE ovatemas SET orden='$orden' WHERE id = '$id'";
			$resultado = $mysqli->query($sql);
			
		}
		
		
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Tema modificado exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al modificar el tema';
	}	
	$_SESSION['cualareac']=$id_areac;
	header("Location: administrartemas.php");	
?>