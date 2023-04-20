<?php
require "Conexion.php";
require "fpdf/fpdf.php";


//Sentencia para mostrar todas las peliculas (las que estan actualmente y las que no)
$sentenciaSQL = $conexion->prepare("SELECT IdPelicula,titulo,duracion,restriccionEdad,categoria,tipo,precio,habilitada FROM peliculas");
$sentenciaSQL->execute();
$listaPeliculas = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

//Generar archivo PDF con el resultado del informe
$pdf = new FPDF("P", "mm", "letter");
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(25);
$pdf->Cell(135, 5, "Informe de Peliculas", 0, 0, "C");
$pdf->SetFont("Arial", "", 12);

$pdf->Cell(25, 5, "Fecha: " . date("d/m/Y"), 0, 1, "C");
$pdf->Ln(10);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(12, 10, "Id", 1, 0, "C");
$pdf->Cell(63, 10, "Titulo", 1, 0, "C");
$pdf->Cell(27, 10, "Duracion", 1, 0, "C");
$pdf->Cell(25, 10, "Categoria", 1, 0, "C");
$pdf->Multicell(30, 5, "Restriccion Edad", 1, "C");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x + 157, $y - 10);
$pdf->Cell(14, 10, "Tipo", 1, 0, "C");
$pdf->Cell(18, 10, "Precio", 1, 1, "C");
$pdf->SetFont("Arial", "", 12);

//Codigo para recorrer la lista desde la Base de Datos y mostrarlo en las columnas/filas indicadas
foreach ($listaPeliculas as $pelicula) {

    $pdf->Cell(12, 6, $pelicula['IdPelicula'], 1, 0, "C");
    $pdf->Cell(63, 6, utf8_decode($pelicula['titulo']), 1, 0, "C");
    $pdf->Cell(27, 6, $pelicula['duracion'] . " Min", 1, 0, "C");
    $pdf->Cell(25, 6, utf8_decode($pelicula['categoria']), 1, 0, "C");
    $pdf->Cell(30, 6, $pelicula['restriccionEdad'], 1, 0, "C");
    $pdf->Cell(14, 6, $pelicula['tipo'], 1, 0, "C");
    $pdf->Cell(18, 6, $pelicula['precio'] . " $", 1, 1, "C");
}

$pdf->Output();

?>