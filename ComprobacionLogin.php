<?php

// PHP para comprobar que el usuario ingresado se encuentre en la base de datos
include 'Conexion.php';
$usuario=$_POST['usuario'];
$contraseña=$_POST['contraseña'];
$sentencia=$mysql->prepare("SELECT usuario,contraseña FROM usuarios WHERE usuario=? AND contraseña=?");
$sentencia->bind_param('ss',$usuario,$contraseña);
$sentencia->execute();
$sentencia->store_result();
$sentencia->bind_result($usuario,$contraseña);
$response=array();
$response["success"]=false;

while($sentencia->fetch()){
    $response["success"]=true;
    $response["usuario"]=$usuario;
    $response["contraseña"]=$contraseña;
}
echo json_encode($response);
?>