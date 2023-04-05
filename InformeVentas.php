<?php
include "Conexion.php";
include "Cabecera.php";

$txtFechaInicio=(isset($_POST['txtFechaInicio']))?$_POST['txtFechaInicio']:"";
$txtFechaFin=(isset($_POST['txtFechaFin']))?$_POST['txtFechaFin']:"";

    //Sentencia para seleccionar todos los datos de una pelicula de la base de datos (tabla "peliculas") desde la web
    $sentenciaSQL = $conexion->prepare("SELECT us.IdUsuario,us.usuario,pe.titulo,pr.fechaPelicula,pr.horaPelicula,pr.CantBoleto, pr.precioFinal
    FROM proyecciones AS pr 
    INNER JOIN peliculas AS pe ON pe.IdPelicula=pr.IdPelicula
    INNER JOIN usuarios AS us ON pr.IdUsuario =us.IdUsuario
    ORDER BY pr.fechaPelicula");
    $sentenciaSQL->execute();
    $listaVentas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['SeleccionarFecha'])){
            $txtFechaInicio=$_POST['txtFechaInicio'];
            $txtFechaFin=$_POST['txtFechaFin'];
    }elseif (isset($_POST['ImprimirInforme'])){
            header("Location:ImprimirInformeVentas.php");
    }elseif (isset($_POST['CancelarFecha'])){
        $txtFechaInicio="";
        $txtFechaFin="";
    }else{

    }

?>

<div class="container">
    <br/>
    <div class="card">
        <div class="card-header"><em>Informe de Ventas</em></div>
            <div class="card-body">
            <form action="InformeVentas.php" method="post"> 
                <div class="row">

                <?php
                        if (!empty($txtFechaInicio) && !empty($txtFechaFin)){
                            ?>
                                <div class="col-md-10">
                                <p align="left">
                                <strong>

                                    <?php
                                    echo "Fecha Inicio Informe: ".$txtFechaInicio." ----- Fecha Fin Informe: ".$txtFechaFin;
                                    ?>
                                    </strong>
                                    </p>
                                </div>
                            <?php
                        }else{
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

                    <div class = "col-md-3">
                        <label> <ins> Fecha Inicio:</ins></label>
                        <input type="date"  class="form-control" value="<?php echo $txtFechaInicio?>" name="txtFechaInicio">
                    </div>
                    <div class = "col-md-3">
                        <label><ins> Fecha Fin:</ins></label>
                        <input type="date"  class="form-control" value="<?php echo $txtFechaFin?>" name="txtFechaFin">
                    </div>                
                    <form action="InformeVentas.php" method="post">    
                    <div class = "col">
                        <button type="submit" name="SeleccionarFecha"  class="btn btn-success">Seleccionar Fecha</button>
                    </div>
                    <div class = "col">
                        <button type="submit" name="ImprimirInforme"  class="btn btn-info">Imprimir Informe</button>
                    </div>
                    <div class = "col">
                        <button type="submit" name="CancelarFecha" class="btn btn-warning">Cancelar</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<br/>

<div class="container">
<div class="card">
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
                    <th>Precio Final [$]</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                //Sentencia para recorrer la tabla "Peliculas" y ir llenando cada fila con los datos que corresponda de cada pelicula
                foreach($listaVentas as $Ventas){
                        
                ?>
                <tr>

                     <td><?php echo $Ventas['IdUsuario']?> </td>
                    <td><?php echo $Ventas['usuario']?> </td>
                    <td><?php echo $Ventas['titulo']?> </td>
                    <td><?php echo $Ventas['fechaPelicula']?> </td>
                    <td><?php echo $Ventas['horaPelicula']?> </td>
                    <td><?php echo $Ventas['CantBoleto']?></td>
                    <td><?php echo $Ventas['precioFinal']?></td>

                </tr>
                <?php }         
                    ?>
                </tbody>
                </table>
            </tbody>
        </div>
    </div>
    <br/>
</div>

<?php

