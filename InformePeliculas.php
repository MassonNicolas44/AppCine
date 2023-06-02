<?php
require_once "Include/Conexion.php";
require_once "Include/Funciones.php";
require_once "Include/Cabecera.php";


//Variables a utilizar
$IdPelicula = (isset($_POST['idPelicula'])) ? $_POST['idPelicula'] : "";
$IdProximasPelicula = (isset($_POST['idProximasPelicula'])) ? $_POST['idProximasPelicula'] : "";

if (empty($_SESSION['TipoListaPelicula']) || ($_SESSION['TipoListaPelicula'] == "Peliculas")) {

    $_SESSION['TipoListaPelicula'] = "Peliculas";
    $listaPeliculas = ListaPeliculas($db);

} elseif ($_SESSION['TipoListaPelicula'] == "ProximasPeliculas") {

    $_SESSION['TipoListaPelicula'] = "ProximasPeliculas";
    $listaProximaPeliculas = ListaProximasPeliculas($db);

}

//En caso de seleccionar "Peliculas" o "ProximasPeliculas", va a traer la tabla correspondiente para luego ser cargada mas adelante
if (isset($_POST['Peliculas'])) {

    $_SESSION['TipoListaPelicula'] = "Peliculas";
    $listaPeliculas = ListaPeliculas($db);

} elseif (isset($_POST['ProximasPeliculas'])) {

    $_SESSION['TipoListaPelicula'] = "ProximasPeliculas";
    $listaProximaPeliculas = ListaProximasPeliculas($db);
}


//En caso de de Habilitar o InhabilitarPelicula tanto Peliculas como ProximasPeliculas, se actualiza la columna con la tabla correspondiente
if (isset($_POST['HabilitarPelicula'])) {

    asd($db, 'Si', null, $IdPelicula, null);

} elseif (isset($_POST['InhabilitarPelicula'])) {

    asd($db, null, 'No', $IdPelicula, null);

} elseif (isset($_POST['HabilitarProximasPeliculas'])) {

    asd($db, 'Si', null, null, $IdProximasPelicula);

} elseif (isset($_POST['InhabilitarProximasPeliculas'])) {

    asd($db, null, 'No', null, $IdProximasPelicula);

}


?>
<br />
<div class="container">
    <div class="card">
        <?php if ($_SESSION['TipoListaPelicula'] == "Peliculas") { ?>
            <div class="card-header"><em>Informe de Peliculas</em></div>
        <?php } elseif ($_SESSION['TipoListaPelicula'] == "ProximasPeliculas") { ?>
            <div class="card-header"><em>Informe de Proximas Peliculas</em></div>
        <?php }
        ;
        ?>
        <div class="card-body">
            <form action="InformePeliculas.php" method="post">
                <label> Lista de: </label>
                <div class="row">
                    <div class="col">

                        <button type="submit" name="Peliculas" class="btn btn-info"> Peliculas </button>
                        <button type="submit" name="ProximasPeliculas" class="btn btn-info"> Proximas Peliculas
                        </button>

                    </div>
                </div>

                <br />
                <label> Imprimir Informe de: </label>
                <div class="row">
                    <div class="col">
                        <?php

                        ?>
                        <a href="<?php echo $_SESSION['url']; ?>/Imprimir/Peliculas.php" class="btn btn-info"
                            target='_blank'> Peliculas </a>
                        <a href="<?php echo $_SESSION['url']; ?>/Imprimir/ProximaPeliculas.php" class="btn btn-info"
                            target='_blank'> Proximas Peliculas </a>

                    </div>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
</div>

<br />
<div class="container">
    <div class="card">
        <?php
        //Caso en el cual se seleccionan para ver Peliculas
        if ($_SESSION['TipoListaPelicula'] == "Peliculas") {
            ?>
            <div class="card-header"><em>Peliculas</em></div>
            <div class="card-body">
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
                            <th>Habilitada</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //Sentencia para recorrer la tabla "Peliculas" y ir llenando cada fila con los datos que corresponda de cada pelicula
                        foreach ($listaPeliculas as $pelicula) {
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
                                    <img src="../../../GamesOfMovies/img/<?php echo $pelicula['imgResource'] ?>" width="75"
                                        alt="">
                                </td>
                                <td>
                                    <?php echo $pelicula['habilitada'] ?>
                                </td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="idPelicula" IdUsuario="idPelicula"
                                            value="<?php echo $pelicula['IdPelicula']; ?>">
                                        <input type="submit" name="HabilitarPelicula" value="Habilitar" class="btn btn-primary"
                                            onclick="return confirmacionHabilitar()">
                                        <input type="submit" name="InhabilitarPelicula" value="Inhabilitar"
                                            class="btn btn-danger" onclick="return confirmacionInhabilitar()">
                                    </form>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
                </tbody>
            </div>
        </div>
        <?php
            //Caso en el cual se seleccionan para ver ProximasPeliculas
        } elseif ($_SESSION['TipoListaPelicula'] == "ProximasPeliculas") {
            ?>
        <div class="card-header"><em>Proximas Peliculas</em></div>
        <div class="card-body">
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
                        <th>Habilitada</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //Sentencia para recorrer la tabla "Peliculas" y ir llenando cada fila con los datos que corresponda de cada pelicula
                    foreach ($listaProximaPeliculas as $proximaPeliculas) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $proximaPeliculas['IdPelicula'] ?>
                            </td>
                            <td>
                                <?php echo $proximaPeliculas['titulo'] ?>
                            </td>
                            <td>
                                <?php echo $proximaPeliculas['duracion'] ?> Min
                            </td>
                            <td>
                                <?php echo $proximaPeliculas['restriccionEdad'] ?>
                            </td>
                            <td>
                                <?php echo $proximaPeliculas['categoria'] ?>
                            </td>
                            <td>
                                <?php echo $proximaPeliculas['tipo'] ?>
                            </td>
                            <td>
                                <img src="../../../GamesOfMovies/img/<?php echo $proximaPeliculas['imgResource'] ?>" width="75"
                                    alt="">
                            </td>
                            <td>
                                <?php echo $proximaPeliculas['fechaEstreno'] ?>
                            </td>
                            <td>
                                <?php echo $proximaPeliculas['habilitada'] ?>
                            </td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="idProximasPelicula" IdUsuario="idProximasPelicula"
                                        value="<?php echo $proximaPeliculas['IdPelicula']; ?>">
                                    <input type="submit" name="HabilitarProximasPeliculas" value="Habilitar"
                                        class="btn btn-primary" onclick="return confirmacionHabilitar()">
                                    <input type="submit" name="InhabilitarProximasPeliculas" value="Inhabilitar"
                                        class="btn btn-danger" onclick="return confirmacionInhabilitar()">
                                </form>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
            </tbody>
        </div>
    </div>
<?php } ?>
<br />
</div>

<script>
    function confirmacionHabilitar() {
        //mensaje de confirmacion de habilitar Pelicula
        var respuesta = confirm("¿Deseas Habilitar esta Pelicula?");
        if (respuesta == true) {
            return true;
        } else {
            return false;
        }
    }

    function confirmacionInhabilitar() {
        //mensaje de confirmacion de Inhabilitar Pelicula
        var respuesta = confirm("¿Deseas Inhabilitar este Pelicula?");
        if (respuesta == true) {
            return true;
        } else {
            return false;
        }
    }
</script>

<?php