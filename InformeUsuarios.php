<?php
require "Conexion.php";
require "fpdf/fpdf.php";

//Sentencia para recuperar lista de usuarios desde base de datos
$sql="SELECT * FROM usuarios";
$resultado=$mysql->query($sql);

//Generar archivo PDF con el resultado del informe
$pdf=new FPDF("P","mm","letter");
$pdf->SetMargins(10,10,10);
$pdf->AddPage();
$pdf->SetFont("Arial","B",16);
$pdf->Cell(25);
$pdf->Cell(135,5,"Informe de Usuarios",0,0,"C");
$pdf->SetFont("Arial","",12);
$pdf->Cell(25,5,"Fecha: ".date("Y/m/d"),0,1,"C");
$pdf->Ln(10);
$pdf->SetFont("Arial","B",12);
$pdf->Cell(15,6,"Id",1,0,"C");
$pdf->Cell(30,6,"Nombre",1,0,"C");
$pdf->Cell(30,6,"Usuario",1,0,"C");
$pdf->Cell(30,6,"Contrasena",1,0,"C");
$pdf->Cell(30,6,"Telefono",1,0,"C");
$pdf->Cell(55,6,"Email",1,1,"C");
$pdf->SetFont("Arial","",12);

//Codigo para recorrer la lista desde la Base de Datos y mostrarlo en las columnas/filas indicadas
while($fila=$resultado->fetch_assoc()){
    $pdf->Cell(15,6,$fila['IdUsuario'],1,0,"C");
    $pdf->Cell(30,6,utf8_decode($fila['nombre']),1,0,"C");
    $pdf->Cell(30,6,utf8_decode($fila['usuario']),1,0,"C");
    $pdf->Cell(30,6,utf8_decode($fila['contraseña']),1,0,"C");
    $pdf->Cell(30,6,utf8_decode($fila['telefono']),1,0,"C");
    $pdf->Cell(55,6,utf8_decode($fila['email']),1,1,"C");
}

$pdf->Output();

?>