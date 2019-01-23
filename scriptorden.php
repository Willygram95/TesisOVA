<?php
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){   	
		session_start(); //Iniciar una nueva sesión o reanudar la existente
		if(!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"]==3){ //Si no ha iniciado sesión o no es un administrador o docente redirecciona a index.php
			header("Location: index.php");
		}
		require 'funciones/conexion.php';
		
		$devolver = null;
		$consulta = '';
		
		$aordenar = $_POST['qo'];
		switch($aordenar){
			case 'ac':{ 
				$cualtabla="ovaareasc";
			}
			break;
			case 'tm':{ 
				$cualtabla="ovatemas";
			}
			break;
			case 'st':{ 
				$cualtabla="ovatemascontenidos";
			}
			break;
			case 'at':{ 
				$cualtabla="ovaseleccion";
			}
			break;
			case 'ev':{ 
				$cualtabla="ovaseleccion";
			}
			break;
		}
		
		$puntos = explode(',',$_POST['puntos']);
		$consulta = "UPDATE ".$cualtabla." SET orden = CASE id ".PHP_EOL;
		foreach ($puntos as $index => $id){
			$idPunto = explode('-', $id);
			$idPunto = mysqli_real_escape_string($mysqli,$idPunto[1]);
			$orden = mysqli_real_escape_string($mysqli, ($index + 1));
			$consulta .= 'WHEN '.$idPunto.' THEN '.$orden.''.PHP_EOL;
		}
		$consulta .= 'ELSE orden'.PHP_EOL.'END';
		echo $consulta;
		if (mysqli_query($mysqli, $consulta)){
			$devolver = array ('realizado' => true);
		}			
		break;
		
		if ($devolver)
		echo json_encode($devolver);
	}
	else {
		die('No se está accediendo correctamente al script de ordenación');
	}
?>