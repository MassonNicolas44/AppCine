<?php

session_start();

if ( $_SESSION['estatus']!="logeado"){
  echo "logeado";
//header("location:Login.php");
}else{
  $_SESSION['estatus']="no logeado";
  echo "No logeado";
}

?>

<!doctype html>
<html lang="en">
  <head>
    <title>GamesOfMovies</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <?php $url='http://'.$_SERVER['HTTP_HOST']."/GamesOfMovies"?>
    <nav class="navbar navbar-expand -lg navbar-dark bg-primary">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link" href="<?php echo $url;?>/InformeUsuarios.php"> Informe de Usuarios |֎|</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/InformePeliculas.php"> Informe de Peliculas |֎|</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/InformeProximasPeliculas.php"> Informe de Proximas Peliculas |֎|</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/InformeVentas.php"> Informe de Ventas Peliculas |֎|</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/InformeRankingPeliculasRecaudado.php"> Informe de Ranking de las Peliculas con mas Recaudacion |֎|</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/InformeRankingPeliculasBoleto.php"> Informe de Ranking de las Peliculas con mas Boletos Vendidos</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/Login.php"> |֎| Cerrar Sesion </a>
          </div>
    </nav>