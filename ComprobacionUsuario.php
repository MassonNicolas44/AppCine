<?php

//PHP para realizar la carga de nuevo usuario a la base de datos
    include 'Conexion.php';
    $nombre=$_POST['nombre'];
    $usuario=$_POST['usuario'];
    $telefono=$_POST['telefono'];
    $email=$_POST['email'];
    $contraseña=$_POST['contraseña'];

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
?>	