<!-- Pagina -->
<?php

require_once "../Include/Conexion.php";
require_once "../Include/Funciones.php";
require_once "../Include/Cabecera.php";

$errores=array();

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

$validarModificar = "Inicio";

//Switch de opciones para pagina web
switch ($accion) {

    case "Agregar":
        //En caso de agregar una pelicula y esta tildada para agregar a cartelera, se agregara como se indica. En caso contrario, se agrega en 'proximaspeliculas'
        if (isset($_POST["cartelera"])) {

//********************      Insertar Proxima Pelicula     ************************* */

            //Comprobacion de que los campos no estan vacios
            if (empty(trim($txtTitulo))){ 
                $errores['titulo']="Titulo vacio";
            }

            if (empty(trim($txtDuracion))){ 
                $errores['duracion']="Duracion vacio";
            }

            if (empty(trim($txtCategoria))){ 
                $errores['categoria']="Categoria vacio";
            }

            if (empty(trim($txtFecha))){ 
                $errores['fecha']="Fecha vacio";
            }

            if (count($errores)==0){

                 //Validar si ya existe el Titulo de la ProximaPelicula que se quiere Ingresar
                $ExistePelicula = ListaProximasPeliculas($db, "Titulo", null, $txtTitulo);
                $erroresProximaPelicula=ListaProximasPeliculas($db, "Titulo", null, $txtTitulo);

                if (count($erroresProximaPelicula)==0){
                    if ($txtImagen != "") {
                        $nombreArchivo = $_FILES["txtImagen"]["name"];
                        $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
                        move_uploaded_file($tmpImagen, "../../GamesOfMovies/img/" . $nombreArchivo);
                    } else {
                        $txtImagen = "NoImagen.jpeg";
                        $nombreArchivo = "NoImagen.jpeg";
                    }

                    //Insertar nueva ProximaPelicula
                    InsertarNuevaPelicula($db,"ProximasPeliculas", $txtTitulo, $txtDuracion, $txtrestriccionEdad, $txtCategoria, $txtTipo,null,null, $nombreArchivo, $txtFecha);

                    header("Location:Peliculas.php");

                }else{
                    $_SESSION['errores']=$erroresProximaPelicula;
                 }

            }else{
                $_SESSION['errores']=$errores;
            }

        } else {


            //********************      Insertar Pelicula     ************************* */
            //Comprobacion de que los campos no estan vacios
            if (empty(trim($txtTitulo))){ 
                $errores['titulo']="Titulo vacio";
            }

            if (empty(trim($txtDuracion))){ 
                $errores['duracion']="Duracion vacio";
            }

            if (empty(trim($txtCategoria))){ 
                $errores['categoria']="Categoria vacio";
            }

            if (empty(trim($txtPrecio))){ 
                $errores['precio']="Precio vacio";
            }

            if (empty(trim($txtDescripcion))){ 
                $errores['descripcion']="Descripcion vacio";
            }

            if (count($errores)==0){
                //Validar si ya existe el Titulo de la ProximaPelicula que se quiere Ingresar
                $ExistePelicula = ListaPeliculas($db, "Titulo", null, $txtTitulo);
                $erroresPelicula=ListaPeliculas($db, "Titulo", null, $txtTitulo);

                if (count($erroresPelicula)==0){

                    if ($txtImagen != "") {
                        $nombreArchivo = $_FILES["txtImagen"]["name"];
                        $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
                        move_uploaded_file($tmpImagen, "../../GamesOfMovies/img/" . $nombreArchivo);
                    } else {
                        $txtImagen = "NoImagen.jpeg";
                        $nombreArchivo = "NoImagen.jpeg";
                    }

                    //Insertar nueva Pelicula
                    InsertarNuevaPelicula($db,"Peliculas",$txtTitulo,$txtDuracion,$txtrestriccionEdad,$txtCategoria,$txtTipo,$txtPrecio,$txtDescripcion,$nombreArchivo);

                    header("Location:Peliculas.php");
                }else{
                    $_SESSION['errores']=$erroresPelicula;
                }
            }else{
                $_SESSION['errores']=$errores;
            }
        }
        break;

    case "ModificarSeleccionar":

//********************      Modificar Pelicula     ************************* */

        if (empty(trim($txtTitulo))){ 
            $errores['titulo']="Titulo vacio";
        }

        if (empty(trim($txtDuracion))){ 
            $errores['duracion']="Duracion vacio";
        }

        if (empty(trim($txtCategoria))){ 
            $errores['categoria']="Categoria vacio";
        }

        if (empty(trim($txtPrecio))){ 
            $errores['precio']="Precio vacio";
        }

        if (empty(trim($txtDescripcion))){ 
            $errores['descripcion']="Descripcion vacio";
        }

        if (count($errores)==0){

            //En caso de no modificar la imagen, no se modifica
            if ($txtImagen !== "") {
                $nombreArchivo = $_FILES["txtImagen"]["name"];
                $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
                move_uploaded_file($tmpImagen, "../../GamesOfMovies/img/" . $nombreArchivo);

                //Sentencia para actualizar registros con respecto a la tabla peliculas
                ModificarPelicula($db, $Valor = "Peliculas", $txtTitulo, $txtDuracion, $txtrestriccionEdad, $txtCategoria, $txtTipo, 
                $txtPrecio, $txtDescripcion, $nombreArchivo,null,$txtID);
            }else{
                //Sentencia para actualizar registros con respecto a la tabla peliculas
                ModificarPelicula($db, $Valor = "Peliculas", $txtTitulo, $txtDuracion, $txtrestriccionEdad, $txtCategoria, $txtTipo, 
                $txtPrecio, $txtDescripcion, null,null,$txtID);
            }

            header("Location:Peliculas.php");
        }else{
            $validarModificar = "Seleccionar";
            $_SESSION['errores']=$errores;
        }
        
     break;


    case "ModificarSeleccionarProximaPelicula":

//********************      Modificar Proxima Pelicula     ************************* */

        //Comprobacion de que los campos no estan vacios
        if (empty(trim($txtTitulo))){ 
            $errores['titulo']="Titulo vacio";
        }

        if (empty(trim($txtDuracion))){ 
            $errores['duracion']="Duracion vacio";
        }

        if (empty(trim($txtCategoria))){ 
            $errores['categoria']="Categoria vacio";
        }

        if (empty(trim($txtFecha))){ 
            $errores['fecha']="Fecha vacio";
        }

        if (count($errores)==0){

            //En caso de no modificar la imagen, no se modifica
            if ($txtImagen !== "") {
                $nombreArchivo = $_FILES["txtImagen"]["name"];
                $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
                move_uploaded_file($tmpImagen, "../../GamesOfMovies/img/" . $nombreArchivo);

                //Sentencia para actualizar registros con respecto a la tabla peliculas
                ModificarPelicula($db, $Valor = "ProximasPeliculas", $txtTitulo, $txtDuracion, $txtrestriccionEdad, $txtCategoria, $txtTipo, 
                null, null, $nombreArchivo,$txtFecha,$txtID);
            }else{
                //Sentencia para actualizar registros con respecto a la tabla peliculas
                ModificarPelicula($db, $Valor = "ProximasPeliculas", $txtTitulo, $txtDuracion, $txtrestriccionEdad, $txtCategoria, $txtTipo, 
                null, null, null,$txtFecha,$txtID);
            }

            header("Location:Peliculas.php");
            
        }else{
            $validarModificar = "SeleccionarProximaPelicula";
            $_SESSION['errores']=$errores;
        }

        break;

    case "Cancelar":
        header("Location:Peliculas.php");
        break;

    case "Seleccionar":
        
        //Traer datos de la Pelicula Seleccionada
        $resultado = ListaPeliculas($db, "Seleccionar", $txtID);
        $SeleccionPelicula = mysqli_fetch_assoc($resultado);

        //Asignar cada campo con la Pelicula Seleccionada
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

        //Traer datos de la ProximaPelicula Seleccionada
        $resultado = ListaProximasPeliculas($db, "Seleccionar", $txtID);
        $SeleccionProximaPelicula = mysqli_fetch_assoc($resultado);

        //Asignar cada campo con la ProximaPelicula Seleccionada
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

        //Comprobacion de que los campos no estan vacios
        if (empty(trim($txtTitulo))){ 
            $errores['titulo']="Titulo vacio";
        }

        if (empty(trim($txtDuracion))){ 
            $errores['duracion']="Duracion vacio";
        }

        if (empty(trim($txtCategoria))){ 
            $errores['categoria']="Categoria vacio";
        }

        if (empty(trim($txtPrecio))){ 
            $errores['precio']="Precio vacio";
        }

        if (empty(trim($txtDescripcion))){ 
            $errores['descripcion']="Descripcion vacio";
        }

        if (count($errores)==0){
            //Validar si ya existe el Titulo de la ProximaPelicula que se quiere Ingresar
            $ExistePelicula = ListaPeliculas($db, "Titulo", null, $txtTitulo);
            $erroresPelicula=ListaPeliculas($db, "Titulo", null, $txtTitulo);

            if (count($erroresPelicula)==0){

                   if ($txtImagen != "") {
                       $nombreArchivo = $_FILES["txtImagen"]["name"];
                       $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
                       move_uploaded_file($tmpImagen, "../../GamesOfMovies/img/" . $nombreArchivo);
                   } else {
                       $txtImagen = "NoImagen.jpeg";
                       $nombreArchivo = "NoImagen.jpeg";
                   }

                   //Insertar nueva Pelicula
                   InsertarNuevaPelicula($db,"Peliculas",$txtTitulo,$txtDuracion,$txtrestriccionEdad,$txtCategoria,$txtTipo,$txtPrecio,$txtDescripcion,$nombreArchivo);
                
                   //Eliminar la pelicula que estaba en ProximasPeliculas
                   EliminarProximaPelicula($db,$txtID);

                    header("Location:Peliculas.php");
            }else{
                $_SESSION['errores']=$erroresPelicula;
            }
        }else{
            $validarModificar = "SeleccionarProximaPelicula";
            $_SESSION['errores']=$errores;
        }

        break;

    case "Borrar":
        if ($accion = "Seleccionar") {

            //Anular la Pelicula a Borrar
            AccionPelicula($db, null, 'No', $txtID, null);
            header("Location:Peliculas.php");

        }
        if ($accion = "Seleccionar ProximaPelicula") {

            //Anular la ProximaPelicula a Borrar
            AccionPelicula($db, null, 'No', null, $txtID);
            header("Location:Peliculas.php");

        }

        break;

}


