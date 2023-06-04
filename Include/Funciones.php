<?php

function Url($db){
  mysqli_query($db, "SET NAMES 'utf8'");
$_SESSION['url'] = 'http://' . $_SERVER['HTTP_HOST'] . "/GamesOfMovies";

}

function ListaUsuarios($db)
{

  $Usuarios = "SELECT * FROM usuarios WHERE privilegio LIKE 'Usuario'";

  $listaUsuarios = mysqli_query($db, $Usuarios);

  return $listaUsuarios;

}

function AccionUsuario($db, $habilitada = null, $noHabilitada = null, $idUsuario = null)
{

  if (!empty($habilitada)) {

    $sql = "UPDATE usuarios SET habilitado='$habilitada' WHERE idUsuario='$idUsuario'";

  } elseif (!empty($noHabilitada)) {

    $sql = "UPDATE usuarios SET habilitado='$noHabilitada' WHERE idUsuario='$idUsuario'";

  }

  mysqli_query($db, $sql);

  header("Location:InformeUsuarios.php");

}


function ListaPeliculas($db, $Valor=null, $txtID=null)
{

  if (!empty($txtID)) {
    $Peliculas= "SELECT * FROM peliculas WHERE IdPelicula='$txtID'";


  } else {

    if ($Valor == "RestriccionEdad") {
      $Peliculas = "SELECT restriccionEdad FROM peliculas
    GROUP BY restriccionEdad";
    } elseif ($Valor == "Tipo") {
      $Peliculas = "SELECT tipo FROM peliculas 
  GROUP BY tipo";
    } elseif ($Valor == "Lista" || empty($Valor)) {
      $Peliculas = "SELECT * FROM peliculas";
    }

  }

  $resultado = mysqli_query($db, $Peliculas);
  return $resultado;

}



function ListaProximasPeliculas($db, $Valor=null,$txtID=null){

  if (!empty($txtID)) {
    $ProximasPeliculas= "SELECT * FROM proximaspeliculas WHERE IdPelicula='$txtID'";
  } else {

  if ($Valor == "Titulo") {
    $ProximasPeliculas = "SELECT titulo FROM proximaspeliculas";
  } else {
    $ProximasPeliculas = "SELECT * FROM proximaspeliculas";
  }
}
  $resultado = mysqli_query($db, $ProximasPeliculas);

  return $resultado;

}

function AccionPelicula($db, $habilitada = null, $noHabilitada = null, $idPelicula = null, $IdProximasPelicula = null)
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