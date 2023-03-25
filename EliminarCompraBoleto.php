<?php
include 'Conexion.php';

//Obtención de datos desde Android
$fechaPelicula=$_POST['fechaPelicula'];
$horaPelicula=$_POST['horaPelicula'];
$titulo=$_POST['titulo'];
$usuario=$_POST['usuario'];

//Sentencia para eliminar una compra de boleto en particular
$sentencia=$mysql->prepare("SELECT pr.IdProyeccion,pr.fechaPelicula,pr.horaPelicula,pe.titulo,us.usuario 
FROM proyecciones AS pr 
INNER JOIN peliculas AS pe ON pe.IdPelicula=pr.IdPelicula 
INNER JOIN usuarios AS us ON us.IdUsuario=pr.IdUsuario 
WHERE pr.fechaPelicula=? AND pr.horaPelicula=? AND pe.titulo=? AND us.usuario=?");

$sentencia->bind_param('ssss',$fechaPelicula,$horaPelicula,$titulo,$usuario);
$sentencia->execute();
$sentencia->store_result();
$sentencia->bind_result($IdProyeccion,$fechaPelicula,$horaPelicula,$IdPelicula,$IdUsuario);
$response=array();

while($sentencia->fetch()){
  $response["IdProyeccion"]=$IdProyeccion;
  $response["IdPelicula"]=$IdPelicula;
  $response["IdUsuario"]=$IdUsuario;
  $response["fechaPelicula"]=$fechaPelicula;
  $response["horaPelicula"]=$horaPelicula;

  //Sentencia para eliminar la fila seleccionada de proyecciones de la Base de Datos
  $query="DELETE from proyecciones WHERE IdProyeccion=$IdProyeccion";
   $result = $mysql->query($query);  
}

//Devuelve si se puedo realizar la operacion o no
if ($response!=null){
  $response["success"]=true;
}else{
  $response["success"]=false;
}
echo json_encode($response);

   
  ?>











<?php
/* include 'Conexion.php';
//Obtencion de datos desde Android
$fechaPelicula=$_POST['fechaPelicula'];
$horaPelicula=$_POST['horaPelicula'];
$titulo=$_POST['titulo'];
$usuario=$_POST['usuario'];
//Sentencia para seleccionar valores desde base de datos para luego ser eliminados
$sentencia=$mysql->prepare("SELECT pr.IdProyeccion,pr.fechaPelicula,pr.horaPelicula,pe.titulo,us.usuario
FROM proyecciones AS pr 
INNER JOIN peliculas AS pe ON pe.IdPelicula=pr.IdPelicula 
INNER JOIN usuarios AS us ON pr.IdUsuario=us.IdUsuario
WHERE pr.fechaPelicula=? AND pr.horaPelicula=? AND pe.titulo=? AND us.usuario=?");
$sentencia->bind_param('ssss',$fechaPelicula,$horaPelicula,$titulo,$usuario);
$sentencia->execute();
$sentencia->store_result();
$sentencia->bind_result($IdProyeccion,$fechaPelicula,$horaPelicula,$titulo,$usuario);
$response=array();
$response["success"]=false;
while($sentencia->fetch()){
    $response["success"]=true;
    
    $response["horaPelicula"]=$horaPelicula;
    $response["fechaPelicula"]=$fechaPelicula;
    $response["titulo"]=$titulo;
    $response["usuario"]=$usuario;
    $query="DELETE FROM proyecciones WHERE IdProyeccion=$IdProyeccion";
    $result = $mysql->query($query);
}
echo json_encode($response); */
?>