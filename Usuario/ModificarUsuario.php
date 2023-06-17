<?php

require_once "../Include/Conexion.php";
require_once "../Include/Funciones.php";
require_once "../Include/Cabecera.php";

//Variables a utilizar
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
$apellido = (isset($_POST['apellido'])) ? $_POST['apellido'] : "";
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : "";
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : "";
$email = (isset($_POST['email'])) ? $_POST['email'] : "";
$contrasenia = (isset($_POST['contrasenia'])) ? $_POST['contrasenia'] : "";


//En caso de selecionar el boton de registrar, luego se comprueba que ningun valor esta vacio ni nulo ni con espacios en blanco
if (isset($_POST['modificar'])) {
  if (
    isset($_POST["nombre"]) && !empty($_POST["nombre"]) &&
    isset($_POST["apellido"]) && !empty($_POST["apellido"]) &&
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
      ModificarUsuario($db,$nombre,$apellido,$usuario,$telefono,$email,$contrasenia);
    }
  } else {
    echo "<script> alert('No dejar cacillero/s vacio/s'); </script>";
  }

} elseif (isset($_POST['cancelar'])) {
  header("location:Cartelera.php");
}


?>

<!doctype html>
<html lang="en">

<head>
  <title>ModificarUsuario</title>
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
            Modificar Datos
          </div>
          <div class="card-body">
            <form action="ModificarUsuario.php" method="post">
              Nombre: <input class="form-control" value="<?php echo $_SESSION['NombreUsuario'] ?>" type="text" name="nombre" id="">

              Apellido: <input class="form-control" value="<?php echo $_SESSION['ApellidoUsuario'] ?>" type="text" name="apellido" id="">

              Usuario: <input class="form-control" value="<?php echo $_SESSION['Usuario'] ?>" type="text" name="usuario" id="">

              Telefono: <input class="form-control" value="<?php echo $_SESSION['Telefono']  ?>" type="number" name="telefono" id="">

              Email: <input class="form-control" value="<?php echo $_SESSION['EmailUsuario'] ?>" type="text" name="email" id="">


              Contraseña: <input class="form-control" value="<?php echo $contrasenia ?>" type="password" name="contrasenia" id="password">
                <button class="btn btn-link" type="button" onclick="mostrarContrasena()">Mostrar Contraseña</button>


              <br />
              <button class="btn btn-success" type="submit" name="modificar">Modificar</button>
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

<script>
  function mostrarContrasena(){
      $tipo = document.getElementById("password");
      if($tipo.type == "password"){
          $tipo.type = "text";
      }else{
          $tipo.type = "password";
      }
  }
</script> 

</html>