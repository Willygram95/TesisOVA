<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	/*if(!isset($_SESSION["id_usuario"])){ //Si no ha iniciado sesión redirecciona a index.php
		header("Location: index.php");
	}*/
	require 'funciones/conexion.php';
	require 'funciones/funciones.php';	
	
	# Buscamos la imagen a mostrar
	$result=$mysqli->query("SELECT * FROM ovaimagenes WHERE nombre=".$_GET["nombre"]);
	$row=$result->fetch_array(MYSQLI_ASSOC);
	
	# Mostramos la imagen
	header("Content-type:".$row["tipo"]);
	echo $row["imagen"];
?>