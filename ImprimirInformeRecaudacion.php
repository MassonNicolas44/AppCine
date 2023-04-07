<?php
require "Conexion.php";
require "fpdf/fpdf.php";

session_start();

if (!empty($_SESSION['txtFechaInicio']) && !empty($_SESSION['txtFechaFin'])){
    $FechaInicio=$_SESSION['txtFechaInicio'];
    $FechaFin=$_SESSION['txtFechaFin'];
    $ReformaFechaInicio = date("d-m-Y", strtotime($FechaInicio));
    $ReformaFechaFin = date("d-m-Y", strtotime($FechaFin));
    $FechaInicio=$ReformaFechaInicio;
    $FechaFin=$ReformaFechaFin;
}

//Sentencia para ranking de peliculas ordenada por mayor recaudacion
if (!empty($FechaInicio) && !empty($FechaFin)){
    $sentenciaSQL = $conexion->prepare("SELECT pe.IdPelicula,pe.titulo,pe.duracion,pe.categoria,pe.tipo,Sum(pr.precioFinal) AS Recaudado,Sum(CantBoleto) AS TotalBoleto FROM proyecciones AS pr INNER JOIN peliculas AS pe
    ON pe.IdPelicula=pr.IdPelicula 
    WHERE pr.fechaPelicula BETWEEN '$FechaInicio' AND '$FechaFin'
    Group by pe.titulo
    ORDER BY Recaudado desc");
}else{
    $sentenciaSQL = $conexion->prepare("SELECT pe.IdPelicula,pe.titulo,pe.duracion,pe.categoria,pe.tipo,Sum(pr.precioFinal) AS Recaudado,Sum(CantBoleto) AS TotalBoleto FROM proyecciones AS pr INNER JOIN peliculas AS pe
ON pe.IdPelicula=pr.IdPelicula 
Group by pe.titulo
ORDER BY Recaudado desc");
}

$sentenciaSQL->execute();
$listaRecaudacion=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

//Generar archivo PDF con el resultado del informe
$pdf=new FPDF("P","mm","letter");
$pdf->SetMargins(10,10,10);
$pdf->AddPage();
$pdf->SetFont("Arial","B",16);
$pdf->Cell(35);
$pdf->Multicell(100, 8.5, "Informe de Ranking de Peliculas con mas Recaudacion", 0, "C");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x+160, $y-17);
$pdf->SetFont("Arial","",12);

if (!empty($FechaInicio) && !empty($FechaFin)){
    $pdf->Cell(25,5,"Fecha: ".date("d/m/Y"),0,1,"C");
    $pdf->Cell(317,8,"Rango: ".$FechaInicio." al ".$FechaFin,0,1,"C");
}else{
    $pdf->Cell(25,5,"Fecha: ".date("d/m/Y"),0,1,"C");
}

$pdf->Ln(20);
$pdf->SetFont("Arial","B",12);
$pdf->Cell(14,10,"Id",1,0,"C");
$pdf->Cell(61,10,"Titulo",1,0,"C");
$pdf->Cell(25,10,"Duracion",1,0,"C");
$pdf->Cell(25,10,"Categoria",1,0,"C");
$pdf->Cell(15,10,"Tipo",1,0,"C");
$pdf->Multicell(24, 5, "Cantidad Boleto", 1, "C");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x+164, $y-10);
$pdf->MultiCell(25,5,"Total Recaudado",1,"C");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x, $y);
$pdf->SetFont("Arial","",12);

//Codigo para recorrer la lista desde la Base de Datos y mostrarlo en las columnas/filas indicadas
foreach($listaRecaudacion as $Recaudacion){
    $pdf->Cell(14,6,$Recaudacion['IdPelicula'],1,0,"C");
    $pdf->Cell(61,6,utf8_decode($Recaudacion['titulo']),1,0,"C");
    $pdf->Cell(25,6,$Recaudacion['duracion']." Min",1,0,"C");
    $pdf->Cell(25,6,utf8_decode($Recaudacion['categoria']),1,0,"C");
    $pdf->Cell(15,6,$Recaudacion['tipo'],1,0,"C");
    $pdf->Cell(24,6,$Recaudacion['TotalBoleto'],1,0,"C");
    $pdf->Cell(25,6,$Recaudacion['Recaudado']." $",1,1,"C");
}

$pdf->Output();

?>