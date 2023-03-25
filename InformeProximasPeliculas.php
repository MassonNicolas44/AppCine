<?php
require "Conexion.php";
require "fpdf/fpdf.php";

session_start();



if (!empty($_SESSION['txtFechaInicio']) && !empty($_SESSION['txtFechaFin'])){
    $FechaInicio=$_SESSION['txtFechaInicio'];
    $FechaFin=$_SESSION['txtFechaFin'];
    $ReformaFechaInicio = date("Y-m-d", strtotime($FechaInicio));
    $ReformaFechaFin = date("Y-m-d", strtotime($FechaFin));
    $FechaInicio=$ReformaFechaInicio;
    $FechaFin=$ReformaFechaFin;
}

//Sentencia para seleccionar las proximas peliculas desde la base de datos
if (!empty($FechaInicio) && !empty($FechaFin)){
$sql="SELECT IdPelicula,titulo,duracion,restriccionEdad,categoria,tipo,fechaEstreno FROM proximaspeliculas
WHERE fechaEstreno BETWEEN '$FechaInicio' AND '$FechaFin'";
}else{
    $sql="SELECT IdPelicula,titulo,duracion,restriccionEdad,categoria,tipo,fechaEstreno FROM proximaspeliculas";

}    
$resultado=$mysql->query($sql);


//Generar archivo PDF con el resultado del informe
$pdf=new FPDF("P","mm","letter");
$pdf->SetMargins(10,10,10);
$pdf->AddPage();
$pdf->SetFont("Arial","B",16);
$pdf->Cell(25);
$pdf->Cell(135,5,"Informe de Proximas Peliculas",0,0,"C");
$pdf->SetFont("Arial","",12);
$pdf->Cell(25,5,"Fecha: ".date("Y/m/d"),0,1,"C");
$pdf->Ln(10);
$pdf->SetFont("Arial","B",12);
$pdf->Cell(12,10,"Id",1,0,"C");
$pdf->Cell(59,10,"Titulo",1,0,"C");
$pdf->Cell(25,10,"Duracion",1,0,"C");
$pdf->Cell(22,10,"Categoria",1,0,"C");
$pdf->Multicell(34, 5, "Restriccion Edad", 1, "C");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x+152, $y-10);
$pdf->Cell(12,10,"Tipo",1,0,"C");
$pdf->Cell(25,10,"Estreno",1,1,"C");
$pdf->SetFont("Arial","",12);

//Codigo para recorrer la lista desde la Base de Datos y mostrarlo en las columnas/filas indicadas
while($fila=$resultado->fetch_assoc()){
    $pdf->Cell(12,6,$fila['IdPelicula'],1,0,"C");
    $pdf->Cell(59,6,utf8_decode($fila['titulo']),1,0,"C");
    $pdf->Cell(25,6,$fila['duracion']." Min",1,0,"C");
    $pdf->Cell(22,6,utf8_decode($fila['categoria']),1,0,"C");
    $pdf->Cell(34,6,$fila['restriccionEdad'],1,0,"C");
    $pdf->Cell(12,6,$fila['tipo'],1,0,"C");
    $pdf->Cell(25,6,$fila['fechaEstreno'],1,1,"C");
}

$pdf->Output();
?>