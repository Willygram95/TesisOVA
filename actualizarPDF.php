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
		if ($_FILES["userfile"]["type"]=="text/pdf" || $_FILES["userfile"]["type"]=="text/x-pdf" || $_FILES["userfile"]["type"]=="application/pdf" || $_FILES["userfile"]["type"]=="application/x-pdf" || $_FILES["userfile"]["type"]=="application/acrobat")
		{
			
			$archivo=$mysqli->real_escape_string(file_get_contents($_FILES["userfile"]["tmp_name"]));
			$tipo=$_FILES["userfile"]["type"];
			$tamano=$_FILES["userfile"]["size"];
			$nombreoriginal=$_FILES["userfile"]["name"];
			
			if($id>0){
				$sql = "SELECT nombre FROM ovaarchivos WHERE id = '$id'";
				$resultado = $mysqli->query($sql);
				$row = $resultado->fetch_array(MYSQLI_ASSOC);
				
				
				$sql = "UPDATE ovaarchivos SET nombre='$nombre', tipo='$tipo', archivo='$archivo', tamano='$tamano', nombreoriginal='$nombreoriginal' WHERE id = '$id'";
				$resultado = $mysqli->query($sql);
				}else{
				
				$sql="INSERT INTO ovaarchivos (nombre,tipo,archivo,tamano,nombreoriginal,id_tema) VALUES ('".$nombre."','".$tipo."','".$archivo."',".$tamano.",'".$nombreoriginal."',".$id_tema.")";
				$resultado = $mysqli->query($sql);
			}
			if($resultado) 
			{ 
				//$_SESSION['cualareac']=$id_areac;
				$_SESSION['tipomensajedevuelto']='exito';
				$_SESSION['mensajedevuelto']='PDF agregado exitosamente';
				
				}else{
				$_SESSION['tipomensajedevuelto']='error';
				$_SESSION['mensajedevuelto']='Error al agregar el PDF';
				if(nombrearchivoExiste($nombre) && $nombre!=$row['nombre'])
				{
					$_SESSION['mensajedevuelto'] = $_SESSION['mensajedevuelto']." El nombre $nombre ya está asociado a otro PDF";
				}
				
			}	
			
			}else{
			$_SESSION['tipomensajedevuelto']='error';
			$_SESSION['mensajedevuelto']='El formato de archivo tiene que ser PDF';
			$errores[] = "El formato de archivo tiene que ser PDF";
		}
	}
	else{
		
		if($id>0){
			$sql = "SELECT nombre FROM ovaarchivos WHERE id = '$id'";
			$resultado = $mysqli->query($sql);
			$row = $resultado->fetch_array(MYSQLI_ASSOC);
			
			
			$sql = "UPDATE ovaarchivos SET nombre='$nombre' WHERE id = '$id'";
			$resultado = $mysqli->query($sql);
			}else{
			$resultado=false;
		}
		
		
		if($resultado) 
		{ 
			//$_SESSION['cualareac']=$id_areac;
			$_SESSION['tipomensajedevuelto']='exito';
			$_SESSION['mensajedevuelto']='Nombre del PDF modificado exitosamente';
			
			}else{
			$_SESSION['tipomensajedevuelto']='error';
			$_SESSION['mensajedevuelto']='Error al modificar el nombre del PDF';
			
			if($id<=0){			
				$_SESSION['mensajedevuelto']=$_SESSION['mensajedevuelto'].' Debe seleccionar un archivo PDF';
			}
			if(nombrearchivoExiste($nombre) && $nombre!=$row['nombre'])
			{
				$_SESSION['mensajedevuelto'] = $_SESSION['mensajedevuelto']." El nombre $nombre ya está asociado a otro PDF";
			}
			
		}	
	}	
	//$_SESSION['cualareac']=$id_areac;
	$vloc="Location: administrartemas.php";
	header($vloc);
	
?>