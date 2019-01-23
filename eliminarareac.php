<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';	
	include 'funciones/funciones.php';

	$id = $_GET['id'];
	$orden=$_GET['orden'];
	$sql = "DELETE FROM ovaareasc WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	
	if($resultado) { 		
		$sql = "SELECT id FROM ovatemas WHERE id_areac = '$id'";
		$result = $mysqli->query($sql);
		while ($row = $result->fetch_array(MYSQLI_ASSOC)){
			$idtm=$row['id'];
			$sqltm = "DELETE FROM ovatemas WHERE id = '$idtm'";
			$resultado = $mysqli->query($sqltm);
			eliminardetemas($idtm);
		}		
		$sql = "UPDATE ovaareasc SET orden=orden-1 WHERE orden > ".$orden;
		$resultado = $mysqli->query($sql);


		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Área de conocimiento eliminado exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al eliminar el área de conocimiento';
	}	
	header("Location: administrarareasc.php");
	
?>