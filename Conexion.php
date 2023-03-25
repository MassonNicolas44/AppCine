<?php

//Codigo para conectarse a la Base de Datos
$mysql = new mysqli(
	"localhost",
	"root",
	"",
	"gamesofmovies"
);

//En caso que halla algun error se notificara junto con el error
if ($mysql ->connect_error) {
	die("La conexion fallo".mysql(connect_error));
}
?>	