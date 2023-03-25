<?php
require "Conexion.php";
require "fpdf/fpdf.php";

//Sentencia para seleccionar informes de peliculas
$sql="SELECT IdPelicula,titulo,duracion,restriccionEdad,categoria,tipo,precio FROM peliculas";
$resultado=$mysql->query($sql);

//Generar archivo PDF con el resultado del informe
$pdf=new FPDF("P","mm","letter");
$pdf->SetMargins(10,10,10);
$pdf->AddPage();
$pdf->SetFont("Arial","B",16);
$pdf->Cell(25);
$pdf->Cell(135,5,"Informe de Peliculas",0,0,"C");
$pdf->SetFont("Arial","",12);

$pdf->Cell(25,5,"Fecha: ".date("Y/m/d"),0,1,"C");
$pdf->Ln(10);
$pdf->SetFont("Arial","B",12);
$pdf->Cell(12,10,"Id",1,0,"C");
$pdf->Cell(63,10,"Titulo",1,0,"C");
$pdf->Cell(27,10,"Duracion",1,0,"C");
$pdf->Cell(25,10,"Categoria",1,0,"C");
$pdf->Multicell(30, 5, "Restriccion Edad", 1, "C");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x+157, $y-10);
$pdf->Cell(14,10,"Tipo",1,0,"C");
$pdf->Cell(18,10,"Precio",1,1,"C");
$pdf->SetFont("Arial","",12);

//Codigo para recorrer la lista desde la Base de Datos y mostrarlo en las columnas/filas indicadas
while($fila=$resultado->fetch_assoc()){
    $pdf->Cell(12,6,$fila['IdPelicula'],1,0,"C");
    $pdf->Cell(63,6,utf8_decode($fila['titulo']),1,0,"C");
    $pdf->Cell(27,6,$fila['duracion']." Min",1,0,"C");
    $pdf->Cell(25,6,utf8_decode($fila['categoria']),1,0,"C");
    $pdf->Cell(30,6,$fila['restriccionEdad'],1,0,"C");
    $pdf->Cell(14,6,$fila['tipo'],1,0,"C");
    $pdf->Cell(18,6,$fila['precio']."$",1,1,"C");
}

$pdf->Output();
?>


