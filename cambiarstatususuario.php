<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]!=1){ //Si no ha iniciado sesión o no es un administrador redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	$id = $_GET['id'];
	$sql = "SELECT status,nick,id FROM ovausuarios WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
	if($row['nick']!='admin' && $row['id']!=$_SESSION["id_usuario"]){
		if($row['status']==0){
			$nuevostatus=1;
		}
		else{
			$nuevostatus=0;
		}	
		$sql = "UPDATE ovausuarios SET status='$nuevostatus' WHERE id = '$id'";
		$resultado = $mysqli->query($sql);
	}
 	header("Location: administrarusuarios.php");
?>