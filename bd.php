<?php 
    $host="localhost";
    $db="gamesofmovies";
    $BDusuario="root";
    $BDcontraseña="";

    try {
        $conexion=new PDO("mysql:host=$host;dbname=$db",$BDusuario,$BDcontraseña); 
    }catch (Exception $ex) {
        echo $ex-> getMessage();
    }
?>