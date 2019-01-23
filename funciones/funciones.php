<?php
	function MenuPrincipal($activa){
		$menu="<nav class='navbar-default navbar-fixed-top'>
		<div class='cintilloudo'></div><div class='container-fluid'>
		<div class='navbar-header'>
		<div class='izqmenuprincipal'><img class='logoudoheader' src='imagenes/iconoac.svg'><span class='datosasignaturamenuprincipal'><a class='enlaceindex' href='index.php'/><div class='asignaturamenuprincipal'>".$_SESSION["id_asignatura"]."</div><div class='codigomenuprincipal'>".$_SESSION["id_codasignatura"]."
		</div></a></span><div class='lineamenuprincipal'></div></div><button type='button' class='navbar-toggle collapsed menuhamburguesasuperior' data-toggle='collapse' data-target='#navbar' aria-expanded='false' aria-controls='navbar'>
		<span class='sr-only'>Men&uacute;</span>
		<span class='icon-bar'></span>
		<span class='icon-bar'></span>
		<span class='icon-bar'></span>
		</button>
		</div>
		<div id='navbar' class='navbar-collapse collapse menuprincipalopciones'><ul class='nav navbar-nav'>";		
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==2) {
			$menu=$menu."<li";
			if($activa=='usuarios'){
				$menu=$menu." class='active'";
			}
			$menu=$menu."><a href='administrarusuarios.php'>";
			if($_SESSION['tipo_usuario']==1){
				$menu=$menu."Usuarios";
			}
			else{
				$menu=$menu."Estudiantes";
			}
			$menu=$menu."</a></li>";
		}
		if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==2) {
			$menu=$menu."
			<li";
			if($activa=='contenido'){
				$menu=$menu." class='active'";
			}
			$menu=$menu."><ul class='nav nav-tabs'><li class='dropdown'><a class='dropdown-toggle opcioncontenido' data-toggle='dropdown' href='#'>Contenido<span class='caret'></span></a><ul class='dropdown-menu'><li><a href='administrarasignatura.php'>Asignatura</a></li><li><a href='administrarareasc.php'>Áreas de conocimiento</a></li><li><a href='administrartemas.php'>Temas</a></li><li><a href='administrarglosario.php'>Glosario</a></li><li><a href='administrarbibliografia.php'>Bibliografía</a></li></ul></li></ul></li>
			";
		}
		if($_SESSION['tipo_usuario']==1) {
			$menu=$menu."
			<li class='";
			if($activa=='diseno'){
				$menu=$menu."active";
			}
			$menu=$menu."'><a href='administrardiseno.php'>Diseño</a></li>
			";
		}
		if(isset($_SESSION["id_usuario"])){
			$menu=$menu."<li class='";
			if($activa=='verova'){
				$menu=$menu."active";
			}
			$menu=$menu."'><a href='verova.php'>Ver OVA</a></li></ul>			
			<ul class='nav navbar-nav navbar-right dermenuprincipal'>
			<li";
			if($activa=='perfil'){
				$menu=$menu." class='active'";
			}
			$menu=$menu."><a href='areadeusuario.php' data-toggle='tooltip' title='Área de usuario'><span class='glyphicon glyphicon-user'></span></a></li>		
			<li><a href='logout.php'>Cerrar Sesi&oacute;n</a></li>
			</ul>";
		}
		else{
			$menu=$menu."</ul><ul class='nav navbar-nav navbar-right dermenuprincipal'>
			<li>";
			if($activa!='login'){
			$menu=$menu."<a href='login.php'>Iniciar sesión</a>";
			}
			else{
			$menu=$menu."<a href='verova.php'>Ver OVA</a>";
			}
			$menu=$menu."</li></ul>";
		}
		$menu=$menu."</div></div></nav>";
		return $menu;
	}

	function insertareditor($txtarea){
		echo "<script src='funciones/tinymce/js/tinymce/tinymce.min.js'></script>
		<script type='text/javascript'>
  			tinymce.init({
    			selector: '#".$txtarea."', plugins: 'image textcolor hr lists link',
    			toolbar1: 'undo redo | cut copy paste | formatselect alignleft aligncenter alignright alignjustify outdent indent | bullist numlist link unlink hr image',
    			toolbar2: 'fontselect fontsizeselect forecolor backcolor bold italic underline subscript superscript | removeformat',
    			menubar: false,
    			images_upload_url: 'postAcceptor.php',
    			themes: 'modern',
    			branding: false,
    			elementpath: false,
    			statusbar: false,
    			language: 'es',
  			});
  		</script>";
	}

	function eliminardetemas($id){
		global $mysqli;
		
		$sql = "DELETE FROM ovaarchivos WHERE id_tema = '$id'";
		$resultado = $mysqli->query($sql);
		$sql = "DELETE FROM ovatemascontenidos WHERE id_tema = '$id'";
		$resultado = $mysqli->query($sql);
		$sql = "DELETE FROM ovaenlaces WHERE id_tema = '$id'";
		$resultado = $mysqli->query($sql);
		$sql = "DELETE FROM ovaimagenes WHERE id_tema = '$id'";
		$resultado = $mysqli->query($sql);
		$sql = "DELETE FROM ovaseleccion WHERE id_tema = '$id'";
		$resultado = $mysqli->query($sql);
	}
		
	function isNull($nombres, $apellidos, $cedula, $nick, $pass, $email){
		if(strlen(trim($nombres)) < 1 || strlen(trim($apellidos)) < 1 || strlen(trim($cedula)) < 1 || strlen(trim($nick)) < 1 || strlen(trim($pass)) < 1 || strlen(trim($email)) < 1)
		{
			return true;
			} else {
			return false;
		}		
	}
	
	function isNulltema($titulo){
		if(strlen(trim($titulo)) < 1)
		{
			return true;
			} else {
			return false;
		}		
	}
	
	function isNullareac($titulo){
		if(strlen(trim($titulo)) < 1)
		{
			return true;
			} else {
			return false;
		}		
	}
	function isNullglosario($termino,$definicion){	
		if(strlen(trim($termino)) < 1 || strlen(trim($definicion)) <1 || trim($definicion)==" " || trim($definicion)=='')
		{
			return true;
			} else {
			return false;
		}		
	}
	function isNullbibliografia($titulo,$autor,$info){	
		if(strlen(trim($titulo)) < 1 || strlen(trim($autor)) <1 || strlen(trim($info)) <1)
		{
			return true;
			} else {
			return false;
		}		
	}
	function isNullenlace($titulo,$url){	
		if(strlen(trim($titulo)) < 1 || strlen(trim($url)) <1)
		{
			return true;
			} else {
			return false;
		}		
	}
	function isNullnombreimg($nombre){	
		if(strlen(trim($nombre)) < 1)
		{
			return true;
			} else {
			return false;
		}		
	}
	function isNullnombrearchivo($nombre){	
		if(strlen(trim($nombre)) < 1)
		{
			return true;
			} else {
			return false;
		}		
	}
	function isNullsubtema($titulo){	
		if(strlen(trim($titulo)) < 1)
		{
			return true;
			} else {
			return false;
		}		
	}
	
	function isNullactividad($tipo,$enunciado,$numopciones,$opcion1,$opcion2,$opcion3,$opcion4){	
		switch($tipo){
			case 0:
			return true;
			break;
			case 1:
			if(((strlen(trim($enunciado)) < 1 || strlen(trim($opcion1)) < 1 || strlen(trim($opcion2)) < 1 || strlen(trim($opcion3)) < 1)) || ($numopciones>3 && strlen(trim($opcion4)) < 1))
			{
				return true;
				} else {
				return false;
			}
			break;
			
			case 2:
			if((strlen(trim($enunciado)) < 1))
			{
				return true;
				} else {
				return false;
			}	
			break;
		}
	}
	
	function isEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
			} else {
			return false;
		}
	}
	
	function validaPassword($var1, $var2)
	{
		if (strcmp($var1, $var2) !== 0){
			return false;
			} else {
			return true;
		}
	}
	
	function minMax($min, $max, $valor){
		if(strlen(trim($valor)) < $min)
		{
			return true;
		}
		else if(strlen(trim($valor)) > $max)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function cedulaExiste($cedula)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id FROM ovausuarios WHERE cedula = ? LIMIT 1");
		$stmt->bind_param("s", $cedula);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();
		
		if ($num > 0){
			return true;
			} else {
			return false;
		}
	}
	
	function nickExiste($nick)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id FROM ovausuarios WHERE nick = ? LIMIT 1");
		$stmt->bind_param("s", $nick);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();
		
		if ($num > 0){
			return true;
			} else {
			return false;
		}
	}
	
	function emailExiste($email)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id FROM ovausuarios WHERE email = ? LIMIT 1");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();
		
		if ($num > 0){
			return true;
			} else {
			return false;	
		}
	}
	
	function areacExiste($titulo)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id FROM ovaareasc WHERE titulo = ? LIMIT 1");
		$stmt->bind_param("s", $titulo);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();
		
		if ($num > 0){
			return true;
			} else {
			return false;	
		}
	}
	
	function terminoExiste($termino)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id FROM ovaglosario WHERE termino = ? LIMIT 1");
		$stmt->bind_param("s", $termino);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();
		
		if ($num > 0){
			return true;
			} else {
			return false;	
		}
	}
	
	function urlExiste($url)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id FROM ovaenlaces WHERE url = ? LIMIT 1");
		$stmt->bind_param("s", $url);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();
		
		if ($num > 0){
			return true;
			} else {
			return false;	
		}
	}
	
	function nombreimgExiste($nombre)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id FROM ovaimagenes WHERE nombre = ? LIMIT 1");
		$stmt->bind_param("s", $nombre);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();
		
		if ($num > 0){
			return true;
			} else {
			return false;	
		}
	}
	
	function nombrearchivoExiste($nombre)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id FROM ovaarchivos WHERE nombre = ? LIMIT 1");
		$stmt->bind_param("s", $nombre);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();
		
		if ($num > 0){
			return true;
			} else {
			return false;	
		}
	}
	
	function generateToken()
	{
		$gen = md5(uniqid(mt_rand(), false));	
		return $gen;
	}
	
	function hashPassword($password) 
	{
		$hash = password_hash($password, PASSWORD_DEFAULT);
		return $hash;
	}
	
	function mostrarErrores($errores){
		if(count($errores) > 0)
		{
			echo "<div id='error' class='alert alert-danger' role='alert'>
			<ul>";
			foreach($errores as $error)
			{
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
			echo "</div>";	
		}
	}
	
	function prepararparaimagenes($texto){
		$inicio="<img class=\"img-responsive\" src='mostrarimagenpornombre.php?nombre=\"";
		$ancho="\"' width=\"";
		$alto="\" height=\"" ;
		$fin="\">";
		$texto = str_replace("[***", $inicio, $texto);
		$texto = str_replace("***AN:", $ancho, $texto);
		$texto = str_replace("***AL:", $alto, $texto);
		$texto = str_replace("***]", $fin, $texto);
		return $texto;
		
	}
	function registraPuntaje($idusuario, $tema, $areac, $preguntas, $npreguntas,$repeticiones){
		
		global $mysqli;

		date_default_timezone_set('America/Caracas');
		$fecha=date("d")."/".date("m")."/".date("Y");
		$hora=date("h").":".date("i")." ".date("A");
		$stmt = $mysqli->prepare("INSERT INTO ovapuntaje (id_usuario, tema, areac, preguntas, npreguntas, fecha, hora, repeticiones) VALUES(?,?,?,?,?,?,?,?)");
		$stmt->bind_param('isssissi', $idusuario, $tema, $areac, $preguntas, $npreguntas, $fecha, $hora, $repeticiones);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}

	function actualizaPuntaje($idusuario, $tema, $areac, $preguntas, $npreguntas,$repeticiones){
		
		global $mysqli;

		date_default_timezone_set('America/Caracas');
		$repeticiones=$repeticiones+1;
		$fecha=date("d")."/".date("m")."/".date("Y");
		$hora=date("h").":".date("i")." ".date("A");
		$sql = "UPDATE ovapuntaje SET preguntas='$preguntas', npreguntas='$npreguntas', fecha='$fecha', hora='$hora', repeticiones='$repeticiones' WHERE id_usuario = '$idusuario' AND areac = '$areac' AND tema = '$tema'";
		$resultado = $mysqli->query($sql);
	}
	
	function registraUsuario($nombres, $apellidos, $cedula, $nick, $pass_hash, $email, $profesion, $carrera, $semestre, $status, $token, $tipo_usuario){
		
		global $mysqli;
		
		$stmt = $mysqli->prepare("INSERT INTO ovausuarios (nombres, apellidos, cedula, nick, password, email, profesion, carrera, semestre, status, token, id_tipo) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param('sssssssssisi', $nombres, $apellidos, $cedula, $nick, $pass_hash, $email, $profesion, $carrera, $semestre, $status, $token, $tipo_usuario);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}

	
	function registraTema($titulo, $introduccion, $prerequisitos, $status, $id_areac){
		
		global $mysqli;
		
		$sql = "SELECT id FROM ovatemas WHERE id_areac='$id_areac'";
		$resultado = $mysqli->query($sql);
		$orden=$resultado->num_rows+1;
		
		$stmt = $mysqli->prepare("INSERT INTO ovatemas (titulo, introduccion, prerequisitos, status, id_areac, orden) VALUES(?,?,?,?,?,?)");
		$stmt->bind_param('sssiii', $titulo, $introduccion, $prerequisitos, $status, $id_areac, $orden);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}
	
	function registraSubTema($titulo, $contenido, $id_tema, $status){
		
		global $mysqli;
		
		$sql = "SELECT id FROM ovatemascontenidos WHERE id_tema='$id_tema'";
		$resultado = $mysqli->query($sql);
		$orden=$resultado->num_rows+1;
		
		$stmt = $mysqli->prepare("INSERT INTO ovatemascontenidos (titulo, contenido, id_tema, status, orden) VALUES(?,?,?,?,?)");
		$stmt->bind_param('ssiii', $titulo, $contenido, $id_tema, $status, $orden);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}
	
	function registraActividad($tipo,$enunciado,$numopciones,$opcion1,$opcion2,$opcion3,$opcion4,$opcioncorrecta,$id_tema,$numerogrupo){
		
		global $mysqli;
		
		$sql = "SELECT id FROM ovaseleccion WHERE id_tema='$id_tema'";
		$resultado = $mysqli->query($sql);
		$orden=$resultado->num_rows+1;
		$status=0;
		$categoria=1;
		
		$stmt = $mysqli->prepare("INSERT INTO ovaseleccion (tipo,enunciado,numopciones,opcion1,opcion2,opcion3,opcion4,opcioncorrecta,id_tema,numerogrupo,orden,status,categoria) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param('isissssiiiiii', $tipo,$enunciado,$numopciones,$opcion1,$opcion2,$opcion3,$opcion4,$opcioncorrecta,$id_tema,$numerogrupo,$orden,$status,$categoria);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}
	function isNullevaluacion($tipo,$enunciado,$numopciones,$opcion1,$opcion2,$opcion3,$opcion4,$valor){	
		switch($tipo){
			case 0:
			return true;
			break;
			case 1:
			if(((strlen(trim($enunciado)) < 1 || strlen(trim($opcion1)) < 1 || strlen(trim($opcion2)) < 1 || strlen(trim($opcion3)) < 1 || strlen(trim($valor)) < 1)) || ($numopciones>3 && strlen(trim($opcion4)) < 1))
			{
				return true;
				} else {
				return false;
			}
			break;
			
			case 2:
			if((strlen(trim($enunciado)) < 1 || strlen(trim($valor)) < 1))
			{
				return true;
				} else {
				return false;
			}	
			break;
		}
	}

	function registraEvaluacion($tipo,$enunciado,$numopciones,$opcion1,$opcion2,$opcion3,$opcion4,$opcioncorrecta,$valor,$id_tema,$numerogrupo){
		
		global $mysqli;
		
		$sql = "SELECT id FROM ovaseleccion WHERE id_tema='$id_tema'";
		$resultado = $mysqli->query($sql);
		$orden=$resultado->num_rows+1;
		$status=0;
		$categoria=2;
		
		$stmt = $mysqli->prepare("INSERT INTO ovaseleccion (tipo,enunciado,numopciones,opcion1,opcion2,opcion3,opcion4,opcioncorrecta,valor,id_tema,numerogrupo,orden,status,categoria) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param('isissssiiiiiii', $tipo,$enunciado,$numopciones,$opcion1,$opcion2,$opcion3,$opcion4,$opcioncorrecta,$valor,$id_tema,$numerogrupo,$orden,$status,$categoria);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}
	
	function registraEnlace($titulo, $url, $id_tema){
		
		global $mysqli;
		
		$stmt = $mysqli->prepare("INSERT INTO ovaenlaces (titulo, url, id_tema) VALUES(?,?,?)");
		$stmt->bind_param('ssi', $titulo, $url, $id_tema);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}
	
	function registraImagen($nombre, $ancho, $alto, $tipo, $imagen, $tamano, $nombreoriginal, $id_tema){
		
		global $mysqli;
		
		$sql="INSERT INTO ovaimagenes (nombre,ancho,alto,tipo,imagen,tamano,nombreoriginal,id_tema) VALUES ('".$nombre."',".$ancho.",".$alto.",'".$tipo."','".$imagen."',".$tamano.",'".$nombreoriginal."',".$id_tema.")";
		$resqi=$mysqli->query($sql);
		return $resqi;
	}
	
	function registraPDF($nombre, $tipo, $archivo, $tamano, $id_tema){
		
		global $mysqli;
		
		$sql="INSERT INTO ovaarchivos (nombre,tipo,archivo,tamano,id_tema) VALUES ('".$nombre."','".$tipo."','".$archivo."',".$tamano.",".$id_tema.")";
		$resqi=$mysqli->query($sql);
		return $resqi;
	}
	
	function cualtipoimagen($tipo){
		
		switch($tipo){
			case "image/jpeg":
			return "JPG";
			break;
			case "image/pjpeg":
			return "JPG";
			break;
			case "image/gif":
			return "GIF";
			break;
			case "image/bmp":
			return "BMP";
			break;
			case "image/png":
			return "PNG";
			break;
		}
		return $resqi;
	}
	
	function tamanoimagen($tamano){
		return round($tamano/1024);
	}
	
	function registraAreac($titulo, $status){
		
		global $mysqli;
		
		$sql = "SELECT id FROM ovaareasc";
		$resultado = $mysqli->query($sql);
		$orden=$resultado->num_rows+1;
		
		$stmt = $mysqli->prepare("INSERT INTO ovaareasc (titulo, status, orden) VALUES(?,?,?)");
		$stmt->bind_param('sii', $titulo, $status, $orden);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}
	
	function registraBibliografia($titulo, $autor, $info){
		
		global $mysqli;
		
		$stmt = $mysqli->prepare("INSERT INTO ovabibliografia (titulo, autor, info) VALUES(?,?,?)");
		$stmt->bind_param('sss', $titulo, $autor, $info);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}
	
	function registraGlosario($termino, $definicion){
		
		global $mysqli;
		
		$stmt = $mysqli->prepare("INSERT INTO ovaglosario (termino, definicion) VALUES(?,?)");
		$stmt->bind_param('ss', $termino, $definicion);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}
	
	/* function enviarEmail($email, $nombre, $asunto, $cuerpo){
		
		require_once 'PHPMailer/PHPMailerAutoload.php';
		
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tipo de seguridad';
		$mail->Host = 'smtp.hosting.com';
		$mail->Port = 'puerto';
		
		$mail->Username = 'miemail@dominio.com';
		$mail->Password = 'password';
		
		$mail->setFrom('miemail@dominio.com', 'Sistema de Usuarios');
		$mail->addAddress($email, $nombre);
		
		$mail->Subject = $asunto;
		$mail->Body    = $cuerpo;
		$mail->IsHTML(true);
		
		if($mail->send())
		return true;
		else
		return false;
	} */
	
	/* function validaIdToken($id, $token){
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT activacion FROM ovausuarios WHERE id = ? AND token = ? LIMIT 1");
		$stmt->bind_param("is", $id, $token);
		$stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;
		
		if($rows > 0) {
		$stmt->bind_result($activacion);
		$stmt->fetch();
		
		if($activacion == 1){
		$msg = "La cuenta ya se activo anteriormente.";
		} else {
		if(activarUsuario($id)){
		$msg = 'Cuenta activada.';
		} else {
		$msg = 'Error al Activar Cuenta';
		}
		}
		} else {
		$msg = 'No existe el registro para activar.';
		}
		return $msg;
	} */
	
	function activarUsuario($id)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("UPDATE ovausuarios SET activacion=1 WHERE id = ?");
		$stmt->bind_param('s', $id);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}
	
	function isNullLogin($nick, $password){
		if(strlen(trim($nick)) < 1 || strlen(trim($password)) < 1)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	function login($nick, $password)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id, id_tipo, password FROM ovausuarios WHERE nick = ? || email = ? LIMIT 1");
		$stmt->bind_param("ss", $nick, $nick);
		$stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;
		
		if($rows > 0) {
			
			$stmt->bind_result($id, $id_tipo, $passwd);
			$stmt->fetch();
			
			$validaPassw = password_verify($password, $passwd);
			
			if($validaPassw){
				if(isActivo($nick)){					
					lastSession($id);
					$_SESSION['id_usuario'] = $id;
					$_SESSION['tipo_usuario'] = $id_tipo;
					$_SESSION['tipomensajedevuelto'] = '';
					
					$tipoUsuario = $_SESSION['tipo_usuario'];
					$sql2 = "SELECT tipo FROM ovatipousuario WHERE id = '$tipoUsuario'";
					$result2 = $mysqli->query($sql2);
					$row2 = $result2->fetch_assoc();
					$_SESSION['tipodeusuario'] = $row2['tipo'];
					
					header("location: areadeusuario.php");
					} else {
					
					$errores = "El usuario no está activo";
				}
				} else {
				$errores = 'La contrase&ntilde;a es incorrecta';
			}
			} else {
			$errores = "El nombre de usuario o correo electr&oacute;nico no existe";
		}
		return $errores;
	}
	
	function lastSession($id)
{
global $mysqli;

$stmt = $mysqli->prepare("UPDATE ovausuarios SET last_session=NOW(), token_password='', password_request=1 WHERE id = ?");
$stmt->bind_param('s', $id);
$stmt->execute();
$stmt->close();
}

function isActivo($nick)
{
global $mysqli;

$stmt = $mysqli->prepare("SELECT status FROM ovausuarios WHERE nick = ? || email = ? LIMIT 1");
$stmt->bind_param('ss', $nick, $nick);
$stmt->execute();
$stmt->bind_result($status);
$stmt->fetch();

if ($status == 1)
{
return true;
}
else
{
return false;	
}
}	

function generaTokenPass($user_id)
{
global $mysqli;

$token = generateToken();

$stmt = $mysqli->prepare("UPDATE ovausuarios SET token_password=?, password_request=1 WHERE id = ?");
$stmt->bind_param('ss', $token, $user_id);
$stmt->execute();
$stmt->close();

return $token;
}

function getValor($campo, $campoWhere, $valor)
{
global $mysqli;

$stmt = $mysqli->prepare("SELECT $campo FROM ovausuarios WHERE $campoWhere = ? LIMIT 1");
$stmt->bind_param('s', $valor);
$stmt->execute();
$stmt->store_result();
$num = $stmt->num_rows;

if ($num > 0)
{
$stmt->bind_result($_campo);
$stmt->fetch();
return $_campo;
}
else
{
return null;	
}
}

function getPasswordRequest($id)
{
global $mysqli;

$stmt = $mysqli->prepare("SELECT password_request FROM ovausuarios WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($_id);
$stmt->fetch();

if ($_id == 1)
{
return true;
}
else
{
return null;	
}
}

function verificaTokenPass($user_id, $token){

global $mysqli;

$stmt = $mysqli->prepare("SELECT activacion FROM ovausuarios WHERE id = ? AND token_password = ? AND password_request = 1 LIMIT 1");
$stmt->bind_param('is', $user_id, $token);
$stmt->execute();
$stmt->store_result();
$num = $stmt->num_rows;

if ($num > 0)
{
$stmt->bind_result($activacion);
$stmt->fetch();
if($activacion == 1)
{
return true;
}
else 
{
return false;
}
}
else
{
return false;	
}
}

function cambiaPassword($password, $user_id, $token){

global $mysqli;

$stmt = $mysqli->prepare("UPDATE ovausuarios SET password = ?, token_password='', password_request=0 WHERE id = ? AND token_password = ?");
$stmt->bind_param('sis', $password, $user_id, $token);

if($stmt->execute()){
return true;
} else {
return false;		
}
}	
?>
