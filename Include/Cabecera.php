<?php

session_start();

//Corrabora si el estatus es Admin, caso contrario vuelve al login
if (($_SESSION['Privilegio'] != "Administrador") && ($_SESSION['Privilegio'] != "Usuario")) {
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

      <?php if (($_SESSION['Privilegio'] == "Administrador")) { ?>

        <a class="nav-item nav-link" href="<?php echo $url; ?>/Administrador/Peliculas.php"> Administrar Peliculas |֎|</a>
        <a class="nav-item nav-link" href="<?php echo $url; ?>/Administrador/AdministrarUsuarios.php"> Administrar Usuarios |֎|</a>
        <a class="nav-item nav-link" href="<?php echo $url; ?>/Administrador/InformePeliculas.php"> Informe de Peliculas |֎|</a>
        <a class="nav-item nav-link" href="<?php echo $url; ?>/Administrador/InformeAdministrativo.php"> Informe Administrativo |֎|</a>
        <a class="nav-item nav-link" href="<?php echo $url; ?>/Include/CerrarSession.php">Cerrar Sesion |֎|</a>

      <?php } elseif ($_SESSION['Privilegio'] == "Usuario") { ?>

        <H3> Bienvenido <?php echo "".$_SESSION['NombreUsuario']." ". $_SESSION['ApellidoUsuario'] ?>  </H3>
        <a class="nav-item nav-link"> |֎| </a>
        <a class="nav-item nav-link" href="<?php echo $url; ?>/Usuario/Cartelera.php"> Cartelera |֎|</a>
        <a class="nav-item nav-link" href="<?php echo $url; ?>/Usuario/ProximasPeliculas.php"> Proximas Peliculas |֎|</a>
        <a class="nav-item nav-link" href="<?php echo $url; ?>/Usuario/AnularReserva.php"> Anular Reserva |֎|</a>
        <a class="nav-item nav-link" href="<?php echo $url; ?>/Include/CerrarSession.php">Cerrar Sesion |֎|</a>

      <?php }
      ; ?>

    </div>
  </nav>