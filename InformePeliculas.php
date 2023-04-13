<?php
include "Conexion.php";
include "CabeceraAdministrador.php";


$IdPelicula=(isset($_POST['idPelicula']))?$_POST['idPelicula']:"";
$IdProximasPelicula=(isset($_POST['idProximasPelicula']))?$_POST['idProximasPelicula']:"";
$rdgTipo=(isset($_POST['Tipo']))?$_POST['Tipo']:"Peliculas";
$Habilitacion="Si";
$anularHabilitacion="No";

if ($rdgTipo=="Peliculas"){
    $sentenciaSQL = $conexion->prepare("SELECT * FROM peliculas");
    $sentenciaSQL->execute();
    $listaPeliculas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
}elseif ($rdgTipo=="ProximasPeliculas"){
    $sentenciaSQL = $conexion->prepare("SELECT * FROM proximaspeliculas");
    $sentenciaSQL->execute();
    $listaPeliculas2=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
}

    if (isset($_POST['ImprimirInforme'])){
            if ($rdgTipo=="Peliculas"){
                header("Location:ImprimirInformePelicula.php");
            }elseif ($rdgTipo=="ProximasPeliculas"){
                header("Location:ImprimirInformeProximasPelicula.php");
            }
    }elseif (isset($_POST['HabilitarPelicula'])){
        $sentenciaSQL = $conexion->prepare("UPDATE peliculas SET habilitada=:habilitada WHERE idPelicula=:idPelicula");
        $sentenciaSQL->bindParam(':idPelicula',$IdPelicula);
        $sentenciaSQL->bindParam(':habilitada',$Habilitacion);
        $sentenciaSQL->execute();
        header("Location:InformePeliculas.php");
    }elseif (isset($_POST['InhabilitarPelicula'])){
        $sentenciaSQL = $conexion->prepare("UPDATE peliculas SET habilitada=:habilitada WHERE idPelicula=:idPelicula");
        $sentenciaSQL->bindParam(':idPelicula',$IdPelicula);
        $sentenciaSQL->bindParam(':habilitada',$anularHabilitacion);
        $sentenciaSQL->execute();
        header("Location:InformePeliculas.php");
    }elseif (isset($_POST['HabilitarProximasPeliculas'])){
        $sentenciaSQL = $conexion->prepare("UPDATE proximaspeliculas SET habilitada=:habilitada WHERE idPelicula=:idPelicula");
        $sentenciaSQL->bindParam(':idPelicula',$IdProximasPelicula);
        $sentenciaSQL->bindParam(':habilitada',$Habilitacion);
        $sentenciaSQL->execute();
        header("Location:InformePeliculas.php");
    }elseif (isset($_POST['InhabilitarProximasPeliculas'])){
        $sentenciaSQL = $conexion->prepare("UPDATE proximaspeliculas SET habilitada=:habilitada WHERE idPelicula=:idPelicula");
        $sentenciaSQL->bindParam(':idPelicula',$IdProximasPelicula);
        $sentenciaSQL->bindParam(':habilitada',$anularHabilitacion);
        $sentenciaSQL->execute();
        header("Location:InformePeliculas.php");
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
                foreach($listaPeliculas as $pelicula){ 
                ?>
                <tr>
                    <td><?php echo $pelicula['IdPelicula']?> </td>
                    <td><?php echo $pelicula['titulo']?> </td>
                    <td><?php echo $pelicula['duracion']?> Min</td>
                    <td><?php echo $pelicula['restriccionEdad']?> </td>
                    <td><?php echo $pelicula['categoria']?> </td>
                    <td><?php echo $pelicula['tipo']?></td>
                    <td><?php echo $pelicula['precio']?>  $</td>
                    <td><?php echo $pelicula['descripcion']?></td>
                <td>
                <img src="../../../GamesOfMovies/img/<?php echo $pelicula['imgResource']?>" width="75" alt="">
                </td>
                    <td><?php echo $pelicula['habilitada']?></td>
                    <td> <form method="post">
                        <input type="hidden" name="idPelicula" IdUsuario="idPelicula" value="<?php echo $pelicula['IdPelicula'];?>">
                        <input type="submit" name="HabilitarPelicula" value="Habilitar" class="btn btn-primary" onclick="return confirmacionHabilitar()">
                        <input type="submit" name="InhabilitarPelicula" value="Inhabilitar" class="btn btn-danger" onclick="return confirmacionInhabilitar()">
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
}elseif($rdgTipo=="ProximasPeliculas"){
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
                foreach($listaPeliculas2 as $pelicula2){
                ?>
                <tr>
                    <td><?php echo $pelicula2['IdPelicula']?> </td>
                    <td><?php echo $pelicula2['titulo']?> </td>
                    <td><?php echo $pelicula2['duracion']?> Min</td>
                    <td><?php echo $pelicula2['restriccionEdad']?> </td>
                    <td><?php echo $pelicula2['categoria']?> </td>
                    <td><?php echo $pelicula2['tipo']?></td>
                <td>
                <img src="../../../GamesOfMovies/img/<?php echo $pelicula2['imgResource']?>" width="75" alt="">
                </td>
                <td><?php echo $pelicula2['fechaEstreno']?></td>
                    <td><?php echo $pelicula2['habilitada']?></td>
                    <td> <form method="post">
                        <input type="hidden" name="idProximasPelicula" IdUsuario="idProximasPelicula" value="<?php echo $pelicula2['IdPelicula'];?>">
                        <input type="submit" name="HabilitarProximasPeliculas" value="Habilitar" class="btn btn-primary" onclick="return confirmacionHabilitar()">
                        <input type="submit" name="InhabilitarProximasPeliculas" value="Inhabilitar" class="btn btn-danger" onclick="return confirmacionInhabilitar()">
                    </form>
                </tr>
                <?php }      
                    ?>
                </tbody>
                </table>
            </tbody>
        </div>
    </div>
    <?php  }?>
    <br/>
</div>

<script>
    function confirmacionHabilitar(){
        var respuesta = confirm("¿Deseas Habilitar este Usuario?");
        if(respuesta==true){
            return true;
        }else{
            return false;
        }
    }

    function confirmacionInhabilitar(){
        var respuesta = confirm("¿Deseas Inhabilitar este Usuario?");
        if(respuesta==true){
            return true;
        }else{
            return false;
        }
    }
</script>

<?php


