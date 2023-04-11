<?php
include ("CabeceraUsuario.php");
include("Conexion.php");

$BuscarIdPelicula=$_SESSION['IdPelicula'];
$sentenciaSQL = $conexion->prepare("SELECT * FROM peliculas WHERE habilitada like 'Si' And IdPelicula=$BuscarIdPelicula");
$sentenciaSQL->execute();
$listaPeliculas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<?php
foreach($listaPeliculas as $pelicula){ 

    ?>
    <div class="card mb-3" style="max-width: 850px;">


  <div class="row g-0">

    <div class="col-md-4 mt-3">
    <img src="../../../GamesOfMovies/img/<?php echo $pelicula['imgResource']?>" width="300" alt="">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">Titulo: <?php echo $pelicula['titulo'];  ?></h5>
        <br/>
        <p class="card-text">Descripcion: <?php  echo $pelicula['descripcion'];?><br/>
        Duracion: <?php echo $pelicula['duracion'];?> Min<br/>
        Restriccion Edad: <?php echo $pelicula['restriccionEdad'];?><br/>
        Categoria: <?php echo $pelicula['categoria'];?><br/>
        Tipo: <?php echo $pelicula['tipo'];?><br/>
        Precio: <?php echo $pelicula['precio'];?> $<br/>
        </p>

      </div>
    </div>
  </div>
</div>

<?php
} ?>
