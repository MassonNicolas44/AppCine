<?php
include ("CabeceraUsuario.php");
include("Conexion.php");

$IdPelicula=(isset($_POST['idPelicula']))?$_POST['idPelicula']:"";
$FechaActual=date("Y-m-d");
$FechaFinal=(isset($_POST['fechaFinal']))?$_POST['fechaFinal']:"".$FechaActual;
$FechaBD=date('d-m-Y', strtotime($FechaFinal));


$sentenciaSQL = $conexion->prepare("SELECT * FROM peliculas WHERE habilitada like 'Si'");
$sentenciaSQL->execute();
$listaPeliculas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['16hs'])){
  $_SESSION['Cartelera']="Si";
  $_SESSION['IdPelicula']=$IdPelicula;
  $_SESSION['horaPelicula']="16hs";
  $_SESSION['fechaPelicula']=$FechaBD;
  header("location:ReservarBoleto.php");
}elseif (isset($_POST['19hs'])){
  $_SESSION['Cartelera']="Si";
  $_SESSION['IdPelicula']=$IdPelicula;
  $_SESSION['horaPelicula']="19hs";
  $_SESSION['fechaPelicula']=$FechaBD;
  header("location:ReservarBoleto.php");
}elseif (isset($_POST['22hs'])){
  $_SESSION['Cartelera']="Si";
  $_SESSION['IdPelicula']=$IdPelicula;
  $_SESSION['horaPelicula']="22hs";
  $_SESSION['fechaPelicula']=$FechaBD;
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

        <label >Fecha:</label>

<?php $fechaActual = date("Y-m-d");
$Dia=(date('d', strtotime($fechaActual))+15);
$Mes=(date('m', strtotime($fechaActual."+1 month")));
$Año=(date('Y', strtotime($fechaActual)));
?>

<input type="date" id="start" name="fechaFinal" 
value="<?php echo $FechaFinal?>" 
min="<?php echo $fechaActual?>" 
max="<?php echo $Año?>-<?php echo $Mes?>-<?php echo $Dia;?>">
</br>
</br>
        <label >Horario Pelicula:</label>
        <div class="col">
        <button class="btn btn-primary" type="submit" name="16hs">16 hs</button>
        <label >-----------</label>
        <button class="btn btn-primary" type="submit" name="19hs">19 hs</button>    
        <label >-----------</label>
        <button class="btn btn-primary" type="submit" name="22hs">22 hs</button>
        </div>
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






