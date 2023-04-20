<?php
require "Conexion.php";
require "fpdf/fpdf.php";

session_start();

//Condicionales para preguntar si se ha seleccionado un rango de fecha para el informe
if (!empty($_SESSION['txtFechaInicio']) && !empty($_SESSION['txtFechaFin'])) {
    $FechaInicio = date("d-m-Y", strtotime($_SESSION['txtFechaInicio']));
    $FechaFin = date("d-m-Y", strtotime($_SESSION['txtFechaFin']));
}

//Sentencia para ranking de peliculas ordenada por mayor cantidad de boletos
//Condicional donde si no se selecciona un rango de fechas, se muestran todos los boletos en general
if (!empty($FechaInicio) && !empty($FechaFin)) {
    $sentenciaSQL = $conexion->prepare("SELECT pe.IdPelicula,pe.titulo,pe.duracion,pe.categoria,pe.tipo,Sum(pr.precioFinal) AS Recaudado,Sum(CantBoleto) AS TotalBoleto, pe.habilitada FROM proyecciones AS pr INNER JOIN peliculas AS pe
    ON pe.IdPelicula=pr.IdPelicula 
    WHERE pr.fechaPelicula BETWEEN '$FechaInicio' AND '$FechaFin'
    Group by pe.titulo
    ORDER BY TotalBoleto desc");
} else {
    $sentenciaSQL = $conexion->prepare("SELECT pe.IdPelicula,pe.titulo,pe.duracion,pe.categoria,pe.tipo,Sum(pr.precioFinal) AS Recaudado,Sum(CantBoleto) AS TotalBoleto, pe.habilitada FROM proyecciones AS pr INNER JOIN peliculas AS pe
ON pe.IdPelicula=pr.IdPelicula 
Group by pe.titulo
ORDER BY TotalBoleto desc");
}

$sentenciaSQL->execute();
$listaBoletos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

//Generar archivo PDF con el resultado del informe
$pdf = new FPDF("P", "mm", "letter");
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(35);
$pdf->Multicell(100, 8.5, "Informe de Ranking de Peliculas con mas Boletos", 0, "C");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x + 160, $y - 17);
$pdf->SetFont("Arial", "", 12);

if (!empty($FechaInicio) && !empty($FechaFin)) {
    $pdf->Cell(25, 5, "Fecha: " . date("d/m/Y"), 0, 1, "C");
    $pdf->Cell(317, 8, "Rango: " . $FechaInicio . " al " . $FechaFin, 0, 1, "C");
} else {
    $pdf->Cell(25, 5, "Fecha: " . date("d/m/Y"), 0, 1, "C");
}

$pdf->Ln(20);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(15, 10, "Id", 1, 0, "C");
$pdf->Cell(64, 10, "Titulo", 1, 0, "C");
$pdf->Cell(24, 10, "Categoria", 1, 0, "C");
$pdf->Cell(17, 10, "Tipo", 1, 0, "C");
$pdf->Cell(20, 10, "Activa", 1, 0, "C");
$pdf->Multicell(22, 5, "Cantidad Boleto", 1, "C");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x + 162, $y - 10);
$pdf->MultiCell(27, 5, "Total Recaudado", 1, "C");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x, $y);
$pdf->SetFont("Arial", "", 12);

//Codigo para recorrer la lista desde la Base de Datos y mostrarlo en las columnas/filas indicadas
foreach ($listaBoletos as $Boletos) {
    $pdf->Cell(15, 6, $Boletos['IdPelicula'], 1, 0, "C");
    $pdf->Cell(64, 6, utf8_decode($Boletos['titulo']), 1, 0, "C");
    $pdf->Cell(24, 6, utf8_decode($Boletos['categoria']), 1, 0, "C");
    $pdf->Cell(17, 6, $Boletos['tipo'], 1, 0, "C");
    $pdf->Cell(20, 6, $Boletos['habilitada'], 1, 0, "C");
    $pdf->Cell(22, 6, $Boletos['TotalBoleto'], 1, 0, "C");
    $pdf->Cell(27, 6, $Boletos['Recaudado'] . " $", 1, 1, "C");
}

$pdf->Output();

?>