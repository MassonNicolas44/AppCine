<?php

 session_start();

if ($_SESSION['estatus']!="usuario"){
  header("location:Login.php");
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
            <a class="nav-item nav-link" href="<?php echo $url;?>/Cartelera.php"> Cartelera |֎|</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/ProximaCartelera.php"> Proximas Peliculas |֎|</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/AnularBoleto.php"> Anular Boleto |֎|</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/CerrarSession.php">Cerrar Sesion |֎|</a>
        </div>
    </nav>