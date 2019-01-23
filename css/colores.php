<?php
// La siguiente línea indica al navegador que lea el archivo como una hoja de estilos
header("Content-type: text/css");

	require './../funciones/conexion.php';
	require './../funciones/funciones.php';

	$sqlcl = "SELECT * FROM ovadiseno";
	$resultadocl = $mysqli->query($sqlcl);
	$rowcl = $resultadocl->fetch_array(MYSQLI_ASSOC);

	$colorprincipal=$rowcl['colorprincipal'];
	$colorresaltado=$rowcl['colorsecundario'];
	$_SESSION['colorprincipal']=$colorprincipal;

		/*$colorprincipal='#ffffff';
		$colorresaltado='#000000';*/
?>

/* Con color principal */
div.formulario button.btn{
	background-color:<?php echo $colorprincipal; ?> !important;
}
.eliminar:hover{
	color:<?php echo $colorprincipal; ?> !important;
}
div.modal-header ul li a{
	background-color:<?php echo $colorprincipal; ?> !important;
}
.boton{
	background-color:<?php echo $colorprincipal; ?> !important;
}
.botonnuevo{
	background-color:<?php echo $colorprincipal; ?> !important;
}
tr:hover{
	color:<?php echo $colorprincipal; ?> !important;
}
tr:hover a{
	color:<?php echo $colorprincipal; ?> !important;
}
tr:hover td a span{
	color:<?php echo $colorprincipal; ?> !important;
}
.colorprincipal, .colorsecundario{
	background-color:<?php echo $colorprincipal; ?> !important;
}
.cintilloudo{
	background-color:<?php echo $colorprincipal; ?> !important;
}
.opcionmenulateral:hover{
	/*border-left-color:#2d3a44 !important;*/
	/*border-left-color:<?php echo $colorprincipal; ?> !important;*/
}
.opcionmenulateralinicial{
	border-left-color:<?php echo $colorprincipal; ?> !important;
}
.lineabotonac{
	background-color:<?php echo $colorprincipal; ?> !important;
}
.revtituloac{
	color:<?php echo $colorprincipal; ?> !important;;
}
.btninicio{
	background-color:<?php echo $colorprincipal; ?> !important;
}
.glyphicon-ok{
	color:#3f515f !important;
}

/* Con color resaltado */
div.formulario button.btn:hover{
	background-color:<?php echo $colorresaltado; ?> !important;
}
div.modal-header ul li a:hover{
	background-color:<?php echo $colorresaltado; ?> !important;	
}
.boton:hover{
	background-color:<?php echo $colorresaltado; ?> !important;
}
.botonnuevo:hover{
	background-color:<?php echo $colorresaltado; ?> !important;
}
td a span:hover{
	color:<?php echo $colorresaltado; ?> !important;
}
tr td a:hover{
	color:<?php echo $colorresaltado; ?> !important;
}
.colorsecundario{
	background-color:<?php echo $colorresaltado; ?> !important;
}
.cuadradoalrededor{
		background:<?php echo $colorresaltado; ?>;
}
.actividadcontador{
	background:<?php echo $colorresaltado; ?> !important;;
}
.btninicio:hover{
	background-color:<?php echo $colorresaltado; ?> !important;
}