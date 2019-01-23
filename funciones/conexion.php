<?php 
$mysqli = mysqli_connect("localhost", "walsyste_willy", "a?n3lzb6-yf9") or die("Problema al conectar al host");
mysqli_select_db($mysqli, "walsyste_ova") or die("Problema al conectar la BD");
$tildes = $mysqli->query("SET NAMES 'utf8'");

?>