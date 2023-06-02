<?php

require_once "../Include/Conexion.php";
require_once "../Include/Funciones.php";
require_once "../fpdf/fpdf.php";

session_start();

//Condicionales para preguntar si se ha seleccionado un rango de fecha para el informe
if (!empty($_SESSION['txtFechaInicio']) && !empty($_SESSION['txtFechaFin'])) {
    $FechaInicio = date("d-m-Y", strtotime($_SESSION['txtFechaInicio']));
    $FechaFin = date("d-m-Y", strtotime($_SESSION['txtFechaFin']));
}

//Sentencia para recuperar la cantidad de ventas por cada pelicula
//Condicional donde si no se selecciona un rango de fechas, se muestran todos los boletos en general
if (!empty($FechaInicio) && !empty($FechaFin)) {

    $listaVentas = ListaVentas($db, $FechaInicio, $FechaFin);

} else {

    $listaVentas = ListaVentas($db);

}


//Generar archivo PDF con el resultado del informe
$pdf = new FPDF("P", "mm", "letter");
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(25);
$pdf->Cell(135, 5, "Informe Ventas", 0, 0, "C");
$pdf->SetFont("Arial", "", 12);

if (!empty($FechaInicio) && !empty($FechaFin)) {
    $pdf->Cell(25, 5, "Fecha: " . date("d/m/Y"), 0, 1, "C");
    $pdf->Cell(317, 8, "Rango: " . $FechaInicio . " al " . $FechaFin, 0, 1, "C");
} else {
    $pdf->Cell(25, 5, "Fecha: " . date("d/m/Y"), 0, 1, "C");
}


$pdf->Ln(10);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(12, 10, "Id", 1, 0, "C");
$pdf->Cell(25, 10, "Usuario", 1, 0, "C");
$pdf->Cell(65, 10, "Titulo", 1, 0, "C");
$pdf->Cell(27, 10, "Fecha", 1, 0, "C");
$pdf->Cell(16, 10, "Hora", 1, 0, "C");
$pdf->Multicell(24, 5, "Cantidad Boleto", 1, "C");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x + 169, $y - 10);
$pdf->MultiCell(20, 5, "Precio Final", 1, "C");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x, $y);
$pdf->SetFont("Arial", "", 12);

//Codigo para recorrer la lista desde la Base de Datos y mostrarlo en las columnas/filas indicadas
foreach ($listaVentas as $Ventas) {
    $pdf->Cell(12, 6, $Ventas['IdUsuario'], 1, 0, "C");
    $pdf->Cell(25, 6, $Ventas['usuario'], 1, 0, "C");
    $pdf->Cell(65, 6, $Ventas['titulo'], 1, 0, "C");
    $pdf->Cell(27, 6, $Ventas['fechaPelicula'], 1, 0, "C");
    $pdf->Cell(16, 6, $Ventas['horaPelicula'], 1, 0, "C");
    $pdf->Cell(24, 6, $Ventas['CantBoleto'], 1, 0, "C");
    $pdf->Cell(20, 6, $Ventas['precioFinal'] . "$", 1, 1, "C");
}

$pdf->Output();

?>