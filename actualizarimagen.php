<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$id = $_POST['id'];
	$id_tema=$_POST['id_tema'];
	$nombre = $mysqli->real_escape_string($_POST['nombre']);
	if (is_uploaded_file($_FILES["userfile"]["tmp_name"]))
	{
		if ($_FILES["userfile"]["type"]=="image/jpeg" || $_FILES["userfile"]["type"]=="image/pjpeg" || $_FILES["userfile"]["type"]=="image/gif" || $_FILES["userfile"]["type"]=="image/bmp" || $_FILES["userfile"]["type"]=="image/png")
		{
			$info=getimagesize($_FILES["userfile"]["tmp_name"]);
			$imagenEscapes=$mysqli->real_escape_string(file_get_contents($_FILES["userfile"]["tmp_name"]));
			$ancho=$info[0];
			$alto=$info[1];
			$tipo=$_FILES["userfile"]["type"];
			$imagen=$imagenEscapes;
			$tamano=$_FILES["userfile"]["size"];
			$nombreoriginal=$_FILES["userfile"]["name"];
			
			$sql = "SELECT nombre FROM ovaimagenes WHERE id = '$id'";
			$resultado = $mysqli->query($sql);
			$row = $resultado->fetch_array(MYSQLI_ASSOC);
			
			
			$sql = "UPDATE ovaimagenes SET nombre='$nombre', ancho='$ancho', alto='$alto', tipo='$tipo', imagen='$imagen', tamano='$tamano', nombreoriginal='$nombreoriginal' WHERE id = '$id'";
			$resultado = $mysqli->query($sql);
			if($resultado) 
			{ 
				//$_SESSION['cualareac']=$id_areac;
				$_SESSION['tipomensajedevuelto']='exito';
				$_SESSION['mensajedevuelto']='Imagen modificada exitosamente';
				
				}else{
				$_SESSION['tipomensajedevuelto']='error';
				$_SESSION['mensajedevuelto']='Error al modificar la imagen';
				if(nombreimgExiste($nombre) && $nombre!=$row['nombre'])
				{
					$_SESSION['mensajedevuelto'] = $_SESSION['mensajedevuelto']." El nombre $nombre ya está asociado a otra imagen";
				}
				
			}	
			
			}else{
			$_SESSION['tipomensajedevuelto']='error';
			$_SESSION['mensajedevuelto']='El formato de archivo tiene que ser JPG, GIF, BMP o PNG';
			$errores[] = "El formato de archivo tiene que ser JPG, GIF, BMP o PNG";
		}
	}
	else{
		$sql = "SELECT nombre FROM ovaimagenes WHERE id = '$id'";
		$resultado = $mysqli->query($sql);
		$row = $resultado->fetch_array(MYSQLI_ASSOC);
		
		
		$sql = "UPDATE ovaimagenes SET nombre='$nombre' WHERE id = '$id'";
		$resultado = $mysqli->query($sql);
		if($resultado) 
		{ 
			//$_SESSION['cualareac']=$id_areac;
			$_SESSION['tipomensajedevuelto']='exito';
			$_SESSION['mensajedevuelto']='Imagen modificada exitosamente';
			
			}else{
			$_SESSION['tipomensajedevuelto']='error';
			$_SESSION['mensajedevuelto']='Error al modificar la imagen';
			if(nombreimgExiste($nombre) && $nombre!=$row['nombre'])
			{
				$_SESSION['mensajedevuelto'] = $_SESSION['mensajedevuelto']." El nombre $nombre ya está asociado a otra imagen";
			}
			
		}	
	}	
	$vloc="Location: administrarimagenes.php?id=".$id_tema;
	header($vloc);
	
?>