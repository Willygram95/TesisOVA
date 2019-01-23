<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$id = $_POST['id'];
	$tituloaudio = $_POST['tituloaudio'];	
	$userfile=$_FILES["userfile"]["name"];

	if (is_uploaded_file($_FILES["userfile"]["tmp_name"]))
	{
		$tamano=$_FILES['userfile']['size'];
		$tipo=$_FILES['userfile']['type'];
		$archivocargado=true;	

		if ($tamano>16000000){
			$archivocargado=false;
			$_SESSION['tipomensajedevuelto']='error';
			$_SESSION['mensajedevuelto']='Error. El archivo es demasiado grande. Debe pesar máximo 16MB';
		}
		else{
			if ($tipo !="audio/mp3" AND $tipo !="audio/mpeg" AND $tipo !="audio/ogg" AND $tipo !="video/mpeg" AND $tipo !="video/ogg"){
				$archivocargado=false;
				$_SESSION['tipomensajedevuelto']='error';
				$_SESSION['mensajedevuelto']='Error. Sólo se permiten archivos MP3 u OGG';
			}
		}
		if($archivocargado){
			$nombre=$_FILES['userfile']['name'];
			$donde="audio/".$nombre;
			if(move_uploaded_file ($_FILES['userfile']['tmp_name'], $donde)){
				$sql = "UPDATE ovatemas SET tituloaudio='$tituloaudio',archivoaudio='$nombre' WHERE id = '$id'";
				$resultado = $mysqli->query($sql);
				if($resultado) { 
					//$_SESSION['cualareac']=$id_areac;
					$_SESSION['tipomensajedevuelto']='exito';
					$_SESSION['mensajedevuelto']='Audio modificado exitosamente';
					
					}else{
					$_SESSION['tipomensajedevuelto']='error';
					$_SESSION['mensajedevuelto']='Error al modificar el audio';
				}	
			}else{
				$_SESSION['tipomensajedevuelto']='error';
				$_SESSION['mensajedevuelto']='Error al modificar el audio';
			}
		}	
	}
	else{
		if($id>0){
			$sql = "SELECT archivoaudio FROM ovatemas WHERE id = '$id'";
			$resultado = $mysqli->query($sql);
			$row = $resultado->fetch_array(MYSQLI_ASSOC);
			if($row['archivoaudio']!=''){			
				$sql = "UPDATE ovatemas SET tituloaudio='$tituloaudio' WHERE id = '$id'";
				$resultado = $mysqli->query($sql);
			}
			else{
				$resultado=false;	
			}
		}else{
				$resultado=false;			
		}
		if($resultado) 
		{ 
			//$_SESSION['cualareac']=$id_areac;
			$_SESSION['tipomensajedevuelto']='exito';
			$_SESSION['mensajedevuelto']='Título del audio modificado exitosamente';
			
		}else{
			$_SESSION['tipomensajedevuelto']='error';
			$_SESSION['mensajedevuelto']='Error al modificar el audio';
			
			if($id<=0){			
				$_SESSION['mensajedevuelto']=$_SESSION['mensajedevuelto'].' Debe seleccionar un archivo de audio';
			}			
		}	
	}
	$vloc="Location: administrarenlaces.php?id=".$id;
	header($vloc);	
?>