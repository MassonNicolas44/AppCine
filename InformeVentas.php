<?php
include "Conexion.php";
include "CabeceraAdministrador.php";

//Variables a Utilizar
$txtFechaInicio = (isset($_POST['txtFechaInicio'])) ? $_POST['txtFechaInicio'] : "";
$txtFechaFin = (isset($_POST['txtFechaFin'])) ? $_POST['txtFechaFin'] : "";
$rdgTipo = (isset($_POST['Tipo'])) ? $_POST['Tipo'] : "Ventas";

//En caso de seleccionar "Ventas" // "Recaudacion" o "Boletos", va a traer la tabla correspondiente para luego ser cargada mas adelante
if ($rdgTipo == "Ventas") {
    $sentenciaSQL = $conexion->prepare("SELECT us.IdUsuario,us.usuario,pe.titulo,pr.fechaPelicula,pr.horaPelicula,pr.CantBoleto, pr.precioFinal, pe.habilitada
    FROM proyecciones AS pr 
    INNER JOIN peliculas AS pe ON pe.IdPelicula=pr.IdPelicula
    INNER JOIN usuarios AS us ON pr.IdUsuario =us.IdUsuario
    ORDER BY pr.fechaPelicula");
    $sentenciaSQL->execute();
    $listaVentas = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
} elseif ($rdgTipo == "Recaudacion") {
    $sentenciaSQL = $conexion->prepare("SELECT pe.IdPelicula,pe.titulo,pe.duracion,pe.categoria,pe.tipo,Sum(pr.precioFinal) AS Recaudado,Sum(CantBoleto) AS TotalBoleto, pe.habilitada FROM proyecciones AS pr INNER JOIN peliculas AS pe
    ON pe.IdPelicula=pr.IdPelicula 
    Group by pe.titulo
    ORDER BY Recaudado desc");
    $sentenciaSQL->execute();
    $listaRecaudacion = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
} elseif ($rdgTipo == "Boletos") {
    $sentenciaSQL = $conexion->prepare("SELECT pe.IdPelicula,pe.titulo,pe.duracion,pe.categoria,pe.tipo,Sum(pr.precioFinal) AS Recaudado,Sum(CantBoleto) AS TotalBoleto, pe.habilitada FROM proyecciones AS pr INNER JOIN peliculas AS pe
    ON pe.IdPelicula=pr.IdPelicula 
    Group by pe.titulo
    ORDER BY TotalBoleto desc");
    $sentenciaSQL->execute();
    $listaBoletos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
}

//Condicional: si se selecciono una fecha, se cancelo la fecha o se imprime el correspondiente informe (teniendo en cuenta el rango de fecha)
if (isset($_POST['SeleccionarFecha'])) {
    if (!empty($txtFechaInicio) && !empty($txtFechaFin)) {
        $txtFechaInicio = $_POST['txtFechaInicio'];
        $txtFechaFin = $_POST['txtFechaFin'];
    } else {
        $txtFechaInicio = "";
        $txtFechaFin = "";
    }
    $_SESSION['txtFechaInicio'] = $txtFechaInicio;
    $_SESSION['txtFechaFin'] = $txtFechaFin;

} elseif (isset($_POST['ImprimirInforme'])) {
    if ($rdgTipo == "Ventas") {
        header("Location:ImprimirInformeVentas.php");
    } elseif ($rdgTipo == "Recaudacion") {
        header("Location:ImprimirInformeRecaudacion.php");
    } elseif ($rdgTipo == "Boletos") {
        header("Location:ImprimirInformeBoletos.php");
    }
} elseif (isset($_POST['CancelarFecha'])) {
    $txtFechaInicio = "";
    $txtFechaFin = "";
    session_start();
    $_SESSION['txtFechaInicio'] = $txtFechaInicio;
    $_SESSION['txtFechaFin'] = $txtFechaFin;
} else {

}

?>

<div class="container">
    <br />
    <div class="card">
        <?php if ($rdgTipo == "Ventas") { ?>
            <div class="card-header"><em>Informe de Ventas</em></div>
        <?php } elseif ($rdgTipo == "Recaudacion") { ?>
            <div class="card-header"><em>Informe de Recaudacion</em></div>
        <?php } elseif ($rdgTipo == "Boletos") { ?>
            <div class="card-header"><em>Informe de Boletos</em></div>
        <?php }
        ; ?>
        <div class="card-body">
            <form action="InformeVentas.php" method="post">
                <div class="row">
                    <?php
                    if (!empty($txtFechaInicio) && !empty($txtFechaFin)) {
                        ?>
                        <div class="col-md-10">
                            <p align="left">
                                <strong>

                                    <?php
                                    echo "Fecha Inicio Informe: " . $txtFechaInicio . " ----- Fecha Fin Informe: " . $txtFechaFin;
                                    ?>
                                </strong>
                            </p>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="col-md-10">
                            <p align="left">
                                <strong>
                                    <?php
                                    echo "Informe Sin Filtro de Fecha";
                                    ?>
                                </strong>
                            </p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <form action="InformeVentas.php" method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <label> <ins> Fecha Inicio:</ins></label>
                            <input type="date" class="form-control" value="<?php echo $txtFechaInicio ?>"
                                name="txtFechaInicio">
                        </div>
                        <div class="col-md-3">
                            <label><ins> Fecha Fin:</ins></label>
                            <input type="date" class="form-control" value="<?php echo $txtFechaFin ?>"
                                name="txtFechaFin">

                        </div>

                    </div>
                    </br>
                    <div class="col">
                        <button type="submit" name="SeleccionarFecha" class="btn btn-success">Seleccionar Fecha</button>
                        <button type="submit" name="CancelarFecha" class="btn btn-warning">Cancelar Fecha</button>
                    </div>


                    <div class="col">
                        <div class="row">
                            Ventas <input type="radio" <?php echo ($rdgTipo == "Ventas") ? "checked" : ""; ?> name="Tipo"
                                value="Ventas">
                        </div>
                        <div class="row">
                            Recaudacion <input type="radio" <?php echo ($rdgTipo == "Recaudacion") ? "checked" : ""; ?>
                                name="Tipo" value="Recaudacion">
                        </div>
                        <div class="row">
                            Boletos <input type="radio" <?php echo ($rdgTipo == "Boletos") ? "checked" : ""; ?>
                                name="Tipo" value="Boletos">
                        </div>
                    </div>

                    <br />
                    <div class="row">
                        <div class="col">
                            <button type="submit" name="SeleccionarTipoInforme" class="btn btn-info">Seleccionar Tipo
                                Informe</button>
                            <button type="submit" name="ImprimirInforme" class="btn btn-info">Imprimir Informe</button>
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
        //Caso en el cual se seleccionan para ver las ventas por peliculas
        if ($rdgTipo == "Ventas") {
            ?>
            <div class="card-header"><em>Ventas</em></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Usuario</th>
                            <th>Titulo</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Cantidad Boleto</th>
                            <th>Precio Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //Sentencia para recorrer la tabla "Peliculas" y ir llenando cada fila con los datos que corresponda de cada pelicula
                        foreach ($listaVentas as $Ventas) {
                            ?>
                            <tr>

                                <td>
                                    <?php echo $Ventas['IdUsuario'] ?>
                                </td>
                                <td>
                                    <?php echo $Ventas['usuario'] ?>
                                </td>
                                <td>
                                    <?php echo $Ventas['titulo'] ?>
                                </td>
                                <td>
                                    <?php echo $Ventas['fechaPelicula'] ?>
                                </td>
                                <td>
                                    <?php echo $Ventas['horaPelicula'] ?>
                                </td>
                                <td>
                                    <?php echo $Ventas['CantBoleto'] ?>
                                </td>
                                <td>
                                    <?php echo $Ventas['precioFinal'] ?> $
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
                </tbody>
            </div>
        </div>
        <?php
            //Caso en el cual se seleccionan para ver las recaudaciones de las Peliculas
        } elseif ($rdgTipo == "Recaudacion") {
            ?>

        <div class="card-header"><em>Recaudacion</em></div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Titulo</th>
                        <th>Categoria</th>
                        <th>Tipo</th>
                        <th>Activa</th>
                        <th>Cantidad Boleto</th>
                        <th>Total Recaudado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //Sentencia para recorrer la tabla "Peliculas" y ir llenando cada fila con los datos que corresponda de cada pelicula
                    foreach ($listaRecaudacion as $Recaudacion) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $Recaudacion['IdPelicula'] ?>
                            </td>
                            <td>
                                <?php echo $Recaudacion['titulo'] ?>
                            </td>
                            <td>
                                <?php echo $Recaudacion['categoria'] ?>
                            </td>
                            <td>
                                <?php echo $Recaudacion['tipo'] ?>
                            </td>
                            <td>
                                <?php echo $Recaudacion['habilitada'] ?>
                            </td>
                            <td>
                                <?php echo $Recaudacion['TotalBoleto'] ?>
                            </td>
                            <td>
                                <?php echo $Recaudacion['Recaudado'] ?> $
                            </td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
            </tbody>
        </div>
    </div>

    <?php
            //Caso en el cual se seleccionan para ver los boletos de las Peliculas
        } elseif ($rdgTipo == "Boletos") {
            ?>
    <div class="card-header"><em>Boletos</em></div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Titulo</th>
                    <th>Categoria</th>
                    <th>Tipo</th>
                    <th>Activa</th>
                    <th>Cantidad Boleto</th>
                    <th>Total Recaudado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //Sentencia para recorrer la tabla "Peliculas" y ir llenando cada fila con los datos que corresponda de cada pelicula
                foreach ($listaBoletos as $Boletos) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $Boletos['IdPelicula'] ?>
                        </td>
                        <td>
                            <?php echo $Boletos['titulo'] ?>
                        </td>
                        <td>
                            <?php echo $Boletos['categoria'] ?>
                        </td>
                        <td>
                            <?php echo $Boletos['tipo'] ?>
                        </td>
                        <td>
                            <?php echo $Boletos['habilitada'] ?>
                        </td>
                        <td>
                            <?php echo $Boletos['TotalBoleto'] ?>
                        </td>
                        <td>
                            <?php echo $Boletos['Recaudado'] ?> $
                        </td>
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

<?php
