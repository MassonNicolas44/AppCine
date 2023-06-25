<?php
require_once "../Include/Conexion.php";
require_once "../Include/Cabecera.php";
require_once "../Include/Funciones.php";

//Variables a Utilizar
$txtFechaInicio = (isset($_POST['txtFechaInicio'])) ? $_POST['txtFechaInicio'] : "";
$txtFechaFin = (isset($_POST['txtFechaFin'])) ? $_POST['txtFechaFin'] : "";
$Total=0;


//Condicional: si se selecciono una fecha, se cancelo la fecha o se imprime el correspondiente informe (teniendo en cuenta el rango de fecha)
if (isset($_POST['SeleccionarFecha'])) {

    //Caso en el cual se selecciona un rango de fecha para filtrar
    if (($txtFechaInicio!="") && ($txtFechaFin!="")) {

        $txtFechaInicio = date("Y-m-d", strtotime($_POST['txtFechaInicio']));
        $txtFechaFin = date("Y-m-d", strtotime($_POST['txtFechaFin']));

    //Caso en el cual no se selecciona un rango de fecha para filtrar
    } else {
        $txtFechaInicio = "";
        $txtFechaFin = "";
    }

    //Se asigna los valores de fecha a las variables de SESSION
    $_SESSION['txtFechaInicio'] = $txtFechaInicio;
    $_SESSION['txtFechaFin'] = $txtFechaFin;

    //Caso en el cual se cancela el rango de fecha para filtrar
} elseif (isset($_POST['CancelarFecha'])) {
    $txtFechaInicio = "";
    $txtFechaFin = "";

        //Se asigna los valores de fecha a las variables de SESSION
    $_SESSION['txtFechaInicio'] = $txtFechaInicio;
    $_SESSION['txtFechaFin'] = $txtFechaFin;

}

//Caso en el cual los rangos de fecha para filtrar ya existen. (No son nulos)
if (($txtFechaInicio!="") && ($txtFechaFin!="")) {

    if(($txtFechaInicio!=$_SESSION['txtFechaInicio']) || ($txtFechaFin!=$_SESSION['txtFechaFin'])){
        $txtFechaInicio = "";
        $txtFechaFin = "";
    
        $_SESSION['txtFechaInicio'] = $txtFechaInicio;
        $_SESSION['txtFechaFin'] = $txtFechaFin;
    }
}

    //Caso en el cual ya esta seleccionada la lista de Informe de Ventas
if ((empty($_SESSION['TipoListaInforme'])) || ($_SESSION['TipoListaInforme'] == "Venta")) {

    $_SESSION['TipoListaInforme'] = "Venta";
    if (($txtFechaInicio!="") && ($txtFechaFin!="")) {
        $listaVentas = ListaVentas($db,$txtFechaInicio,$txtFechaFin);
    }else{
        $listaVentas = ListaVentas($db);
    }

    //Caso en el cual ya esta seleccionada la lista de Informe de Recaudacion
} elseif (($_SESSION['TipoListaInforme'] == "Recaudacion")) {

    $_SESSION['TipoListaInforme'] = "Recaudacion";
    if (($txtFechaInicio!="") && ($txtFechaFin!="")) {
        $listaRecaudacion = ListaRecaudacion($db,$txtFechaInicio,$txtFechaFin);
    }else{
        $listaRecaudacion = ListaRecaudacion($db);
    }

    //Caso en el cual ya esta seleccionada la lista de Informe de Boletos
} elseif ($_SESSION['TipoListaInforme'] == "Boleto") {

    $_SESSION['TipoListaInforme'] = "Boleto";
    if (($txtFechaInicio!="") && ($txtFechaFin!="")) {
        $listaBoleto = ListaBoletos($db,$txtFechaInicio,$txtFechaFin);
    }else{
        $listaBoleto = ListaBoletos($db);
    }
    
}


//Caso en el cual se selecciona la lista de Informe de Ventas
if (isset($_POST['ListaVenta'])) {

    $_SESSION['TipoListaInforme'] = "Venta";
    //Verificacion si existe rango de fecha para filtrado
    if (($txtFechaInicio!="") && ($txtFechaFin!="")) {
        $listaVentas = ListaVentas($db,$txtFechaInicio,$txtFechaFin);
    }else{
        $listaVentas = ListaVentas($db);
    }

//Caso en el cual se selecciona la lista de Informe de Recaudacion
} elseif (isset($_POST['ListaRecaudacion'])) {

    $_SESSION['TipoListaInforme'] = "Recaudacion";
    //Verificacion si existe rango de fecha para filtrado
    if (($txtFechaInicio!="") && ($txtFechaFin!="")) {
        $listaRecaudacion = ListaRecaudacion($db,$txtFechaInicio,$txtFechaFin);
    }else{
        $listaRecaudacion = ListaRecaudacion($db);
    }

//Caso en el cual se selecciona la lista de Informe de Boletos
} elseif (isset($_POST['ListaBoletos'])) {

    $_SESSION['TipoListaInforme'] = "Boleto";
    //Verificacion si existe rango de fecha para filtrado
    if (($txtFechaInicio!="") && ($txtFechaFin!="")) {
        $listaBoleto = ListaBoletos($db,$txtFechaInicio,$txtFechaFin);
    }else{
        $listaBoleto = ListaBoletos($db);
    }

}



