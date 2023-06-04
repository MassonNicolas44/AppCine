<?php
//Codigo para conectarse a la Base de Datos
$host = "localhost";
$BDusuario = "root";
$BDcontraseña = "";
$BaseDatos = "gamesofmovies";

//En caso que halla algun error se notificara junto con el error
try {
	$db = mysqli_connect($host, $BDusuario, $BDcontraseña, $BaseDatos);
	//Para casos especiales con Ñ o comillas
} catch (Exception $ex) {
	echo $ex->getMessage();
}

?>