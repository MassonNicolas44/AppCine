<?php
require_once "../Include/Conexion.php";
require_once "../Include/Funciones.php";
require_once "../fpdf/fpdf.php";

session_start();

$Total=0;
//Condicionales para preguntar si se ha seleccionado un rango de fecha para el informe
if (!empty($_SESSION['txtFechaInicio']) && !empty($_SESSION['txtFechaFin'])) {
    $FechaInicio = date("Y-m-d", strtotime($_SESSION['txtFechaInicio']));
    $FechaFin = date("Y-m-d", strtotime($_SESSION['txtFechaFin']));
}

//Sentencia para ranking de peliculas ordenada por mayor recaudacion
//Condicional donde si no se selecciona un rango de fechas, se muestran todos las recaudaciones en general
if (!empty($FechaInicio) && !empty($FechaFin)) {

    $listaRecaudacion = ListaRecaudacion($db, $FechaInicio, $FechaFin);

} else {

    $listaRecaudacion = ListaRecaudacion($db);

}



//Generar archivo PDF con el resultado del informe
$pdf = new FPDF("P", "mm", "letter");
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(35);
$pdf->Multicell(100, 8.5, "Informe de Ranking de Peliculas con mas Recaudacion", 0, "C");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x + 160, $y - 17);
$pdf->SetFont("Arial", "", 12);

if (!empty($FechaInicio) && !empty($FechaFin)) {
    $pdf->Cell(25, 5, "Fecha: " . date("Y/m/d"), 0, 1, "C");
    $pdf->Cell(317, 8, "Rango: " . $FechaInicio . " al " . $FechaFin, 0, 1, "C");
} else {
    $pdf->Cell(25, 5, "Fecha: " . date("Y/m/d"), 0, 1, "C");
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
foreach ($listaRecaudacion as $Recaudacion) {
    $pdf->Cell(15, 6, $Recaudacion['IdPelicula'], 1, 0, "C");
    $pdf->Cell(64, 6, $Recaudacion['titulo'], 1, 0, "C");
    $pdf->Cell(24, 6, $Recaudacion['categoria'], 1, 0, "C");
    $pdf->Cell(17, 6, $Recaudacion['tipo'], 1, 0, "C");
    $pdf->Cell(20, 6, $Recaudacion['habilitada'], 1, 0, "C");
    $pdf->Cell(22, 6, $Recaudacion['TotalBoleto'], 1, 0, "C");
    $pdf->Cell(27, 6, $Recaudacion['Recaudado'] . " $", 1, 1, "C");
    $Total=$Total+$Recaudacion['Recaudado'];
}

//Muestra de la sumatoria de todos los precios
$pdf->ln();
$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(15, 6, "Total", 1, 0, "C");
$pdf->Cell(147, 6, "", 1, 0, "B");
$pdf->Cell(27, 6, $Total." $ ", 1, 1, "C");
$pdf->Output();

?>