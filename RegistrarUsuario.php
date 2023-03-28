<?php

//PHP para realizar la carga de nuevo usuario a la base de datos
    include 'Conexion.php';
    include 'bd.php';
    include 'Cabecera.php';
    
    $nombre="";
    $usuario="";
    $telefono="";
    $email="";
    $contrasenia="";

    if (isset($_POST['registrar'])){

      $nombre=(isset($_POST['nombre']))?$_POST['nombre']:"";
      $usuario=(isset($_POST['usuario']))?$_POST['usuario']:"";
      $telefono=(isset($_POST['telefono']))?$_POST['telefono']:"";
      $email=(isset($_POST['email']))?$_POST['email']:"";
      $contrasenia=(isset($_POST['contrasenia']))?$_POST['contrasenia']:"";


    $sentencia=$conexion->prepare("SELECT * FROM usuarios");
$sentencia->execute();
$ListaUsuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);

$ExisteUsuario=false;
$ExisteEmail=false;

$usuario2="";
$email2="";

//Comprobacion de que la pelicula que se quiere ingresar, no este ya cargada en la Base de Datos
foreach($ListaUsuarios as $ListaUsuario){
  
  $usuario2=$ListaUsuario['usuario'];
  $email2=$ListaUsuario['email'];
  
  if ($usuario==$usuario2) {
    $ExisteUsuario=true;
    }
    elseif ($email==$email2){
      $ExisteEmail=true;
    }
}

if ($ExisteUsuario==true){
  echo "Ya existe un Usuario con este nombre";
}elseif ($ExisteEmail==true){
  echo "Ya existe un Usuario con este email";
}elseif ($ExisteUsuario==false && $ExisteEmail==false){
  echo "Registro exitoso";
}
      //header("location:Login.php")}
    }elseif (isset($_POST['cancelar'])){
        header("location:Login.php");
      }

    
/*
    $usuario2;

    $sentencia=$mysql->prepare("SELECT usuario FROM usuarios WHERE usuario=?");
    $sentencia->bind_param('s',$usuario);
    $sentencia->execute();
    $sentencia->store_result();
    $sentencia->bind_result($usuario2);
    $response=array();

    while($sentencia->fetch()){
        $response["usuario"]=$usuario2;
    }

    if($usuario!=$usuario2){
        //Sentencia para insertar un nuevo usuario a la base de datos desde Android
        $query="INSERT INTO usuarios (nombre, usuario,telefono, email,contraseña)
        VALUES ('$nombre','$usuario','$telefono','$email','$contraseña')";
        $result = $mysql->query($query);
        $response["success"]=true;
    }else{
        $response["success"]=false;
    }

    echo json_encode($response);
    */
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

<div class="card">
  <div class="card-header">
    Registrar Usuario
  </div>
  <div class="card-body">
  <form action="RegistrarUsuario.php" method="post">
  Nombre: <input class="form-control" value ="<?php  echo $nombre ?>" type="text" name="nombre" id="">
  <br/>
  Usuario: <input class="form-control" value ="<?php  echo $usuario ?>" type="text" name="usuario" id="">
  <br/>
  Telefono: <input class="form-control" value ="<?php  echo $telefono ?>" type="text" name="telefono" id="">
  <br/>
  Email: <input class="form-control" value ="<?php  echo $email ?>" type="text" name="email" id="">
  <br/>
  Contraseña: <input class="form-control" value ="<?php  echo $contrasenia ?>" type="password" name="contrasenia" id="">
  <br/>
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
