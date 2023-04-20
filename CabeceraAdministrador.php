<?php

session_start();
//Corrabora si el estatus es Admin, caso contrario vuelve al login
if ($_SESSION['estatus'] != "admin") {
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
  <?php $url = 'http://' . $_SERVER['HTTP_HOST'] . "/GamesOfMovies" ?>
  <nav class="navbar navbar-expand -lg navbar-dark bg-primary">
    <div class="nav navbar-nav">
      <a class="nav-item nav-link" href="<?php echo $url; ?>/Peliculas.php"> Administrar Peliculas |֎|</a>
      <a class="nav-item nav-link" href="<?php echo $url; ?>/InformeUsuarios.php"> Administrar Usuarios |֎|</a>
      <a class="nav-item nav-link" href="<?php echo $url; ?>/InformePeliculas.php"> Informe de Peliculas |֎|</a>
      <a class="nav-item nav-link" href="<?php echo $url; ?>/InformeVentas.php"> Informe Adicional de Peliculas |֎|</a>
      <a class="nav-item nav-link" href="<?php echo $url; ?>/CerrarSession.php">Cerrar Sesion |֎|</a>
    </div>
  </nav>