?>

<div class="container">
    <br />
    <div class="card">
        <?php if ($_SESSION['TipoListaInforme'] == "Venta") { ?>
            <div class="card-header"><em>Informe de Ventas</em></div>
        <?php } elseif ($_SESSION['TipoListaInforme'] == "Recaudacion") { ?>
            <div class="card-header"><em>Informe de Recaudacion</em></div>
        <?php } elseif ($_SESSION['TipoListaInforme'] == "Boleto") { ?>
            <div class="card-header"><em>Informe de Boletos</em></div>
        <?php }
        ; ?>
        <div class="card-body">
            <form action="InformeAdministrativo.php" method="post">
                <div class="row">
                    <?php
                    if ($txtFechaInicio!="" && $txtFechaFin!="") {
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


                <?php
                if ($txtFechaInicio!="" && ($txtFechaFin!="")) {
                    $MostrarFechaInicio = date("Y-m-d", strtotime($txtFechaInicio));
                    $MostrarFechaFin = date("Y-m-d", strtotime($txtFechaFin));
                }

                ?>

                <div class="row">
                    <div class="col-md-3">
                        <label> <ins> Fecha Inicio:</ins></label>
                        <input type="date" class="form-control" value="<?php echo $MostrarFechaInicio ?>"
                            name="txtFechaInicio">
                    </div>
                    <div class="col-md-3">
                        <label><ins> Fecha Fin:</ins></label>
                        <input type="date" class="form-control" value="<?php echo $MostrarFechaFin ?>"
                            name="txtFechaFin">

                    </div>

                </div>
                </br>
                <div class="col">
                    <button type="submit" name="SeleccionarFecha" class="btn btn-success">Seleccionar Fecha</button>
                    <button type="submit" name="CancelarFecha" class="btn btn-warning">Cancelar Fecha</button>
                </div>

                </br>
                <label> Lista de: </label>
                <div class="row">
                    <div class="col">

                        <button type="submit" name="ListaVenta" class="btn btn-info"> Ventas </button>
                        <button type="submit" name="ListaRecaudacion" class="btn btn-info"> Recaudacion </button>
                        <button type="submit" name="ListaBoletos" class="btn btn-info"> Boletos </button>

                    </div>
                </div>

                <br />
                <label> Imprimir Informe de: </label>
                <div class="row">
                    <div class="col">
                        <?php

                        ?>
                        <a href="<?php echo $_SESSION['url']; ?>/Imprimir/Ventas.php" class="btn btn-info"
                            target='_blank'> Ventas </a>
                        <a href="<?php echo $_SESSION['url']; ?>/Imprimir/Recaudacion.php" class="btn btn-info"
                            target='_blank'> Recaudacion </a>
                        <a href="<?php echo $_SESSION['url']; ?>/Imprimir/Boletos.php" class="btn btn-info"
                            target='_blank'> Boletos </a>

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
        if ($_SESSION['TipoListaInforme'] == "Venta") {
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

                        ; //Sentencia para recorrer la tabla "Peliculas" y ir llenando cada fila con los datos que corresponda de cada pelicula
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
                        <?php $Total=$Total+$Ventas['precioFinal']; }
                        ?>

                            <tr>
                                <td>
                                <b><?php echo "Total" ?></b>
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                   <b> <?php echo $Total ?> $ </b>
                                </td>
                            </tr>

                    </tbody>
                </table>
                </tbody>
            </div>
        </div>
        <?php
            //Caso en el cual se seleccionan para ver las recaudaciones de las Peliculas
        } elseif ($_SESSION['TipoListaInforme'] == "Recaudacion") {
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
                        <?php $Total=$Total+$Recaudacion['Recaudado']; }
                        ?>

                            <tr>
                                <td>
                                <b><?php echo "Total" ?></b>
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                   <b> <?php echo $Total ?> $ </b>
                                </td>
                            </tr>
                </tbody>
            </table>
            </tbody>
        </div>
    </div>

    <?php
            //Caso en el cual se seleccionan para ver los boletos de las Peliculas
        } elseif ($_SESSION['TipoListaInforme'] == "Boleto") {
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
                foreach ($listaBoleto as $Boletos) {
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
                    <?php $Total=$Total+$Boletos['Recaudado']; }
                        ?>

                            <tr>
                                <td>
                                <b><?php echo "Total" ?></b>
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                   <b> <?php echo $Total ?> $ </b>
                                </td>
                            </tr>
            </tbody>
        </table>
        </tbody>
    </div>
    </div>


<?php } ?>
<br />
</div>
