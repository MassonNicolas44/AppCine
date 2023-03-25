<?php
include ('conexion.php');

$host = "localhost";
$user = "root";
$pass = "";
$name = "gamesofmovies";

//Codigo para conectarse a la Base de Datos
$conexion = mysqli_connect($host,$user,$pass,$name);

//Codigo para obtener todos los datos de la tabla "proximaspeliculas" desde la Base de Datos
$sql="SELECT * from proximaspeliculas";
$result=mysqli_query($conexion,$sql);
$datos=mysqli_fetch_all($result,MYSQLI_ASSOC);

//En caso de obtener datos, se envian los mismos a Android Studios, en caso contrarior se envian vacios
if (!empty($datos)){
    echo json_encode($datos);
}else{
    echo json_encode([]);
}
?>
