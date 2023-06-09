<?php

//******************************          URL           ************************************ */

//Funcion para Recopilar la Url de la pagina
function Url($db)
{
  mysqli_query($db, "SET NAMES 'utf8'");
  $_SESSION['url'] = 'http://' . $_SERVER['HTTP_HOST'] . "/GamesOfMovies";

}


//**********************        Insertar una nueva Pelicula/ProximaPelicula en la Base de Datos       ************************** */

//Funcion para Insertar una Nueva Pelicula/Proxima Pelicula
function InsertarNuevaPelicula($db, $Valor = null, $Titulo, $Duracion, $RestriccionEdad, $Categoria, $Tipo, $Precio=null, $Descripcion=null,  $Imagen, $Fecha=null)
{

  if ($Valor == "ProximasPeliculas") {

    //Sentencia para Insertar una nueva ProximaPelicula a la Base de Datos
    $sql = "INSERT INTO proximaspeliculas(titulo, duracion, restriccionEdad, categoria, tipo, imgResource,fechaEstreno,habilitada) 
    VALUES('$Titulo','$Duracion','$RestriccionEdad','$Categoria','$Tipo','$Imagen','$Fecha','Si')";

  } elseif ($Valor == "Peliculas") {

        //Sentencia para Insertar una nueva Pelicula a la Base de Datos
    $sql = "INSERT INTO peliculas(titulo, duracion, restriccionEdad, categoria, tipo, precio, descripcion, imgResource, habilitada) 
    VALUES('$Titulo','$Duracion','$RestriccionEdad','$Categoria','$Tipo','$Precio','$Descripcion','$Imagen','Si')";

  }

  //Ejecucion de la Sentencia Anterior 
  mysqli_query($db, $sql);

}



//******************************          Modificar Pelicula          ************************************ */

//Funcion para Modificar una Pelicula/Proxima Pelicula
function ModificarPelicula($db, $Valor = null, $Titulo, $Duracion, $RestriccionEdad, $Categoria, $Tipo, $Precio=null, $Descripcion=null,  $Imagen=null, $Fecha=null,$IdPelicula)
{

  if ($Valor == "ProximasPeliculas") {

    //Sentencia para Modificar ProximaPelicula en la Base de Datos
    $sql = "UPDATE proximaspeliculas SET titulo='$Titulo', duracion='$Duracion', 
    restriccionEdad='$RestriccionEdad', categoria='$Categoria', tipo='$Tipo' ";
    if (!empty($Imagen)){
      //Sentencia para Modificar Pelicula MODIFICANDO IMAGEN en la Base de Datos
      $sql=$sql.",imgResource='$Imagen '";
    }
    $sql=$sql.",fechaEstreno='$Fecha' WHERE IdPelicula='$IdPelicula'";
    

  } elseif ($Valor == "Peliculas") {

    //Sentencia para Modificar Pelicula MODIFICANDO IMAGEN en la Base de Datos
    $sql = "UPDATE peliculas SET titulo='$Titulo', duracion='$Duracion', restriccionEdad='$RestriccionEdad', 
    categoria='$Categoria', tipo='$Tipo', precio='$Precio', descripcion='$Descripcion' ";
    if (!empty($Imagen)){
      //Sentencia para Modificar Pelicula MODIFICANDO IMAGEN en la Base de Datos
      $sql=$sql.",imgResource='$Imagen'";
    }
    $sql=$sql."WHERE IdPelicula='$IdPelicula'";

  }

  //Ejecucion de la Sentencia Anterior 
  mysqli_query($db, $sql);

}


//******************************          Eliminar Proxima Pelicula al Pasar a Cartelera          ************************************ */

//Funcion para eliminar al pelicula luego de pasar a ProximaPelicula
function EliminarProximaPelicula($db,$IdPelicula){

$sql="DELETE from proximaspeliculas WHERE IdPelicula='$IdPelicula'";

mysqli_query($db,$sql);

}

//******************************          Lista de Usuarios          ************************************ */

//Funcion para Traer la Lista de Usuarios
function ListaUsuarios($db)
{

  //Sentencia para seleccionar todos los Usuarios que tengan privilegio de solo "Usuario"
  $Usuarios = "SELECT * FROM usuarios WHERE privilegio LIKE 'Usuario'";

  //Ejecucion de la Sentencia Anterior 
  $listaUsuarios = mysqli_query($db, $Usuarios);

  //Devuelve la Lista de Usuarios
  return $listaUsuarios;

}



