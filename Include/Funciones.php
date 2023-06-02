<?php


function ListaPeliculas($db)
{

  $Peliculas = "SELECT * FROM peliculas";

  $listaPeliculas = mysqli_query($db, $Peliculas);

  return $listaPeliculas;

}

function ListaProximasPeliculas($db)
{

  $ProximasPeliculas = "SELECT * FROM proximaspeliculas";

  $listaProximasPeliculas = mysqli_query($db, $ProximasPeliculas);

  return $listaProximasPeliculas;

}

function asd($db, $habilitada = null, $noHabilitada = null, $idPelicula = null, $IdProximasPelicula = null)
{

  if (!empty($habilitada) && (!empty($idPelicula))) {

    $sql = "UPDATE peliculas SET habilitada='$habilitada' WHERE idPelicula='$idPelicula'";

  } elseif (!empty($noHabilitada) && (!empty($idPelicula))) {

    $sql = "UPDATE peliculas SET habilitada='$noHabilitada' WHERE idPelicula='$idPelicula'";


  } elseif (!empty($habilitada) && (!empty($IdProximasPelicula))) {

    $sql = "UPDATE proximaspeliculas SET habilitada='$habilitada' WHERE idPelicula='$IdProximasPelicula'";

  } elseif (!empty($noHabilitada) && (!empty($IdProximasPelicula))) {

    $sql = "UPDATE proximaspeliculas SET habilitada='$noHabilitada' WHERE idPelicula='$IdProximasPelicula'";
  }

  mysqli_query($db, $sql);

  header("Location:InformePeliculas.php");

}

function ListaVentas($db, $FechaInicio = null, $FechaFin = null)
{

  $Venta = "SELECT us.IdUsuario,us.usuario,pe.titulo,pr.fechaPelicula,pr.horaPelicula,pr.CantBoleto, pr.precioFinal
    FROM proyecciones AS pr 
    INNER JOIN peliculas AS pe ON pe.IdPelicula=pr.IdPelicula
    INNER JOIN usuarios AS us ON pr.IdUsuario =us.IdUsuario ";

  if (!empty($FechaInicio) && !empty($FechaFin)) {
    $Venta = $Venta . "WHERE pr.fechaPelicula BETWEEN '$FechaInicio' AND '$FechaFin'";
  }

  $Venta = $Venta . "ORDER BY pr.fechaPelicula";

  $listaVentas = mysqli_query($db, $Venta);

  return $listaVentas;

}


function ListaRecaudacion($db, $FechaInicio = null, $FechaFin = null)
{

  $Recaudacion = "SELECT pe.IdPelicula,pe.titulo,pe.duracion,pe.categoria,pe.tipo,Sum(pr.precioFinal) AS Recaudado,Sum(CantBoleto) AS TotalBoleto, pe.habilitada FROM proyecciones AS pr INNER JOIN peliculas AS pe
ON pe.IdPelicula=pr.IdPelicula ";

  if ($FechaInicio != null && $FechaFin != null) {
    $Recaudacion = $Recaudacion . "WHERE pr.fechaPelicula BETWEEN '$FechaInicio' AND '$FechaFin'";
  }

  $Recaudacion = $Recaudacion . "Group by pe.titulo ORDER BY Recaudado desc";

  $listaRecaudacion = mysqli_query($db, $Recaudacion);

  return $listaRecaudacion;

}

function ListaBoletos($db, $FechaInicio = null, $FechaFin = null)
{

  $Boleto = "SELECT pe.IdPelicula,pe.titulo,pe.duracion,pe.categoria,pe.tipo,Sum(pr.precioFinal) AS Recaudado,Sum(CantBoleto) AS TotalBoleto, pe.habilitada FROM proyecciones AS pr INNER JOIN peliculas AS pe
ON pe.IdPelicula=pr.IdPelicula ";


  if ($FechaInicio != null && $FechaFin != null) {
    $Boleto = $Boleto . "WHERE pr.fechaPelicula BETWEEN '$FechaInicio' AND '$FechaFin'";
  }

  $Boleto = $Boleto . "Group by pe.titulo ORDER BY TotalBoleto desc";

  $listaBoleto = mysqli_query($db, $Boleto);

  return $listaBoleto;
}

function ComprobacionLogin($usuario, $contrasenia, $db)
{

  //Consulta a la base de datos para verificar que el usuario esta habilitado
  $sql = "SELECT IdUsuario,nombre,apellido,usuario,email,contraseña,habilitado,privilegio 
    FROM usuarios 
    WHERE habilitado like 'Si' AND
    usuario='$usuario' AND contraseña='$contrasenia'";

  $login = mysqli_query($db, $sql);

  $DatosUsuario = mysqli_fetch_assoc($login);

  if ($login = true && mysqli_num_rows($login) == 1) {

    $_SESSION['IdUsuario'] = $DatosUsuario["IdUsuario"];
    $_SESSION['NombreUsuario'] = $DatosUsuario["nombre"];
    $_SESSION['ApellidoUsuario'] = $DatosUsuario["apellido"];
    $_SESSION['Usuario'] = $DatosUsuario["usuario"];
    $_SESSION['EmailUsuario'] = $DatosUsuario["email"];
    $_SESSION['Privilegio'] = $DatosUsuario["privilegio"];

    if ($DatosUsuario["privilegio"] == "Usuario") {
      header("location:Cartelera.php");
    } elseif ($DatosUsuario["privilegio"] == "Administrador") {
      header("location:Peliculas.php");
    }

  } else {
    echo "<script> alert('Usuario No Encontrado'); </script>";
  }
}





?>