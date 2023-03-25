<?php
include 'Conexion.php';

//Obtención de datos desde Android
$fechaPelicula=$_POST['fechaPelicula'];
$Boleto=$_POST['Boleto'];
$Boleto=(int)$Boleto;
$horaPelicula=$_POST['horaPelicula'];
$titulo=$_POST['titulo'];
$usuario=$_POST['usuario'];
$precioFinal=$_POST['precioFinal'];

//Sentencia para seleccionar id's para una posterior carga de datos
$sentencia=$mysql->prepare("SELECT IdPelicula, IdUsuario FROM peliculas,usuarios WHERE titulo=? AND usuario=?");
  $sentencia->bind_param('ss',$titulo,$usuario);
  $sentencia->execute();
  $sentencia->store_result();
  $sentencia->bind_result($IdPelicula,$IdUsuario);
  $response=array();
  while($sentencia->fetch()){
    $response["IdPelicula"]=$IdPelicula;
    $response["titulo"]=$titulo;
    $response["IdUsuario"]=$IdUsuario;
    $response["usuario"]=$usuario;
  }
  
//Sentencia para realizar la carga de una nueva proyeccion a la base de datos
    $query="INSERT INTO proyecciones (IdPelicula, IdUsuario, fechaPelicula,horaPelicula,CantBoleto,precioFinal) 
   VALUES ('$IdPelicula','$IdUsuario','$fechaPelicula','$horaPelicula','$Boleto','$precioFinal')";
   $result = $mysql->query($query);  
   
  ?>
