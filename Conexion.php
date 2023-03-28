<?php
//Codigo para conectarse a la Base de Datos
$host="localhost";
$db="gamesofmovies";
$BDusuario="root";
$BDcontraseña="";
//En caso que halla algun error se notificara junto con el error
try {
	$conexion=new PDO("mysql:host=$host;dbname=$db",$BDusuario,$BDcontraseña); 
}catch (Exception $ex) {
	echo $ex-> getMessage();
}


?>	