//******************************          Lista de Peliculas          ************************************ */

//Funcion para Traer la Lista de Peliculas
function ListaPeliculas($db, $Valor = null, $txtID = null, $Titulo = null)
{

  //Condicional para cuando el Id de la Pelicula no sea Nulo
  if (!empty($txtID)) {

    if ($Valor=="Habilitada"){
      $Peliculas="SELECT * FROM peliculas WHERE habilitada like 'Si' And IdPelicula=$txtID";
    }else{
          //Sentencia para seleccionar la Pelicula que tenga el mismo Id que se paso por parametro
    $Peliculas = "SELECT * FROM peliculas WHERE IdPelicula='$txtID'";
    }

  } else {

    //Caso en el cual se quiere seleccionar solo la Restriccion de Edad (Agrupandolas) de la Lista de Peliculas
    if ($Valor == "RestriccionEdad") {
      $Peliculas = "SELECT restriccionEdad FROM peliculas GROUP BY restriccionEdad";

    //Caso en el cual se quiere seleccionar solo el Tipo (Agrupandolas) de la Lista de Peliculas
    } elseif ($Valor == "Tipo") {
      $Peliculas = "SELECT tipo FROM peliculas GROUP BY tipo";

    //Caso en el cual se quiere seleccionar todos los datos de cada Pelicula de la Base de Datos
    } elseif ($Valor == "Lista" || empty($Valor)) {
      $Peliculas = "SELECT * FROM peliculas";

    //Caso en el cual se quiere seleccionar solo el Titulo (Agrupandolas) de la Lista de Peliculas
    } elseif ($Valor == "Titulo") {
      $Peliculas = "SELECT titulo FROM peliculas";

      //Caso en el cual se quiere seleccionar solo las Peliculas habilitadas
    }elseif ($Valor == "Habilitada") {
      $Peliculas = "SELECT * FROM peliculas WHERE habilitada like 'Si'";
    }
  }

  //Ejecucion de la Sentencia Anterior 
  $resultado = mysqli_query($db, $Peliculas);

  //En caso que la sentencia a ejecutarse sea traer solo el Titulo
  if ($Valor == "Titulo") {
    $txtTitulo2 = "";
    $ExistePelicula = false;

    //Comprobacion de que la pelicula que se quiere ingresar, no este ya cargada en la Base de Datos
    foreach ($resultado as $NuevoTitulo) {
      $txtTitulo2 = $NuevoTitulo['titulo'];

      //Comparacion entre el Titulo a ingresar y cada titulo que existe en la Base de Datos
      if ($Titulo == $txtTitulo2) {
        $ExistePelicula = true;
      }
    }

    //Devolucion de si ya existe la pelicula en la Base de Datos
    return $ExistePelicula;

  } else {

    //Devolucion de las Sentencias anteriores
    return $resultado;
  }
}



//******************************          Lista de Proximas Peliculas          ************************************ */

function ListaProximasPeliculas($db, $Valor = null, $txtID = null, $Titulo = null){

  //Condicional para cuando el Id de la ProximaPelicula no sea Nulo
  if (!empty($txtID)) {
    $ProximasPeliculas = "SELECT * FROM proximaspeliculas WHERE IdPelicula='$txtID'";
  } else {

    //Caso en el cual se quiere seleccionar solo el Titulo (Agrupandolas) de la Lista de Proximas Peliculas
    if ($Valor == "Titulo") {

      $ProximasPeliculas = "SELECT titulo FROM proximaspeliculas";

    } if ($Valor == "Habilitada") {

      $ProximasPeliculas = "SELECT * FROM proximaspeliculas WHERE habilitada LIKE 'Si'";

    }else {

      $ProximasPeliculas = "SELECT * FROM proximaspeliculas";
    }
  }

  //Ejecucion de la Sentencia Anterior
  $resultado = mysqli_query($db, $ProximasPeliculas);

  //En caso que la sentencia a ejecutarse sea traer solo el Titulo
  if ($Valor == "Titulo") {
    $txtTitulo2 = "";
    $ExistePelicula = false;

    //Comprobacion de que la pelicula que se quiere ingresar, no este ya cargada en la Base de Datos
    foreach ($resultado as $NuevoTitulo) {
      $txtTitulo2 = $NuevoTitulo['titulo'];

      //Comparacion entre el Titulo a ingresar y cada titulo que existe en la Base de Datos
      if ($Titulo == $txtTitulo2) {
        $ExistePelicula = true;
      }
    }

    //Devolucion de si ya existe la pelicula en la Base de Datos
    return $ExistePelicula;

  } else {

    //Devolucion de las Sentencias anteriores
    return $resultado;
  }


}


