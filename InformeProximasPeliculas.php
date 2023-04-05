<?php
include "Conexion.php";
include "Cabecera.php";

$txtFechaInicio=(isset($_POST['txtFechaInicio']))?$_POST['txtFechaInicio']:"";
$txtFechaFin=(isset($_POST['txtFechaFin']))?$_POST['txtFechaFin']:"";

    //Sentencia para seleccionar todos los datos de una pelicula de la base de datos (tabla "peliculas") desde la web
    $sentenciaSQL = $conexion->prepare("SELECT * FROM proximaspeliculas");
    $sentenciaSQL->execute();
    $listaPeliculas2=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['SeleccionarFecha'])){
            $txtFechaInicio=$_POST['txtFechaInicio'];
            $txtFechaFin=$_POST['txtFechaFin'];
    }elseif (isset($_POST['ImprimirInforme'])){
            header("Location:ImprimirInformeProximasPelicula.php");
    }elseif (isset($_POST['CancelarFecha'])){
        $txtFechaInicio="";
        $txtFechaFin="";
    }else{

    }

?>



<br/>



<div class="container">
<div class="card">
    <div class="card-header"><em>Proximas Peliculas</em></div>
        <div class="card-header">
            <form action="InformeProximasPeliculas.php" method="post">    
            <button type="submit" name="ImprimirInforme"  class="btn btn-info">Imprimir Informe</button>
            </form>
        </div>
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
    <br/>
</div>

<?php
