<?php
include ("CabeceraUsuario.php");
include("Conexion.php");

$IdPelicula=(isset($_POST['idPelicula']))?$_POST['idPelicula']:"";

$sentenciaSQL = $conexion->prepare("SELECT * FROM peliculas WHERE habilitada like 'Si'");
$sentenciaSQL->execute();
$listaPeliculas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['Reserva'])){
  $_SESSION['Cartelera']="Si";
  $_SESSION['IdPelicula']=$IdPelicula;
  header("location:ReservarBoleto.php");
}

?>
<div class="container">   
<div class="card-deck mt-3">
<?php
foreach($listaPeliculas as $pelicula){ 
    ?>

      <div class="card text-center border-info">
      <br/>

      <div class="col">

<img src="../../../GamesOfMovies/img/<?php echo $pelicula['imgResource']?>" width="160" alt="">

    </div>
        <div class="card-body">
        <h5 class="card-title">Titulo: <?php echo $pelicula['titulo'];  ?></h5>
        <br/>
        <p class="card-text">Descripcion: <?php  echo $pelicula['descripcion'];?><br/>
        Duracion: <?php echo $pelicula['duracion'];?> Min<br/>
        Restriccion Edad: <?php echo $pelicula['restriccionEdad'];?><br/>
        Categoria: <?php echo $pelicula['categoria'];?><br/>
        Tipo: <?php echo $pelicula['tipo'];?><br/>
        Precio: <?php echo $pelicula['precio'];?> $<br/>
        <br/>

        <form action="Cartelera.php" method="post">       
        <input type="hidden" name="idPelicula" IdPelicula="idPelicula" value="<?php echo $pelicula['IdPelicula'];?>"> 
        <button class="btn btn-primary" type="submit" name="Reserva">Reservar Boleto</button>
        </form>
        </p>
        </div>
      </div>                         


<?php
} 
?>
  </div> 
  <br/>
</div>  






