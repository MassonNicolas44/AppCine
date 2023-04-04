<?php
include "Conexion.php";
include "Cabecera.php";

$txtFechaInicio=(isset($_POST['txtFechaInicio']))?$_POST['txtFechaInicio']:"";
$txtFechaFin=(isset($_POST['txtFechaFin']))?$_POST['txtFechaFin']:"";

    //Sentencia para seleccionar todos los datos de una pelicula de la base de datos (tabla "peliculas") desde la web
    $sentenciaSQL = $conexion->prepare("SELECT * FROM peliculas");
    $sentenciaSQL->execute();
    $listaPeliculas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['SeleccionarFecha'])){
            $txtFechaInicio=$_POST['txtFechaInicio'];
            $txtFechaFin=$_POST['txtFechaFin'];
    }elseif (isset($_POST['ImprimirInforme'])){
            header("Location:ImprimirInformePelicula.php");
    }elseif (isset($_POST['CancelarFecha'])){
        $txtFechaInicio="";
        $txtFechaFin="";
    }else{

    }

?>

<div class="container">
    <br/>
    <div class="card">
        <div class="card-header"><em>Informe de Peliculas</em></div>
            <div class="card-body">
            <form action="InformePeliculas.php" method="post"> 
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
                    <form action="InformePeliculas.php" method="post">    
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
    <div class="card-header"><em>Peliculas</em></div>
        <div class="card-body">
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Titulo</th>
                    <th>Duracion [Min]</th>
                    <th>Restriccion Edad</th>
                    <th>Categoria</th>
                    <th>Tipo</th>
                    <th>Precio [$]</th>
                    <th>Descripcion</th>
                    <th>Imagen</th>
                    <th>Habilitada</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                //Sentencia para recorrer la tabla "Peliculas" y ir llenando cada fila con los datos que corresponda de cada pelicula
                foreach($listaPeliculas as $pelicula){
                    if ($pelicula['habilitada']=="Si"){    
                ?>
                <tr>
                    <td><?php echo $pelicula['IdPelicula']?> </td>
                    <td><?php echo $pelicula['titulo']?> </td>
                    <td><?php echo $pelicula['duracion']?> </td>
                    <td><?php echo $pelicula['restriccionEdad']?> </td>
                    <td><?php echo $pelicula['categoria']?> </td>
                    <td><?php echo $pelicula['tipo']?></td>
                    <td><?php echo $pelicula['precio']?></td>
                    <td><?php echo $pelicula['descripcion']?></td>
                <td>
                <img src="../../../GamesOfMovies/img/<?php echo $pelicula['imgResource']?>" width="75" alt="">
                </td>
                    <td><?php echo $pelicula['habilitada']?></td>
                </tr>
                <?php }}         
                    ?>
                </tbody>
                </table>
            </tbody>
        </div>
    </div>
    <br/>
</div>

<?php


