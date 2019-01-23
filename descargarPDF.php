<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	/*if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}*/
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	
	$id_tema = $_GET['id'];
	
	$sql = "SELECT * FROM ovaarchivos WHERE id_tema = '$id_tema'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
	
	$sqltm = "SELECT titulo FROM ovatemas WHERE id = '$id_tema'";
	$resultadotm = $mysqli->query($sqltm);
	$rowtm = $resultadotm->fetch_array(MYSQLI_ASSOC);
	
	$nombre = $rowtm['titulo'].".pdf";
	$tipo = "application/pdf";//$row['tipo'];
	$archivo = $row['archivo'];
	$tamano = $row['tamano'];	
	
	header("Content-Description: File Transfer");
    header("Content-transfer-encoding: binary");
    header("Content-Disposition: attachment; filename = $nombre"); 
    header("Content-type: $tipo");
    header("Content-Length: $tamano");

    print $archivo;
    exit();
?>