//********************      Habilitar o No, Pelicula y ProximasPeliculas para la Cartelera y Proximas     ************************* */

//Funcion para Habiltiar o No Habilitar Peliculas o Proximas Peliculas para que se puedan ver en la Pagina Web
function AccionPelicula($db, $habilitada = null, $noHabilitada = null, $idPelicula = null, $IdProximasPelicula = null){

  //En caso que se quiera habilitar la Pelicula seleccionada
  if (!empty($habilitada) && (!empty($idPelicula))) {

    $sql = "UPDATE peliculas SET habilitada='$habilitada' WHERE idPelicula='$idPelicula'";

      //En caso que no se quiera habilitar la Pelicula seleccionada
  } elseif (!empty($noHabilitada) && (!empty($idPelicula))) {

    $sql = "UPDATE peliculas SET habilitada='$noHabilitada' WHERE idPelicula='$idPelicula'";

  //En caso que se quiera habilitar la ProximaPelicula seleccionada
  } elseif (!empty($habilitada) && (!empty($IdProximasPelicula))) {

    $sql = "UPDATE proximaspeliculas SET habilitada='$habilitada' WHERE idPelicula='$IdProximasPelicula'";

      //En caso que no se quiera habilitar la ProximaPelicula seleccionada
  } elseif (!empty($noHabilitada) && (!empty($IdProximasPelicula))) {

    $sql = "UPDATE proximaspeliculas SET habilitada='$noHabilitada' WHERE idPelicula='$IdProximasPelicula'";
  }

  //Ejecutar la sentencia anterior
  mysqli_query($db, $sql);

}


//************************          Habilitar o No, a usuario para Ingresar a la Pagina Web         ****************************** */

//Funcion para Habiltiar o No Habilitar Usuarios para que pueda ingresar a la Pagina Web
function AccionUsuario($db, $habilitada = null, $noHabilitada = null, $idUsuario = null){

  //En caso que se quiera Habilitar el Usuario
  if (!empty($habilitada)) {

    //Sentencia para actualizar la tabla de Usuarios
    $sql = "UPDATE usuarios SET habilitado='$habilitada' WHERE idUsuario='$idUsuario'";

      //En caso que no se quiera Habilitar el Usuario
  } elseif (!empty($noHabilitada)) {

    //Sentencia para actualizar la tabla de Usuarios
    $sql = "UPDATE usuarios SET habilitado='$noHabilitada' WHERE idUsuario='$idUsuario'";

  }

  //Ejecutar la sentencia anterior
  mysqli_query($db, $sql);

  //Recarga la misma pagina
  header("Location:Administrador/InformeUsuarios.php");

}


//*********************************          Datos de una Reserva del Usuario Logeado       ****************************************** */

function DatosReserva($db,$Fecha,$Hora,$IdPelicula){

  $sql="SELECT Sum(pr.CantBoleto) AS Disponibilidad,pr.fechaPelicula,pr.horaPelicula,pe.IdPelicula 
  FROM proyecciones AS pr 
  INNER JOIN peliculas AS pe ON pe.IdPelicula=pr.IdPelicula 
  WHERE pr.fechaPelicula='$Fecha' AND pr.horaPelicula='$Hora' AND pe.IdPelicula=$IdPelicula";

  $resultado=mysqli_query($db,$sql);

  return $resultado;

}


//*********************************            Anular Reserva de Boletos           ****************************************** */

function AnularBoleto($db,$NombreUsuario=null,$Valor=null,$IdVenta=null){
  
  if ($Valor =="Lista"){
    $sql="SELECT pr.IdVenta,us.IdUsuario,us.usuario,us.nombre,us.apellido,pe.titulo,pr.fechaPelicula,pr.horaPelicula,pr.CantBoleto, pr.precioFinal, pr.Anulada
    FROM proyecciones AS pr 
    INNER JOIN peliculas AS pe ON pe.IdPelicula=pr.IdPelicula
    INNER JOIN usuarios AS us ON pr.IdUsuario =us.IdUsuario
    WHERE us.usuario LIKE '$NombreUsuario' AND pr.Anulada LIKE 'No'
    ORDER BY pr.fechaPelicula";

    $resultado=mysqli_query($db, $sql);

    return $resultado;

  }elseif ($Valor == "AnularVenta"){

$sql= "UPDATE proyecciones SET Anulada='Si' WHERE IdVenta='$IdVenta'";

$resultado=mysqli_query($db, $sql);

header("Location:Usuario/AnularBoleto.php");

  }

}



