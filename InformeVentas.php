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

//Sentencia para recuperar la cantidad de ventas por cada pelicula
if (!empty($FechaInicio) && !empty($FechaFin)){
    $sql="SELECT us.IdUsuario,us.usuario,pe.titulo,pr.fechaPelicula,pr.horaPelicula,pr.CantBoleto, pr.precioFinal
FROM proyecciones AS pr 
INNER JOIN peliculas AS pe ON pe.IdPelicula=pr.IdPelicula
INNER JOIN usuarios AS us ON pr.IdUsuario =us.IdUsuario
WHERE pr.fechaPelicula BETWEEN '$FechaInicio' AND '$FechaFin'
ORDER BY pr.fechaPelicula";
}else{
    $sql="SELECT us.IdUsuario,us.usuario,pe.titulo,pr.fechaPelicula,pr.horaPelicula,pr.CantBoleto, pr.precioFinal
    FROM proyecciones AS pr 
    INNER JOIN peliculas AS pe ON pe.IdPelicula=pr.IdPelicula
    INNER JOIN usuarios AS us ON pr.IdUsuario =us.IdUsuario
    ORDER BY pr.fechaPelicula";
}

$resultado = mysqli_query($mysql,$sql);

//Generar archivo PDF con el resultado del informe
$pdf=new FPDF("P","mm","letter");
$pdf->SetMargins(10,10,10);
$pdf->AddPage();
$pdf->SetFont("Arial","B",16);
$pdf->Cell(25);
$pdf->Cell(135,5,"Informe Ventas",0,0,"C");
$pdf->SetFont("Arial","",12);

if (!empty($FechaInicio) && !empty($FechaFin)){
    $pdf->Cell(25,5,"Fecha: ".date("Y/m/d"),0,1,"C");
    $pdf->Cell(317,8,"Rango: ".$FechaInicio." al ".$FechaFin,0,1,"C");
}else{
    $pdf->Cell(25,5,"Fecha: ".date("Y/m/d"),0,1,"C");
}


$pdf->Ln(10);
$pdf->SetFont("Arial","B",12);
$pdf->Cell(12,10,"Id",1,0,"C");
$pdf->Cell(25,10,"Usuario",1,0,"C");
$pdf->Cell(65,10,"Titulo",1,0,"C");
$pdf->Cell(27,10,"Fecha",1,0,"C");
$pdf->Cell(16,10,"Hora",1,0,"C");
$pdf->Multicell(24, 5, "Cantidad Boleto", 1, "C");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x+169, $y-10);
$pdf->MultiCell(20,5,"Precio Final",1,"C");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x, $y);
$pdf->SetFont("Arial","",12);

//Codigo para recorrer la lista desde la Base de Datos y mostrarlo en las columnas/filas indicadas
while($fila=$resultado->fetch_assoc()){
    $pdf->Cell(12,6,$fila['IdUsuario'],1,0,"C");
    $pdf->Cell(25,6,utf8_decode($fila['usuario']),1,0,"C");
    $pdf->Cell(65,6,utf8_decode($fila['titulo']),1,0,"C");
    $pdf->Cell(27,6,$fila['fechaPelicula'],1,0,"C");
    $pdf->Cell(16,6,$fila['horaPelicula'],1,0,"C");
    $pdf->Cell(24,6,$fila['CantBoleto'],1,0,"C");
    $pdf->Cell(20,6,$fila['precioFinal']."$",1,1,"C");
}

$pdf->Output();

?>