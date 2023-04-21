<?php
include 'Conexion.php';

//Variables a Utilizar
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : "";
$contrasenia = (isset($_POST['contrasenia'])) ? $_POST['contrasenia'] : "";

//En caso de seleccionar "Ingresar" verifica que las casillas no estan vacias ni tengan espacios
if (isset($_POST['ingresar'])) {
  if (isset($_POST["usuario"]) && !empty($_POST["usuario"]) && isset($_POST["contrasenia"]) && !empty($_POST["contrasenia"])) {
    //Consulta a la base de datos para verificar que el usuario esta habilitado
    $sentencia = $conexion->prepare("SELECT IdUsuario,usuario,contraseña,habilitado FROM usuarios where habilitado like 'Si'");
    $sentencia->execute();
    $ListaUsuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $ExisteUsuario = false;
    $usuario2 = "";
    $contrasenia2 = "";

    //Recorre los datos consultados anteriormente, verificando primero que los datos del usuario y la contrasenia correspondan con alguno
    //De la base de datos, caso afirmativo, pasa a traer y guardar en variables los datos del usuario y el Id
    foreach ($ListaUsuarios as $ListaUsuario) {
      $usuario2 = $ListaUsuario['usuario'];
      $contrasenia2 = $ListaUsuario['contraseña'];
      if ($usuario == $usuario2 && $contrasenia == $contrasenia2) {
        $ExisteUsuario = true;
      }
    }

    session_start();
    if ($ExisteUsuario == true) {
      $IdUsuario = $ListaUsuario['IdUsuario'];
      $_SESSION['estatus'] = "usuario";
      $_SESSION['Usuario'] = "" . $usuario;
      $_SESSION['IdUsuario'] = "" . $IdUsuario;
      header("location:Cartelera.php");
      //En caso que no se encuentre el usuario ni la contrasenia en la base de datos consultadas, se pregunta por un usuario y contrasenia
      //En particular, caso afirmativo se denota que es el administrador, el cual pasa a su correspondiente pagina
    } elseif (($_POST['usuario'] == "11") && ($_POST['contrasenia'] == "22")) {
      $_SESSION['estatus'] = "admin";
      header("location:Peliculas.php");
    } else {
      echo "<script> alert('Usuario No Encontrado'); </script>";
    }
  } else {
    echo "<script> alert('No dejar cacillero/s vacio/s'); </script>";
  }
  //En caso de seleccionar registrar, se redirige a la pagina correspondiente
} elseif (isset($_POST['registrar'])) {
  header("location:RegistrarUsuario.php");
}

?>
<!doctype html>
<html lang="en">

<head>
  <title>Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>

  <div class="container">
    <div class="row">
      <div class="col-md-4">
      </div>
      <div class="col-md-4">
        <br />
        <br />
        <br />
        <br />
        <br />
        <div class="card">
          <div class="card-header">
            Iniciar Sesion
          </div>
          <div class="card-body">
            <form action="Login.php" method="post">
              Usuario: <input class="form-control" value="<?php echo $usuario; ?>" type="text" name="usuario" id="">
              <br />
              Contraseña: <input class="form-control" value="<?php echo $contrasenia; ?>" type="password"
                name="contrasenia" id="">
              <br />
              <button class="btn btn-success" type="submit" name="ingresar">Ingresar</button>
              <button class="btn btn-success" type="submit" name="registrar">Registrar</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-4"> </div>
    </div>
  </div>
</body>

</html>