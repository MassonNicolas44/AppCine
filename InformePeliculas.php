<?php
include "Conexion.php";
include "Cabecera.php";


$rdgTipo=(isset($_POST['Tipo']))?$_POST['Tipo']:"Peliculas";


if ($rdgTipo=="Peliculas"){
    $sentenciaSQL = $conexion->prepare("SELECT * FROM peliculas");
    $sentenciaSQL->execute();
    $listaPeliculas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
}elseif ($rdgTipo=="ProximasPeliculas"){
    $sentenciaSQL = $conexion->prepare("SELECT * FROM proximaspeliculas");
    $sentenciaSQL->execute();
    $listaPeliculas2=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
}


    if (isset($_POST['SeleccionarFecha'])){
            $txtFechaInicio=$_POST['txtFechaInicio'];
            $txtFechaFin=$_POST['txtFechaFin'];
    }elseif (isset($_POST['ImprimirInforme'])){
            if ($rdgTipo=="Peliculas"){
                header("Location:ImprimirInformePelicula.php");
            }elseif ($rdgTipo=="ProximasPeliculas"){
                header("Location:ImprimirInformeProximasPelicula.php");
            }
    }else{

    }

?>

<br/>

<div class="container">
    <div class="card">
        <?php
        if($rdgTipo=="Peliculas"){ ?>
        <div class="card-header"><em>Informe de Peliculas</em></div>
        <?php }elseif($rdgTipo=="ProximasPeliculas"){ ?>
            <div class="card-header"><em>Informe de Proximas Peliculas</em></div>
            <?php }; ?>
            <div class="card-body">
            <form action="InformePeliculas.php" method="post">
                 
                        <div class="row">
                            Peliculas <input type="radio" <?php echo ($rdgTipo=="Peliculas")?"checked":"";?> name="Tipo" value="Peliculas">
                        </div>       
                        <div class="row">             
                            Proximas Peliculas <input type="radio" <?php echo ($rdgTipo=="ProximasPeliculas")?"checked":"";?> name="Tipo" value="ProximasPeliculas">
                        </div>
                        <br/>
                        <div class = "col">
                            <button type="submit" name="SeleccionarInforme" class="btn btn-info">Seleccionar Tipo Informe</button>
                            <button type="submit" name="ImprimirInforme"  class="btn btn-info">Imprimir Informe</button>
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

<?php
if($rdgTipo=="Peliculas"){
?>
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
    <?php
}elseif($rdgTipo=="ProximasPeliculas"){
?>
<div class="card-header"><em>Proximas Peliculas</em></div>
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
                    <th>Imagen</th>
                    <th>Fecha Estreno</th>
                    <th>Habilitada</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                //Sentencia para recorrer la tabla "Peliculas" y ir llenando cada fila con los datos que corresponda de cada pelicula
                foreach($listaPeliculas2 as $pelicula2){
                    if ($pelicula2['habilitada']=="Si"){    
                ?>
                <tr>
                    <td><?php echo $pelicula2['IdPelicula']?> </td>
                    <td><?php echo $pelicula2['titulo']?> </td>
                    <td><?php echo $pelicula2['duracion']?> </td>
                    <td><?php echo $pelicula2['restriccionEdad']?> </td>
                    <td><?php echo $pelicula2['categoria']?> </td>
                    <td><?php echo $pelicula2['tipo']?></td>
                <td>
                <img src="../../../GamesOfMovies/img/<?php echo $pelicula2['imgResource']?>" width="75" alt="">
                </td>
                <td><?php echo $pelicula2['fechaEstreno']?></td>
                    <td><?php echo $pelicula2['habilitada']?></td>
                </tr>
                <?php }}         
                    ?>
                </tbody>
                </table>
            </tbody>
        </div>
    </div>
    <?php  }?>
    <br/>
</div>

<?php


