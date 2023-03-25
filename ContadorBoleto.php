<?php
include 'Conexion.php';

//Obtención de datos desde Android
$fechaPelicula=$_POST['fechaPelicula'];
$horaPelicula=$_POST['horaPelicula'];
$titulo=$_POST['titulo'];
$Boleto=$_POST['Boleto'];
$Boleto=(int)$Boleto;
$Total = 50;
$disponibilidad = 50;

//Sentencia para comprobar que la cantidad de boletos ingresados, no sea superior a la disponibilidad
$sentencia=$mysql->prepare("SELECT Sum(pr.CantBoleto),pr.fechaPelicula,pr.horaPelicula,pe.titulo FROM proyecciones AS pr INNER JOIN peliculas AS pe
  ON pe.IdPelicula=pr.IdPelicula WHERE pr.fechaPelicula=? AND pr.horaPelicula=? AND pe.titulo=?");
$sentencia->bind_param('sss',$fechaPelicula,$horaPelicula,$titulo);
$sentencia->execute();
$sentencia->store_result();

//Variables devueltas de la consulta
$sentencia->bind_result($CantBoleto,$fechaPelicula,$horaPelicula,$titulo);
$response=array();
$response["success"]=false;
$Total = $Total - $CantBoleto;

//Recorre los datos obtenidos y realiza la cuenta matematica para luego con el If indicar si hay suficientes boletos o no
while($sentencia->fetch()){
  $disponibilidad=$disponibilidad-$CantBoleto;
  $CantBoleto+=$Boleto;
}
if ($Total>=$CantBoleto){
    //Parametro enviado a Android para confirmar el pedido de compra    
    $response["success"]=true;
    }else{
        $response["success"]=false;
        $disponibilidad=$Total-$disponibilidad;
        $response["Disponibilidad"]=$disponibilidad;  
    } 
echo json_encode($response);
?>
