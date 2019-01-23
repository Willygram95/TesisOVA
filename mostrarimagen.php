<?php
	
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	/*if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o es un estudiante redirecciona a index.php
		header("Location: index.php");
	}*/
	require 'funciones/conexion.php';
	require 'funciones/funciones.php';	
	
	# Buscamos la imagen a mostrar
	$result=$mysqli->query("SELECT * FROM ovaimagenes WHERE id=".$_GET["id"]);
	$row=$result->fetch_array(MYSQLI_ASSOC);
	
	# Mostramos la imagen
	header("Content-type:".$row["tipo"]);
	echo $row["imagen"];
?>