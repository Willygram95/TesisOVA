<?php
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]!=1){ //Si no ha iniciado sesión o no es un administrador redirecciona a index.php
		header("Location: index.php");
	}
	require 'funciones/conexion.php';
	include 'funciones/funciones.php';	
	$id = $_POST['id'];
	$nombres = $_POST['nombres'];
	$apellidos = $_POST['apellidos'];
	$cedula = $_POST['cedula'];
	$nick = $_POST['nick'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$id_tipo = $_POST['id_tipo'];
	if($id_tipo==1 || $id_tipo==2){
		$profesion = $_POST['profesion'];
		$carrera = "";
		$semestre = "";
	}
	if($id_tipo==3){
		$profesion = "";
		$carrera = $_POST['carrera'];
		$semestre = $_POST['semestre'];
	}
	$status = $_POST['status'];
	
	
	$sql = "SELECT cedula,nick,email FROM ovausuarios WHERE id = '$id'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
	
	if($password!="Sin cambios"){
		$pass_hash = hashPassword($password);
		$sql = "UPDATE ovausuarios SET nombres='$nombres', apellidos='$apellidos', cedula='$cedula', nick='$nick', password='$pass_hash', email='$email', id_tipo='$id_tipo', profesion='$profesion', carrera='$carrera', semestre='$semestre', status='$status' WHERE id = '$id'";
	}
	else{
		$sql = "UPDATE ovausuarios SET nombres='$nombres', apellidos='$apellidos', cedula='$cedula', nick='$nick', email='$email', id_tipo='$id_tipo', profesion='$profesion', carrera='$carrera', semestre='$semestre', status='$status' WHERE id = '$id'";
	}
	$resultado = $mysqli->query($sql);
	if($resultado) { 
		$_SESSION['cualtu']=$id_tipo;
		$_SESSION['tipomensajedevuelto']='exito';
		$_SESSION['mensajedevuelto']='Usuario modificado exitosamente';
		
		}else{
		$_SESSION['tipomensajedevuelto']='error';
		$_SESSION['mensajedevuelto']='Error al modificar el usuario';
		if(cedulaExiste($cedula) && $cedula!=$row['cedula'])
		{
			$_SESSION['mensajedevuelto'] = $_SESSION['mensajedevuelto']." El número de cédula $cedula ya existe";
		}
		if(nickExiste($nick) && $nick!=$row['nick'])
		{
			$_SESSION['mensajedevuelto'] = $_SESSION['mensajedevuelto']." El nombre de usuario $nick ya existe";
		}
		if(emailExiste($email) && $email!=$row['email'])
		{
			$_SESSION['mensajedevuelto'] = $_SESSION['mensajedevuelto']." El correo electrónico $email ya existe";
		}
		}	
		header("Location: administrarusuarios.php");	
	?>	