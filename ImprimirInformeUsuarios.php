<?php
require "Conexion.php";
require "fpdf/fpdf.php";

//Sentencia para recuperar lista de usuarios desde base de datos
$sentenciaSQL = $conexion->prepare("SELECT * FROM usuarios");
$sentenciaSQL->execute();
$listaUsuarios=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

//Generar archivo PDF con el resultado del informe
$pdf=new FPDF("P","mm","letter");
$pdf->SetMargins(10,10,10);
$pdf->AddPage();
$pdf->SetFont("Arial","B",16);
$pdf->Cell(25);
$pdf->Cell(135,5,"Informe de Usuarios",0,0,"C");
$pdf->SetFont("Arial","",12);
$pdf->Cell(25,5,"Fecha: ".date("d/m/Y"),0,1,"C");
$pdf->Ln(10);
$pdf->SetFont("Arial","B",12);
$pdf->Cell(15,6,"Id",1,0,"C");
$pdf->Cell(27,6,"Usuario",1,0,"C");
$pdf->Cell(28,6,"Contrasena",1,0,"C");
$pdf->Cell(30,6,"Nombre",1,0,"C");
$pdf->Cell(30,6,"Telefono",1,0,"C");
$pdf->Cell(45,6,"Email",1,0,"C");
$pdf->Cell(22,6,"Habilitado",1,1,"C");
$pdf->SetFont("Arial","",12);

//Codigo para recorrer la lista desde la Base de Datos y mostrarlo en las columnas/filas indicadas
foreach($listaUsuarios as $Usuario){
    $pdf->Cell(15,6,$Usuario['IdUsuario'],1,0,"C");
    $pdf->Cell(27,6,utf8_decode($Usuario['usuario']),1,0,"C");
    $pdf->Cell(28,6,utf8_decode($Usuario['contraseña']),1,0,"C");
    $pdf->Cell(30,6,utf8_decode($Usuario['nombre']),1,0,"C");
    $pdf->Cell(30,6,utf8_decode($Usuario['telefono']),1,0,"C");
    $pdf->Cell(45,6,utf8_decode($Usuario['email']),1,0,"C");
    $pdf->Cell(22,6,utf8_decode($Usuario['habilitado']),1,1,"C");
}

$pdf->Output();

?>