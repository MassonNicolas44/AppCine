<?php

require_once "Include/Conexion.php";
require_once "Include/Funciones.php";

//Variables a utilizar
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : "";
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : "";
$email = (isset($_POST['email'])) ? $_POST['email'] : "";
$contrasenia = (isset($_POST['contrasenia'])) ? $_POST['contrasenia'] : "";

//En caso de selecionar el boton de registrar, luego se comprueba que ningun valor esta vacio ni nulo ni con espacios en blanco
if (isset($_POST['registrar'])) {
  if (
    isset($_POST["nombre"]) && !empty($_POST["nombre"]) &&
    isset($_POST["usuario"]) && !empty($_POST["usuario"]) &&
    isset($_POST["telefono"]) && !empty($_POST["telefono"]) &&
    isset($_POST["email"]) && !empty($_POST["email"]) &&
    isset($_POST["contrasenia"]) && !empty($_POST["contrasenia"])
  ) {

    //Recolecta todos los datos de la tabla usuarios
    $ListaUsuarios = ComprobacionUsuarioExiste($db,$usuario,$email);
    list($ExisteEmail,$ExisteUsuario)=ComprobacionUsuarioExiste($db,$usuario,$email);
    

    //En caso que exista el nombre de usuario y/o mail, mostrara un mensaje indicando que ya existe el usuario
    //Caso contrario se procede a insertar el usuario en la base de datos, con los datos correspondientes
    if ($ExisteUsuario == true) {
      echo "<script> alert('Ya existe un Usuario con este Nombre'); </script>";
    } elseif ($ExisteEmail == true) {
      echo "<script> alert('Ya existe un Usuario con este Email'); </script>";
    } elseif ($ExisteUsuario == false && $ExisteEmail == false) {
      //Sentencia para insertar un nuevo usuario a la base de datos desde Android
      RegistrarUsuario($db,$nombre,$usuario,$telefono,$email,$contrasenia);
    }
  } else {
    echo "<script> alert('No dejar cacillero/s vacio/s'); </script>";
  }

} elseif (isset($_POST['cancelar'])) {
  header("location:Login.php");
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

        <div class="card">
          <div class="card-header">
            Registrar Usuario
          </div>
          <div class="card-body">
            <form action="RegistrarUsuario.php" method="post">
              Nombre: <input class="form-control" value="<?php echo $nombre ?>" type="text" name="nombre" id="">
              <br />
              Usuario: <input class="form-control" value="<?php echo $usuario ?>" type="text" name="usuario" id="">
              <br />
              Telefono: <input class="form-control" value="<?php echo $telefono ?>" type="number" name="telefono" id="">
              <br />
              Email: <input class="form-control" value="<?php echo $email ?>" type="text" name="email" id="">
              <br />
              Contraseña: <input class="form-control" value="<?php echo $contrasenia ?>" type="password"
                name="contrasenia" id="">
              <br />
              <button class="btn btn-success" type="submit" name="registrar">Registrar</button>
              <button class="btn btn-success" type="submit" name="cancelar">Cancelar</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-4">
      </div>
    </div>
  </div>
</body>

</html>