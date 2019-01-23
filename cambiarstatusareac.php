<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	$id = $_GET['id'];
	$sql = "SELECT status FROM ovaareasc WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
	if($row['status']==0){
		$nuevostatus=1;
	}
	else{
		$nuevostatus=0;
	}	
	$sql = "UPDATE ovaareasc SET status='$nuevostatus' WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
 	header("Location: administrarareasc.php");
?>