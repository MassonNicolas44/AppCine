<?php
include 'Conexion.php';

$usuario=(isset($_POST['usuario']))?$_POST['usuario']:"";
$contrasenia=(isset($_POST['contrasenia']))?$_POST['contrasenia']:"";

if (isset($_POST['ingresar'])){
  if(isset($_POST["usuario"]) && !empty($_POST["usuario"]) && isset($_POST["contrasenia"]) && !empty($_POST["contrasenia"])){

$sentencia=$conexion->prepare("SELECT usuario,contraseña,habilitado FROM usuarios where habilitado like 'Si'");
$sentencia->execute();
$ListaUsuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);

$ExisteUsuario=false;
$usuario2="";
$contrasenia2="";

//Comprobacion de que la pelicula que se quiere ingresar, no este ya cargada en la Base de Datos
foreach($ListaUsuarios as $ListaUsuario){
  
  $usuario2=$ListaUsuario['usuario'];
  $contrasenia2=$ListaUsuario['contraseña'];
  
  if ($usuario==$usuario2 && $contrasenia==$contrasenia2) {
    $ExisteUsuario=true;
      }
}

session_start();
if ($ExisteUsuario==true){
  $_SESSION['estatus']="usuario";
  $_SESSION['Usuario']="".$usuario;

  header("location:Cartelera.php");
}elseif (($_POST['usuario']=="11") && ($_POST['contrasenia']=="22") ){
  $_SESSION['estatus']="admin";
  header("location:Peliculas.php");

}else{
  echo "Usuario No Encontrado";
}
 }else{
  echo "<script> alert('No dejar cacillero/s vacio/s'); </script>";
 }

}elseif (isset($_POST['registrar'])){
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
    
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>

<div class="card">
  <div class="card-header">
    Iniciar Sesion
  </div>
  <div class="card-body">
  <form action="Login.php" method="post">
  Usuario: <input class="form-control" value="<?php echo $usuario;?>"  type="text" name="usuario" id="">
  <br/>
  Contraseña: <input class="form-control" value="<?php echo $contrasenia;?>" type="password" name="contrasenia" id="">
  <br/>
  <button class="btn btn-success" type="submit" name="ingresar">Ingresar</button>
  <button class="btn btn-success" type="submit" name="registrar">Registrar</button>
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