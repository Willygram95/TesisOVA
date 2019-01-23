<?php


/*

Nombres y Apellidos: William Andres Lemus Bula
Programa: Desarrollo Web con PHP
Nombre de la evidencia: Actividad de aprendizaje 2, Evidencia Taller: "Uso de arreglos"

*/


//contenido del array $ap
$ap = array(
	array(
	      'Jesus',
	      'Calle 74 # 25b - 16',
	      '3652515',
	      '6 de octubre',
	      'Verde'),

	array(
	       'William',
	       'Carrera 26 # 73 - 186',
	       '3653180',
	       '28 de marzo',
	       'Azul'),

	array(
	       'Camilo',
	       'Calle 60 # 37 - 70',
	       '3651926',
	       '8 de marzo',
	       'Amarillo'),

	array(
	       'Miguel',
	       'Carrera 46 # 90 - 23',
	       '3657854',
	       '30 de agosto',
	       'Negro'),
	);





//array de colores donde estara contenida la informacion de los significados de los colores
$ac = array(
	'Verde' => 'Celos',
	'Azul' => 'Confianza',
	'Violeta' => 'Ambicion'
    );


//echo para poder implementar una etiqueta style y asi darle los estilos a la tabla

echo "<style>
     th {
     	background-color: #B6DDE8;
     	text-align: center;
     }

     td {
		text-align: center;
		}
     </style>";



//dentro de una variable "$table" se va a guardar la maquetancion de la tabla


$table = "

<table border='1' width='100%'>
	<tr>
		<th>Nombre</th>
		<th>Direccion</th>
		<th>Telefono</th>
		<th>Fecha de cumpleaños</th>
		<th>Color</th>
		<th>Significado</th>
	</tr>
<tbody>
";



//en esta variable se va a guardar la informacion correspondiente a la condicion de la exitencia del significado

$significado = "";




//se recorre los arrays de personas para que se muestre todo los datos en la tabla con foreach

foreach ($ap as $persona) {
	$table.= "

	<tr>
		<td>$persona[0]</td>
		<td>$persona[1]</td>
		<td>$persona[2]</td>
		<td>$persona[3]</td>
		<td>$persona[4]</td>
	";



	//dentro del ciclo se hace la siguiente condicion, en primer lugar si, dentro de la variable del array de persona, en este caso: "$persona[4]" está definido un color (que se encuentra en la posicion 4 del array), correspondiente con el contenido del array de los significados de los colores: "$ac[]" esto se hace con "isset", entonces dado caso que se cumpla se guardará en la variable de "$significados", de lo contrario se guardará un String con la siguiente cadena: "No se encuentra el significado" 


 
	if (isset($ac[$persona[4]])) {
		$significado = $ac[$persona[4]];
	}

	else {
		$significado = "No se encuentra el significado";
	}



    //esta parte del codigo permite mostrar los resultados obtenidos de la variable significado y respresentarlo en la misma tabla


	$table.="
	    

	    <td>$significado</td>

	</tr>";


}


//se cierra la tabla con la etiqueta <table> usando la variable $table 


$table.="</table>";


//Finalmente se usa un echo para mostar la tabla en su totalidad.


echo $table;


?>