//*********************************            Lista de Ventas           ****************************************** */

//Funcion para seleccionar la Lista de Ventas
function ListaVentas($db, $FechaInicio = null, $FechaFin = null){

     //Sentencia para seleccionar los datos que van a ser mostrados en el Informe y/o para Imprimir el Informe
    $Venta = "SELECT us.IdUsuario,us.usuario,pe.titulo,pr.fechaPelicula,pr.horaPelicula,pr.CantBoleto, pr.precioFinal, pr.Anulada
    FROM proyecciones AS pr 
    INNER JOIN peliculas AS pe ON pe.IdPelicula=pr.IdPelicula
    INNER JOIN usuarios AS us ON pr.IdUsuario =us.IdUsuario
    WHERE pr.Anulada LIKE 'No' ";

  //En caso que tenga un filtrado de fecha, se agrega a la sentencia anterior
  if (!empty($FechaInicio) && !empty($FechaFin)) {
    $Venta = $Venta . "AND pr.fechaPelicula BETWEEN '$FechaInicio' AND '$FechaFin'";
  }

  $Venta = $Venta . " ORDER BY pr.fechaPelicula";

      //Ejecucion de la Sentencia anterior
  $listaVentas = mysqli_query($db, $Venta);

   //Se devuelve la Lista de los Ventas
  return $listaVentas;

}



//*********************************            Lista de Recaudacion           ****************************************** */

//Funcion para seleccionar la Lista de Recaudacion
function ListaRecaudacion($db, $FechaInicio = null, $FechaFin = null){

   //Sentencia para seleccionar los datos que van a ser mostrados en el Informe y/o para Imprimir el Informe
  $Recaudacion = "SELECT pe.IdPelicula,pe.titulo,pe.duracion,pe.categoria,pe.tipo,Sum(pr.precioFinal) AS Recaudado,Sum(CantBoleto) AS TotalBoleto, pe.habilitada 
  FROM proyecciones AS pr 
  INNER JOIN peliculas AS pe
  ON pe.IdPelicula=pr.IdPelicula
  WHERE pr.Anulada LIKE 'No' ";

  //En caso que tenga un filtrado de fecha, se agrega a la sentencia anterior
  if ($FechaInicio != null && $FechaFin != null) {
    $Recaudacion = $Recaudacion . "AND pr.fechaPelicula BETWEEN '$FechaInicio' AND '$FechaFin'";
  }

  $Recaudacion = $Recaudacion . "Group by pe.titulo ORDER BY Recaudado desc";

    //Ejecucion de la Sentencia anterior
  $listaRecaudacion = mysqli_query($db, $Recaudacion);

   //Se devuelve la Lista de Recaudacion
  return $listaRecaudacion;

}



//*********************************            Lista de Boletos           ****************************************** */

//Funcion para seleccionar la Lista de Boletos Vendidos
function ListaBoletos($db, $FechaInicio = null, $FechaFin = null){

  //Sentencia para seleccionar los datos que van a ser mostrados en el Informe y/o para Imprimir el Informe
  $Boleto = "SELECT pe.IdPelicula,pe.titulo,pe.duracion,pe.categoria,pe.tipo,Sum(pr.precioFinal) AS Recaudado,Sum(CantBoleto) AS TotalBoleto, pe.habilitada 
  FROM proyecciones AS pr 
  INNER JOIN peliculas AS pe
  ON pe.IdPelicula=pr.IdPelicula
  WHERE pr.Anulada LIKE 'No' ";

  //En caso que tenga un filtrado de fecha, se agrega a la sentencia anterior
  if ($FechaInicio != null && $FechaFin != null) {
    $Boleto = $Boleto . "AND pr.fechaPelicula BETWEEN '$FechaInicio' AND '$FechaFin'";
  }

  $Boleto = $Boleto . "Group by pe.titulo ORDER BY TotalBoleto desc";

  //Ejecucion de la Sentencia anterior
  $listaBoleto = mysqli_query($db, $Boleto);

  //Se devuelve la Lista de los Boletos
  return $listaBoleto;
}





//*********************************            Comprobaciones al Inicio de Sesion           ****************************************** */

