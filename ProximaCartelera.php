<?php
include ("CabeceraUsuario.php");
include("Conexion.php");


$url='http://'.$_SERVER['HTTP_HOST']."/GamesOfMovies";

$sentenciaSQL = $conexion->prepare("SELECT * FROM proximaspeliculas WHERE habilitada like 'Si'");
$sentenciaSQL->execute();
$listaProximasPeliculas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>
<div class="container">   
<div class="card-deck mt-3">
<?php
foreach($listaProximasPeliculas as $ProximasPeliculas){ 

    ?>

      <div class="card text-center border-info">
      <br/>

      <div class="col">

      <a href="<?php echo $url;?>/Usuario3.php"><img src="../../../GamesOfMovies/img/<?php echo $ProximasPeliculas['imgResource']?>" width="250" alt="">
</a>
    </div>
        <div class="card-body">
        <h5 class="card-title">Titulo: <?php echo $ProximasPeliculas['titulo'];  ?></h5>
        <br/>
        <p class="card-text">
        Duracion: <?php echo $ProximasPeliculas['duracion'];?> Min<br/>
        Restriccion Edad: <?php echo $ProximasPeliculas['restriccionEdad'];?><br/>
        Categoria: <?php echo $ProximasPeliculas['categoria'];?><br/>
        Tipo: <?php echo $ProximasPeliculas['tipo'];?><br/>
        Fecha Estreno: <?php echo $ProximasPeliculas['fechaEstreno'];?><br/>
        </p>
        </div>
      </div>                         


<?php
} 
?>
  </div> 
</div>  






