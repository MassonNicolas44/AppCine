<?php

require_once "../Include/Conexion.php";
require_once "../Include/Funciones.php";
require_once "../fpdf/fpdf.php";

//Sentencia para mostrar todas las proximas peliculas (las que estan actualmente y las que no)
$listaProximasPeliculas = ListaProximasPeliculas($db);

//Generar archivo PDF con el resultado del informe
$pdf = new FPDF("P", "mm", "letter");
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(25);
$pdf->Cell(135, 5, "Informe de Proximas Peliculas", 0, 0, "C");
$pdf->SetFont("Arial", "", 12);
$pdf->Cell(25, 5, "Fecha: " . date("d/m/Y"), 0, 1, "C");
$pdf->Ln(10);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(12, 10, "Id", 1, 0, "C");
$pdf->Cell(59, 10, "Titulo", 1, 0, "C");
$pdf->Cell(25, 10, "Duracion", 1, 0, "C");
$pdf->Cell(22, 10, "Categoria", 1, 0, "C");
$pdf->Multicell(34, 5, "Restriccion Edad", 1, "C");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x + 152, $y - 10);
$pdf->Cell(12, 10, "Tipo", 1, 0, "C");
$pdf->Cell(25, 10, "Estreno", 1, 1, "C");
$pdf->SetFont("Arial", "", 12);

//Codigo para recorrer la lista desde la Base de Datos y mostrarlo en las columnas/filas indicadas
foreach ($listaProximasPeliculas as $ProximaPelicula) {
    $pdf->Cell(12, 6, $ProximaPelicula['IdPelicula'], 1, 0, "C");
    $pdf->Cell(59, 6, utf8_decode($ProximaPelicula['titulo']), 1, 0, "C");
    $pdf->Cell(25, 6, $ProximaPelicula['duracion'] . " Min", 1, 0, "C");
    $pdf->Cell(22, 6, utf8_decode($ProximaPelicula['categoria']), 1, 0, "C");
    $pdf->Cell(34, 6, $ProximaPelicula['restriccionEdad'], 1, 0, "C");
    $pdf->Cell(12, 6, $ProximaPelicula['tipo'], 1, 0, "C");
    $pdf->Cell(25, 6, $ProximaPelicula['fechaEstreno'], 1, 1, "C");
}

$pdf->Output();
?>