?>

<div class="row">
    <div class="col-md-3">
        <div class="col-md-3 col-md-offset-2"></div>

        <div class="card">
            <div class="card-header">
                Gestion Peliculas
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">

                <?php // **************            Id Oculto            **************     ?>

                    <div class="form-group">
                        <input type="hidden" class="form-control" value="<?php echo $txtID ?>" name="txtID"
                            placeholder="Ingresar ID">
                    </div>

                    <?php // **************            Titulo             **************     ?>

                    <div class="form-group">
                    <label>Titulo:</label>
                        <input type="text" class="form-control" value="<?php echo $txtTitulo ?>" name="txtTitulo"
                            placeholder="Ingresar Titulo">

                            <?php // **************            Mensaje de Error Titulo             **************     ?>
                            <?php echo isset($_SESSION['errores']) ? MostrarErrores($_SESSION['errores'],'titulo') : '' ;?>

                    </div>

                    <?php // **************            Duracion             **************     ?>

                    <div class="form-group">
                        <label>Duracion:</label>
                        <input type="number" class="form-control" value="<?php echo $txtDuracion ?>" name="txtDuracion"
                            placeholder="Ingresar Duracion [Minutos]">

                            <?php // **************            Mensaje de Error Duracion             **************     ?>
                            <?php echo isset($_SESSION['errores']) ? MostrarErrores($_SESSION['errores'],'duracion') : '' ;?>

                    </div>

                    <?php // **************            Restriccion Edad             **************     ?>
                    <div class="form-group">
                        <label>Restriccion Edad:</label>
                        <select name="txtrestriccionEdad">

                        
                            <?php
                                //Trae la lista de Restriccion Edad que esta guardada en la base de dato para asignarse al Select
                                $listaRestriccionEdad = ListaPeliculas($db, "RestriccionEdad");

                                while ($restriccionEdad =mysqli_fetch_assoc($listaRestriccionEdad)):
                                        //Carga las opciones con los valores cargados en la Base de Datos
                                        ?>
                                    <option value="<?=$restriccionEdad['restriccionEdad']?>" <?= ($restriccionEdad['restriccionEdad'] == $txtrestriccionEdad) ? 'selected="selected"' : '' ?>> 
                                        <?=$restriccionEdad['restriccionEdad']?>
                                    </option>
                                <?php
                            endwhile;
                            ?>                     
                        </select>                       
                    </div>

                    <?php // **************            Categoria             **************     ?>

                    <div class="form-group">
                        <label>Categoria:</label>
                        <input type="text" class="form-control" value="<?php echo $txtCategoria ?>" name="txtCategoria"
                            placeholder="Ingresar Categoria">

                            <?php // **************            Mensaje de Error Categoria             **************     ?>
                            <?php echo isset($_SESSION['errores']) ? MostrarErrores($_SESSION['errores'],'categoria') : '' ;?>

                    </div>

                    <?php // **************            Tipo             **************     ?>
                    <div class="form-group">
                        <label>Tipo:</label>
                        <select name="txtTipo">

                            <?php 

                            //Trae la lista de Tipo que esta guardada en la base de dato para asignarse al Select
                            $listaTipo = ListaPeliculas($db, "Tipo");

                            while ($Tipo =mysqli_fetch_assoc($listaTipo)):
                                //Carga las opciones con los valores cargados en la Base de Datos
                                ?>
                                <option value="<?=$Tipo['tipo']?>" <?=($Tipo['tipo'] == $txtTipo) ? 'selected="selected"' : '' ?>>
                                        <?=$Tipo['tipo']?>
                                    </option>
                                <?php                     
                       endwhile;
                        ?>
                        </select>
                    </div>

                    <?php // **************            Precio             **************     ?>

                    <div class="form-group">
                        <label>Precio:</label>
                        <input type="number" class="form-control" value="<?php echo $txtPrecio ?>" name="txtPrecio"
                            placeholder="Ingresar Precio">

                            <?php // **************            Mensaje de Error Precio             **************     ?>
                            <?php echo isset($_SESSION['errores']) ? MostrarErrores($_SESSION['errores'],'precio') : '' ;?>

                    </div>

                    <?php // **************            Descripcion             **************     ?>
                    <div class="form-group">
                        <label>Descripcion:</label>
                        <textarea input name="txtDescripcion" placeholder="Ingresar Descripcion" cols="34" rows="5"><?php if (!empty($txtDescripcion)){
                            echo $SeleccionPelicula['descripcion'];}?></textarea>

                        <?php // **************            Mensaje de Error Descripcion             **************     ?>
                        <?php echo isset($_SESSION['errores']) ? MostrarErrores($_SESSION['errores'],'descripcion') : '' ;?>

                    </div>

                    <?php // **************            Imagen             **************     ?>
                    <div class="form-group">
                        <label for="txtNombre">Imagen:</label>
                        <br />
                        <?php
                        if ($txtImagen != "") { ?>
                            <img class="img-thumbnail rounded" src="../../GamesOfMovies/img/<?php echo $txtImagen; ?>"
                                width="300" alt="">
                        <?php } ?>
                        <input type="File" class="form-control" value="<?php echo $txtImagen ?>" name="txtImagen"
                            placeholder="Ingresar imagen">


                        <?php // **************            Fecha             **************     ?>
                        <div class="form-group">
                            <label>Fecha de estreno:</label>

                            <input type="date" class="form-control" value="<?php echo $txtFecha ?>" name="txtFecha">

                            <?php // **************            Mensaje de Error Fecha             **************     ?>
                            <?php echo isset($_SESSION['errores']) ? MostrarErrores($_SESSION['errores'],'fecha') : '' ;?>

                        </div>
                    </div>

                    <?php // **************            Ingresar Proxima Pelicula             **************     ?>
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

                //Recopila la lista de las Peliculas que existen en la base de datos
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
                            <td style="max-width: 40px; overflow: hidden;">
                                <?php  echo $pelicula['descripcion'] ?>
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

                //Recopila la lista de las ProximasPeliculas que existen en la base de datos
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
</body>

    <script>
    //Mensaje de Confirmacion al querar Anular Pelicula y/o Proxima Pelicula
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

<?php BorrarErrores(); ?>

</html>