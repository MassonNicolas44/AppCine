<?php
//Codigo para conectarse a la Base de Datos
$host = "localhost";
$BDusuario = "root";
$BDcontraseña = "";
$BaseDatos = "gamesofmovies";

//En caso que halla algun error se notificara junto con el error
try {
	$db = mysqli_connect($host, $BDusuario, $BDcontraseña, $BaseDatos);
} catch (Exception $ex) {
	echo $ex->getMessage();
}



$_SESSION['url'] = 'http://' . $_SERVER['HTTP_HOST'] . "/GamesOfMovies";

//Para casos especiales con Ñ o comillas
mysqli_query($db, "SET NAMES 'utf8'");

?>