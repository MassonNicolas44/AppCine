<?php

require_once "Include/Conexion.php";
require_once "Include/Funciones.php";

session_start();

$errores=array();

//Variables a utilizar
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
$apellido = (isset($_POST['apellido'])) ? $_POST['apellido'] : "";
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : "";
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : "";
$email = (isset($_POST['email'])) ? $_POST['email'] : "";
$contrasenia = (isset($_POST['contrasenia'])) ? $_POST['contrasenia'] : "";

//En caso de selecionar el boton de registrar, luego se comprueba que ningun valor esta vacio ni nulo ni con espacios en blanco
if (isset($_POST['registrar'])) {

  if (empty(trim($nombre))){ 
    $errores['nombre']="Nombre vacio";
  }

  if (empty(trim($apellido))){ 
    $errores['apellido']="Apellido vacio";
  }

  if (empty(trim($usuario))){ 
    $errores['usuario']="Usuario vacio";
  }

  if (empty(trim($telefono))){ 
    $errores['telefono']="Telefono vacio";
  }

  if (empty(trim($email))){ 
    $errores['email']="Email vacio";
  }

  if (empty(trim($contrasenia))){ 
    $errores['contrasenia']="Contrasenia vacio";
  }

  if (count($errores)==0){

    //Recolecta todos los datos de la tabla usuarios
    $ListaUsuarios = ComprobacionUsuarioExiste($db,$usuario,$email);
    $errores2=ComprobacionUsuarioExiste($db,$usuario,$email);
    
    if (count($errores2)==0){

      RegistrarUsuario($db,$nombre,$apellido,$usuario,$telefono,$email,$contrasenia);

    }else{
      $_SESSION['errores']=$errores2;
    }

  }else{
    $_SESSION['errores']=$errores;
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

              <?php echo isset($_SESSION['errores']) ? MostrarErrores($_SESSION['errores'],'nombre') : '' ;?>

              Apellido: <input class="form-control" value="<?php echo $apellido ?>" type="text" name="apellido" id="">

              <?php echo isset($_SESSION['errores']) ? MostrarErrores($_SESSION['errores'],'apellido') : '' ;?>

              Usuario: <input class="form-control" value="<?php echo $usuario ?>" type="text" name="usuario" id="">

              <?php echo isset($_SESSION['errores']) ? MostrarErrores($_SESSION['errores'],'usuario') : '' ;?>

              Telefono: <input class="form-control" value="<?php echo $telefono ?>" type="number" name="telefono" id="">

              <?php echo isset($_SESSION['errores']) ? MostrarErrores($_SESSION['errores'],'telefono') : '' ;?>

              Email: <input class="form-control" value="<?php echo $email ?>" type="text" name="email" id="">

              <?php echo isset($_SESSION['errores']) ? MostrarErrores($_SESSION['errores'],'email') : '' ;?>

              Contraseña: <input class="form-control" value="<?php echo $contrasenia ?>" type="password" name="contrasenia" id="password">
                <button class="btn btn-link" type="button" onclick="mostrarContrasena()">Mostrar Contraseña</button>

                <?php echo isset($_SESSION['errores']) ? MostrarErrores($_SESSION['errores'],'contrasenia') : '' ;?>

                <?php echo !empty($errores2) ? MostrarErrores($_SESSION['errores'],'ExisteUsuario') : '' ;?>
                <?php echo !empty($errores2) ? MostrarErrores($_SESSION['errores'],'ExisteEmail') : '' ;?>

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

<?php BorrarErrores(); ?>

</html>