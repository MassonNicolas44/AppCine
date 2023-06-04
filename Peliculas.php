<!-- Pagina -->
<?php

require_once "Include/Conexion.php";
require_once "Include/Funciones.php";
require_once "Include/Cabecera.php";

//Declaracion de variables para luego ser utilizadas en distintos procesos

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtTitulo = (isset($_POST['txtTitulo'])) ? $_POST['txtTitulo'] : "";
$txtDuracion = (isset($_POST['txtDuracion'])) ? $_POST['txtDuracion'] : "";
$txtrestriccionEdad = (isset($_POST['txtrestriccionEdad'])) ? $_POST['txtrestriccionEdad'] : "";
$txtCategoria = (isset($_POST['txtCategoria'])) ? $_POST['txtCategoria'] : "";
$txtPrecio = (isset($_POST['txtPrecio'])) ? $_POST['txtPrecio'] : "";
$txtDescripcion = (isset($_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : "";
$txtTipo = (isset($_POST['txtTipo'])) ? $_POST['txtTipo'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$txtFecha = (isset($_POST['txtFecha'])) ? $_POST['txtFecha'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";


$validarPelicula = false;
$txtTitulo2 = "";
$validarModificar = "Inicio";
$Habilitacion = "Si";
$anularHabilitacion = "No";
$restriccionEdad = "";

//Conexion a base de datos

//Switch de opciones para pagina web
switch ($accion) {

    case "Agregar":
        //En caso de agregar una pelicula y esta tildada para agregar a cartelera, se agregara como se indica. En caso contrario, se agrega en 'proximaspeliculas'
        if (isset($_POST["cartelera"])) {
            //Comprobacion de que los campos no estan vacios
            if (
                !empty($txtTitulo) && !empty($txtDuracion) && !empty($txtrestriccionEdad) && !empty($txtCategoria) && !empty($txtTipo) &&
                !empty($txtFecha)
            ) {
                $sentencia = $conexion->prepare("SELECT titulo FROM proximaspeliculas");
                $sentencia->execute();
                $peliculas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                //Comprobacion de que la pelicula que se quiere ingresar, no este ya cargada en la Base de Datos
                foreach ($peliculas as $pelicula) {
                    $txtTitulo2 = $pelicula['titulo'];
                    if ($txtTitulo == $txtTitulo2) {
                        $validarPelicula = true;
                    }
                }
                if ($validarPelicula == true) {
                    echo "<script> alert('Pelicula existe'); </script>";
                } else {
                    //Sentencia para cargar la pelicula en la tabla "proximasPeliculas"
                    $sentenciaSQL = $conexion->prepare("INSERT INTO proximaspeliculas(titulo, duracion, restriccionEdad, 
                        categoria, tipo, imgResource,fechaEstreno,habilitadaProximaPelicula) VALUES (:titulo,:duracion,:restriccion,:categoria,:tipo,:imgResource,:fechaEstreno,:habilitadaProximaPelicula);");
                    $sentenciaSQL->bindParam(':titulo', $txtTitulo);
                    $sentenciaSQL->bindParam(':duracion', $txtDuracion);
                    $sentenciaSQL->bindParam(':restriccion', $txtrestriccionEdad);
                    $sentenciaSQL->bindParam(':categoria', $txtCategoria);
                    $sentenciaSQL->bindParam(':tipo', $txtTipo);
                    //En caso de no seleccionar ninguna imagen, se coloca una pre establecida
                    if ($txtImagen != "") {
                        $nombreArchivo = $_FILES["txtImagen"]["name"];
                        $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
                        move_uploaded_file($tmpImagen, "../../../GamesOfMovies/img/" . $nombreArchivo);
                    } else {
                        $txtImagen = "NoImagen.jpeg";
                        $nombreArchivo = "NoImagen.jpeg";
                    }
                    $sentenciaSQL->bindParam(':imgResource', $nombreArchivo);
                    $sentenciaSQL->bindParam(':fechaEstreno', $txtFecha);
                    $sentenciaSQL->bindParam(':habilitadaProximaPelicula', $Habilitacion);
                    $sentenciaSQL->execute();

                    header("Location:Peliculas.php");
                }
            } else {
                echo "<script> alert('Complete Titulo-Duracion-Restriccion-Categoria-Tipo y/o Fecha Estreno'); </script>";
            }
        } else {
            //Comprobacion de que los campos no estan vacios
            if (
                !empty($txtTitulo) && !empty($txtDuracion) && !empty($txtrestriccionEdad) && !empty($txtCategoria) && !empty($txtTipo) &&
                !empty($txtPrecio) && !empty($txtDescripcion)
            ) {

                $sentencia = $conexion->prepare("SELECT titulo FROM peliculas");
                $sentencia->execute();
                $peliculas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                //Comprobacion de que la pelicula que se quiere ingresar, no este ya cargada en la Base de Datos
                foreach ($peliculas as $pelicula) {
                    $txtTitulo2 = $pelicula['titulo'];
                    if ($txtTitulo == $txtTitulo2) {
                        $validarPelicula = true;
                    }
                }
                if ($validarPelicula == true) {
                    echo "<script> alert('Pelicula existe'); </script>";
                } else {
                    //Sentencia para cargar la pelicula en la tabla "Peliculas"
                    $sentenciaSQL = $conexion->prepare("INSERT INTO peliculas(titulo, duracion, restriccionEdad, categoria, tipo, precio,descripcion, imgResource,habilitacion) VALUES (:titulo,:duracion,:restriccion,:categoria,:tipo,:precio,:descripcion,:imgResource,:habilitacion);");
                    $sentenciaSQL->bindParam(':titulo', $txtTitulo);
                    $sentenciaSQL->bindParam(':duracion', $txtDuracion);
                    $sentenciaSQL->bindParam(':restriccion', $txtrestriccionEdad);
                    $sentenciaSQL->bindParam(':categoria', $txtCategoria);
                    $sentenciaSQL->bindParam(':tipo', $txtTipo);
                    $sentenciaSQL->bindParam(':precio', $txtPrecio);
                    $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
                    //En caso de no seleccionar ninguna imagen, se coloca una pre establecida
                    if ($txtImagen != "") {
                        $nombreArchivo = $_FILES["txtImagen"]["name"];
                        $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
                        move_uploaded_file($tmpImagen, "../../../GamesOfMovies/img/" . $nombreArchivo);
                    } else {
                        $txtImagen = "NoImagen.jpeg";
                        $nombreArchivo = "NoImagen.jpeg";
                    }
                    $sentenciaSQL->bindParam(':imgResource', $nombreArchivo);
                    $sentenciaSQL->bindParam(':habilitacion', $Habilitacion);
                    $sentenciaSQL->execute();

                    header("Location:Peliculas.php");
                }
            } else {
                echo "<script> alert('Complete Titulo-Duracion-Restriccion-Categoria-Tipo-Precio y/o Descripcion'); </script>";
            }
        }

        break;

    case "ModificarSeleccionar":

        //Comprobacion de que los campos no estan vacios
        if (
            !empty($txtTitulo) && !empty($txtDuracion) && !empty($txtrestriccionEdad) && !empty($txtCategoria) && !empty($txtTipo) &&
            !empty($txtPrecio) && !empty($txtDescripcion)
        ) {

            //Sentencia para actualizar registros con respecto a la tabla peliculas
            $sentenciaSQL = $conexion->prepare("UPDATE peliculas SET titulo=:titulo, duracion=:duracion, 
                    restriccionEdad=:restriccionEdad, categoria=:categoria, tipo=:tipo, precio=:precio, descripcion=:descripcion  
                    WHERE IdPelicula=:IdPelicula");
            $sentenciaSQL->bindParam(':IdPelicula', $txtID);
            $sentenciaSQL->bindParam(':titulo', $txtTitulo);
            $sentenciaSQL->bindParam(':duracion', $txtDuracion);
            $sentenciaSQL->bindParam(':restriccionEdad', $txtrestriccionEdad);
            $sentenciaSQL->bindParam(':categoria', $txtCategoria);
            $sentenciaSQL->bindParam(':tipo', $txtTipo);
            $sentenciaSQL->bindParam(':precio', $txtPrecio);
            $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
            $sentenciaSQL->execute();

            //En caso de no modificar la imagen, no se modifica
            if ($txtImagen !== "") {
                $nombreArchivo = $_FILES["txtImagen"]["name"];
                $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
                move_uploaded_file($tmpImagen, "../../../GamesOfMovies/img/" . $nombreArchivo);
                $sentenciaSQL = $conexion->prepare("SELECT imgResource FROM peliculas WHERE IdPelicula=:IdPelicula");
                $sentenciaSQL->bindParam(':IdPelicula', $txtID);
                $sentenciaSQL->execute();
                $peliculas = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
                $sentenciaSQL = $conexion->prepare("UPDATE peliculas SET imgResource=:imgResource WHERE IdPelicula=:IdPelicula");
                $sentenciaSQL->bindParam(':imgResource', $nombreArchivo);
                $sentenciaSQL->bindParam(':IdPelicula', $txtID);
                $sentenciaSQL->execute();
            }
            header("Location:Peliculas.php");
        } else {
            $validarModificar = "Seleccionar";
            echo "<script> alert('Complete Titulo-Duracion-Restriccion-Categoria-Tipo-Precio y/o Descripcion'); </script>";
        }

        break;


    case "ModificarSeleccionarProximaPelicula":
        //Comprobacion de que los campos no estan vacios
        if (
            !empty($txtTitulo) && !empty($txtDuracion) && !empty($txtrestriccionEdad) && !empty($txtCategoria) && !empty($txtTipo) &&
            !empty($txtFecha)
        ) {

            //Sentencia para actualizar registros con respecto a la tabla proximasPeliculas
            $sentenciaSQL = $conexion->prepare("UPDATE proximaspeliculas SET titulo=:titulo, duracion=:duracion, 
                        restriccionEdad=:restriccionEdad, categoria=:categoria, tipo=:tipo, fechaEstreno=:fechaEstreno  
                        WHERE IdPelicula=:IdPelicula");
            $sentenciaSQL->bindParam(':IdPelicula', $txtID);
            $sentenciaSQL->bindParam(':titulo', $txtTitulo);
            $sentenciaSQL->bindParam(':duracion', $txtDuracion);
            $sentenciaSQL->bindParam(':restriccionEdad', $txtrestriccionEdad);
            $sentenciaSQL->bindParam(':categoria', $txtCategoria);
            $sentenciaSQL->bindParam(':tipo', $txtTipo);
            $sentenciaSQL->bindParam(':fechaEstreno', $txtFecha);
            $sentenciaSQL->execute();

            //En caso de no modificar la imagen, no se modifica
            if ($txtImagen !== "") {
                $nombreArchivo = $_FILES["txtImagen"]["name"];
                $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
                move_uploaded_file($tmpImagen, "../../../GamesOfMovies/img/" . $nombreArchivo);
                $sentenciaSQL = $conexion->prepare("SELECT imgResource FROM proximaspeliculas WHERE IdPelicula=:IdPelicula");
                $sentenciaSQL->bindParam(':IdPelicula', $txtID);
                $sentenciaSQL->execute();
                $peliculas = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
                $sentenciaSQL = $conexion->prepare("UPDATE proximaspeliculas SET imgResource=:imgResource WHERE IdPelicula=:IdPelicula");
                $sentenciaSQL->bindParam(':imgResource', $nombreArchivo);
                $sentenciaSQL->bindParam(':IdPelicula', $txtID);
                $sentenciaSQL->execute();
            }
            header("Location:Peliculas.php");
        } else {
            $validarModificar = "SeleccionarProximaPelicula";
            echo "<script> alert('Complete Titulo-Duracion-Restriccion-Categoria-Tipo y/o Fecha Estreno'); </script>";
        }
        break;

    case "Cancelar":
        header("Location:Peliculas.php");
        break;

    case "Seleccionar":
        //Sentencia para recuperar la ID de la la tabla "pelicula" seleccionada desde la Web, para luego cargarla en los textview correspondientes
        
        $resultado=ListaPeliculas($db,"Seleccionar",$txtID);
        $SeleccionPelicula = mysqli_fetch_assoc($resultado);

        $txtTitulo = $SeleccionPelicula['titulo'];
        $txtDuracion = $SeleccionPelicula['duracion'];
        $txtrestriccionEdad = $SeleccionPelicula['restriccionEdad'];
        $txtCategoria = $SeleccionPelicula['categoria'];
        $txtTipo = $SeleccionPelicula['tipo'];
        $txtPrecio = $SeleccionPelicula['precio'];
        $txtDescripcion = $SeleccionPelicula['descripcion'];
        $txtImagen = $SeleccionPelicula['imgResource'];

        $validarModificar = "Seleccionar";
        break;

    case "Seleccionar ProximaPelicula":
        //Sentencia para recuperar la ID de la tabla "proximaspeliculas" seleccionada desde la Web, para luego cargarla en los textview correspondientes

        $resultado=ListaProximasPeliculas($db,"Seleccionar",$txtID);
        $SeleccionProximaPelicula = mysqli_fetch_assoc($resultado);

        $txtTitulo = $SeleccionProximaPelicula['titulo'];
        $txtDuracion = $SeleccionProximaPelicula['duracion'];
        $txtrestriccionEdad = $SeleccionProximaPelicula['restriccionEdad'];
        $txtCategoria = $SeleccionProximaPelicula['categoria'];
        $txtTipo = $SeleccionProximaPelicula['tipo'];
        $txtImagen = $SeleccionProximaPelicula['imgResource'];
        $txtFecha = $SeleccionProximaPelicula['fechaEstreno'];

        $validarModificar = "SeleccionarProximaPelicula";
        break;

    case "Pasar a Cartelera":
        if (
            !empty($txtTitulo) && !empty($txtDuracion) && !empty($txtrestriccionEdad) && !empty($txtCategoria) && !empty($txtTipo) &&
            !empty($txtPrecio) && !empty($txtDescripcion)
        ) {

            $sentencia = $conexion->prepare("SELECT titulo FROM peliculas");
            $sentencia->execute();
            $peliculas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            //Comprobacion de que la pelicula que se quiere ingresar, no este ya cargada en la Base de Datos
            foreach ($peliculas as $pelicula) {
                $txtTitulo2 = $pelicula['titulo'];
                if ($txtTitulo == $txtTitulo2) {
                    $validarPelicula = true;
                }
            }
            if ($validarPelicula == true) {
                echo "<script> alert('Pelicula existe'); </script>";
            } else {
                //Sentencia para insertar la pelicula en la tabla "peliculas"
                $sentenciaSQL = $conexion->prepare("INSERT INTO peliculas(titulo, duracion, restriccionEdad, categoria, tipo, precio,descripcion, imgResource) VALUES (:titulo,:duracion,:restriccion,:categoria,:tipo,:precio,:descripcion,:imgResource);");
                $sentenciaSQL->bindParam(':titulo', $txtTitulo);
                $sentenciaSQL->bindParam(':duracion', $txtDuracion);
                $sentenciaSQL->bindParam(':restriccion', $txtrestriccionEdad);
                $sentenciaSQL->bindParam(':categoria', $txtCategoria);
                $sentenciaSQL->bindParam(':tipo', $txtTipo);
                $sentenciaSQL->bindParam(':precio', $txtPrecio);
                $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
                $sentenciaSQL->bindParam(':imgResource', $txtImagen);
                //En caso de no seleccionar ninguna imagen, se coloca una pre establecida
                if ($txtImagen != "") {
                    $nombreArchivo = $_FILES["txtImagen"]["name"];
                    $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
                    move_uploaded_file($tmpImagen, "../../../GamesOfMovies/img/" . $nombreArchivo);
                } else {
                    $txtImagen = "NoImagen.jpeg";
                    $nombreArchivo = "NoImagen.jpeg";
                }

                $sentenciaSQL->bindParam(':imgResource', $nombreArchivo);
                $sentenciaSQL->execute();

                //Sentencia para eliminar la pelicula en la tabla "proximaspeliculas"
                $sentenciaSQL = $conexion->prepare("DELETE from proximaspeliculas WHERE IdPelicula=:IdPelicula");
                $sentenciaSQL->bindParam(':IdPelicula', $txtID);
                $sentenciaSQL->execute();
                $peliculas = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
                header("Location:Peliculas.php");
            }
        } else {
            $validarModificar = "SeleccionarProximaPelicula";
            echo "<script> alert('Complete Titulo-Duracion-Restriccion-Categoria-Tipo-Precio y/o Descripcion'); </script>";
        }
        break;

    case "Borrar":
        if ($accion = "Seleccionar") {
            $sentenciaSQL = $conexion->prepare("UPDATE peliculas SET habilitada=:habilitada WHERE IdPelicula=:IdPelicula");
            $sentenciaSQL->bindParam(':IdPelicula', $txtID);
            $sentenciaSQL->bindParam(':habilitada', $anularHabilitacion);
            $sentenciaSQL->execute();
        }
        if ($accion = "Seleccionar ProximaPelicula") {
            //Sentencia para eliminar una pelicula de la base de datos (tabla "proximaspeliculas") desde la web
            $sentenciaSQL = $conexion->prepare("UPDATE proximaspeliculas SET habilitadaProximaPelicula=:habilitadaProximaPelicula WHERE IdPelicula=:IdPelicula");
            $sentenciaSQL->bindParam(':IdPelicula', $txtID);
            $sentenciaSQL->bindParam(':habilitadaProximaPelicula', $anularHabilitacion);
            $sentenciaSQL->execute();
        }
        header("Location:Peliculas.php");
        break;

}

ListaProximasPeliculas($db);

?>

<script>
    function confirmacion() {
        var respuesta = confirm("¿Deseas borrar esta pelicula?");
        if (respuesta == true) {
            <label> Titulo:</label>
            return true;
        } else {
            return false;
        }
    }
</script>
<div class="row">
    <div class="col-md-3">
        <div class="col-md-3 col-md-offset-2"></div>

        <div class="card">
            <div class="card-header">
                Gestion Peliculas
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" class="form-control" value="<?php echo $txtID ?>" name="txtID"
                            placeholder="Ingresar ID">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?php echo $txtTitulo ?>" name="txtTitulo"
                            placeholder="Ingresar nombre">
                    </div>
                    <div class="form-group">
                        <label>Duracion:</label>
                        <input type="number" class="form-control" value="<?php echo $txtDuracion ?>" name="txtDuracion"
                            placeholder="Ingresar duracion [Minutos]">
                    </div>

                    <div class="form-group">
                        <label>Restriccion Edad:</label>
                        <select name="txtrestriccionEdad">

                            <?php

                            $listaRestriccionEdad = ListaPeliculas($db, "RestriccionEdad");

                            foreach ($listaRestriccionEdad as $restriccionEdad) {


                                ?>
                                <option>
                                    <?php echo $restriccionEdad['restriccionEdad'] ?>
                                </option>
                            <?php } ?>


                        </select>

                    </div>
                    <div class="form-group">
                        <label>Categoria:</label>
                        <input type="text" class="form-control" value="<?php echo $txtCategoria ?>" name="txtCategoria"
                            placeholder="Ingresar categoria">
                    </div>
                    <div class="form-group">
                        <label>Tipo:</label>
                        <select name="txtTipo">

                            <?php

                            $listaTipo = ListaPeliculas($db, "Tipo");

                            foreach ($listaTipo as $Tipo) {


                                ?>
                                <option value=> <?php echo $Tipo['tipo'] ?>
                                </option>
                            <?php } ?>



                        </select>


                    </div>
                    <div class="form-group">
                        <label>Precio:</label>
                        <input type="number" class="form-control" value="<?php echo $txtPrecio ?>" name="txtPrecio"
                            placeholder="Ingresar Precio">
                    </div>

                    <div class="form-group">
                        <label>Descripcion:</label>
                        <input type="text" class="form-control" value="<?php echo $txtDescripcion; ?>"
                            name="txtDescripcion" placeholder="Ingresar descripcion" maxlength="40">
                    </div>

                    <div class="form-group">
                        <label for="txtNombre">Imagen:</label>
                        <br />
                        <?php
                        if ($txtImagen != "") { ?>
                            <img class="img-thumbnail rounded" src="../../../GamesOfMovies/img/<?php echo $txtImagen; ?>"
                                width="70" alt="">
                        <?php } ?>
                        <input type="File" class="form-control" value="<?php echo $txtImagen ?>" name="txtImagen"
                            placeholder="Ingresar imagen">
                        <div class="form-group">
                            <label>Fecha de estreno:</label>

                            <input type="date" class="form-control" value="<?php echo $txtFecha ?>" name="txtFecha">
                        </div>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="cartelera" value="si"> Ingresar a Proximas Peliculas</label>
                    </div>
                    <div class="btn-group" role="group" aria-label="">

                        <button type="submit" name="accion" <?php

                        //Codigo para que al presionar en boton de "Seleccionar" o "Seleccionar ProximaPelicula" se desactive el boton "Agregar", quedando solo activo los botones "Modificar" y "Agregar"
                        echo ($validarModificar != "Inicio") ? "disabled" : "" ?> value="Agregar" class="btn btn-success">Agregar</button>
                        <button type="submit" name="accion" <?php echo ($validarModificar != "Seleccionar") ? "hidden" : "" ?> value="ModificarSeleccionar" class="btn btn-warning">Modificar</button>
                        <button type="submit" name="accion" <?php echo ($validarModificar != "SeleccionarProximaPelicula") ? "hidden" : "" ?>
                            value="ModificarSeleccionarProximaPelicula" class="btn btn-warning">Modificar</button>
                        <button type="submit" name="accion" <?php echo ($accion = "") ? "disabled" : "" ?>
                            value="Cancelar" class="btn btn-info">Cancelar</button>
                    </div>
                    <div class="btn-group" role="group" aria-label="">
                        <?php
                        //Codigo para que al presionar en boton de "Seleccionar" o "Seleccionar ProximaPelicula" se desactive el boton "Agregar", quedando solo activo los botones "Modificar" y "Agregar"?>
                        <button type="submit" name="accion" <?php echo ($validarModificar != "SeleccionarProximaPelicula") ? "disabled" : "" ?> value="Pasar a Cartelera"
                            class="btn btn-success">Pasar a Cartelera</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="col-md-4 col-md-offset-2"></div>
        <div class="card-header">Peliculas En Cartelera</div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Titulo</th>
                    <th>Duracion</th>
                    <th>Restriccion Edad</th>
                    <th>Categoria</th>
                    <th>Tipo</th>
                    <th>Precio</th>
                    <th>Descripcion</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $listaPeliculas = ListaPeliculas($db, "Lista");

                //Sentencia para recorrer la tabla "Peliculas" y ir llenando cada fila con los datos que corresponda de cada pelicula
                foreach ($listaPeliculas as $pelicula) {
                    if ($pelicula['habilitada'] == "Si") {
                        ?>
                        <tr>
                            <td>
                                <?php echo $pelicula['IdPelicula'] ?>
                            </td>
                            <td>
                                <?php echo $pelicula['titulo'] ?>
                            </td>
                            <td>
                                <?php echo $pelicula['duracion'] ?> Min
                            </td>
                            <td>
                                <?php echo $pelicula['restriccionEdad'] ?>
                            </td>
                            <td>
                                <?php echo $pelicula['categoria'] ?>
                            </td>
                            <td>
                                <?php echo $pelicula['tipo'] ?>
                            </td>
                            <td>
                                <?php echo $pelicula['precio'] ?> $
                            </td>
                            <td>
                                <?php echo $pelicula['descripcion'] ?>
                            </td>
                            <td>
                                <img src="../../../GamesOfMovies/img/<?php echo $pelicula['imgResource'] ?>" width="50" alt="">
                            </td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="txtID" IdPelicula="txtID"
                                        value="<?php echo $pelicula['IdPelicula']; ?>">
                                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger"
                                        onclick="return confirmacion()">
                                </form>
                            </td>
                        </tr>
                    <?php }
                }
                ?>
            </tbody>
        </table>

        <div class="card-header">Proximas Peliculas</div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Titulo</th>
                    <th>Duracion</th>
                    <th>Restriccion Edad</th>
                    <th>Categoria</th>
                    <th>Tipo</th>
                    <th>Imagen</th>
                    <th>Fecha Estreno</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $listaProximasPeliculas = ListaProximasPeliculas($db);
                //Sentencia para recorrer la tabla "ProximasPeliculas" y ir llenando cada fila con los datos que corresponda de cada pelicula
                foreach ($listaProximasPeliculas as $ProximaPelicula) {
                    if ($ProximaPelicula['habilitada'] == "Si") { ?>
                        <tr>
                            <td>
                                <?php echo $ProximaPelicula['IdPelicula'] ?>
                            </td>
                            <td>
                                <?php echo $ProximaPelicula['titulo'] ?>
                            </td>
                            <td>
                                <?php echo $ProximaPelicula['duracion'] ?> Min
                            </td>
                            <td>
                                <?php echo $ProximaPelicula['restriccionEdad'] ?>
                            </td>
                            <td>
                                <?php echo $ProximaPelicula['categoria'] ?>
                            </td>
                            <td>
                                <?php echo $ProximaPelicula['tipo'] ?>
                            </td>
                            <td>
                                <img src="../../../GamesOfMovies/img/<?php echo $ProximaPelicula['imgResource'] ?>" width="50"
                                    alt="">
                            </td>
                            <td>
                                <?php echo $ProximaPelicula['fechaEstreno'] ?>
                            </td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="txtID" IdPelicula="txtID"
                                        value="<?php echo $ProximaPelicula['IdPelicula']; ?>">
                                    <input type="submit" name="accion" value="Seleccionar ProximaPelicula"
                                        class="btn btn-primary">
                                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger"
                                        onclick="return confirmacion()">
                                </form>
                            </td>
                        </tr>
                    <?php }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Pie de la Pagina -->
</div>
</div>
</body>

</html>