//Funcion para comprobar si existen los datos ingresados dentro de la Base de Datos
function ComprobacionLogin($usuario, $contrasenia, $db){

  //Sentencia para seleccionar todos los datos de la tabla Usuarios de la base de datos para verificar que el usuario esta habilitado
  $sql = "SELECT * FROM usuarios 
    WHERE habilitado like 'Si' AND
    usuario='$usuario' AND contraseña='$contrasenia'";

  //Ejecucion de la Sentencia anterior
  $login = mysqli_query($db, $sql);

  $DatosUsuario = mysqli_fetch_assoc($login);

  //En caso que se encuentren los datos ingresados dentro de la base de Datos y exista 1 solo. Se procede a guardar los datos en las Sessiones
  if ($login = true && mysqli_num_rows($login) == 1) {

    $_SESSION['IdUsuario'] = $DatosUsuario["IdUsuario"];
    $_SESSION['NombreUsuario'] = $DatosUsuario["nombre"];
    $_SESSION['ApellidoUsuario'] = $DatosUsuario["apellido"];
    $_SESSION['Usuario'] = $DatosUsuario["usuario"];
    $_SESSION['EmailUsuario'] = $DatosUsuario["email"];
    $_SESSION['Privilegio'] = $DatosUsuario["privilegio"];

    //Si el Usuario tiene Privilegio de Usuario se pasa a la Pagina y Cabecera que Corresponda
    if ($DatosUsuario["privilegio"] == "Usuario") {
      header("location:Usuario/Cartelera.php");

    //Si el Usuario tiene Privilegio de Administrador se pasa a la Pagina y Cabecera que Corresponda
    } elseif ($DatosUsuario["privilegio"] == "Administrador") {
      header("location:Administrador/Peliculas.php");
    }

    //Si no se encuentra el usuario ingresado con todos los usuarios dentro de la base de Datos, se indica un mensaje
  } else {
    echo "<script> alert('Usuario No Encontrado'); </script>";
  }
}



//****************************        Comprobaciones si Existe Usuario en la Base de Datos      ************************************ */

//Funcion para comprobar si el usuario ya esta registrado dentro de la base de datos, tanto el nombre de Usuario como el Email
function ComprobacionUsuarioExiste($db,$usuario,$email){

  //Sentencia para seleccionar todos los datos de la tabla Usuarios de la base de datos para verificar que el usuario esta habilitado
  $sql = "SELECT * FROM usuarios";

  //Ejecucion de la Sentencia anterior
  $ListaUsuarios = mysqli_query($db, $sql);

    //Inicio de variables
    $ExisteUsuario = false;
    $ExisteEmail = false;

    //Recorre todos los datos recolectados anteriormente, para luego consultar si ya existe el nombre de usuario y luego el mail
    foreach ($ListaUsuarios as $ListaUsuario) {

      $usuario2 = $ListaUsuario['usuario'];
      $email2 = $ListaUsuario['email'];

      if ($usuario == $usuario2) {
        $ExisteUsuario = true;
      } elseif ($email == $email2) {
        $ExisteEmail = true;
      }
    }

    return [$ExisteEmail, $ExisteUsuario];

  }




//*********************************          Registrar Usuario en la Base de Datos         ****************************************** */

  //Funcion para Registrar un Usuario en la Base de Datos
  function RegistrarUsuario($db,$nombre,$usuario,$telefono,$email,$contrasenia){

    //Sentencia para realizar el registro
    $sql = "INSERT INTO usuarios(nombre, usuario,telefono, email,contraseña,habilitado,privilegio)
    VALUES ('$nombre','$usuario','$telefono','$email','$contrasenia','Si','Usuario')";
        
    //Ejecucion de la sentencia anterior
    mysqli_query($db,$sql);

    //Envio a la pagina del login
    header("location:Login.php");
  }



  
  //*********************************            Registrar Reserva de Boleto           ****************************************** */

    //Funcion para Registrar un Usuario en la Base de Datos
    function RegistrarBoleto($db,$IdPelicula,$IdUsuario,$fechaPelicula,$horaPelicula,$CantidadBoleto,$PrecioFinal){

      //Sentencia para realizar el registro
      $sql = "INSERT INTO proyecciones (IdPelicula, IdUsuario, fechaPelicula,horaPelicula,CantBoleto,precioFinal,Anulada) 
      VALUES ('$IdPelicula','$IdUsuario','$fechaPelicula','$horaPelicula','$CantidadBoleto','$PrecioFinal','No')";
          
      //Ejecucion de la sentencia anterior
      mysqli_query($db,$sql);
  
      //Envio a la pagina de la Cartelera
      header("location:Cartelera.php");
    }


    
?>