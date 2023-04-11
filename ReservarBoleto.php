<?php
include ("CabeceraUsuario.php");
include("Conexion.php");
$FechaActual=date("Y-m-d");

$CantidadBoleto=(isset($_POST['CantidadBoleto']))?$_POST['CantidadBoleto']:"0";
$PrecioFinal=(isset($_POST['PrecioFinal']))?$_POST['PrecioFinal']:"0";
$FechaFinal=(isset($_POST['fechaFinal']))?$_POST['fechaFinal']:"".$FechaActual;
$Contador=(int)$CantidadBoleto;

$BuscarIdPelicula=$_SESSION['IdPelicula'];
$sentenciaSQL = $conexion->prepare("SELECT * FROM peliculas WHERE habilitada like 'Si' And IdPelicula=$BuscarIdPelicula");
$sentenciaSQL->execute();
$listaPeliculas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

foreach($listaPeliculas as $pelicula){ 

$PrecioUnico=$pelicula['precio'];
}

if (isset($_POST['Mas'])){
$Contador=$Contador+1;
}elseif (isset($_POST['Menos'])){
  $Contador=(int)$CantidadBoleto-1;
}elseif (isset($_POST['Reserva'])){
  $PrecioFinal=$Contador*$PrecioUnico;
echo "reservado";
echo "Fecha: ".$FechaFinal;
echo "Cantidad de Boletos: ".$CantidadBoleto;
echo "Precio Final: ".$PrecioFinal;
}

$PrecioFinal=$Contador*$PrecioUnico;

?>
<?php
foreach($listaPeliculas as $pelicula){ 

    ?>
    <div class="card mb-3" style="max-width: 1050px;">


  <div class="row g-0">

    <div class="col-md-4 mt-3">
    <img src="../../../GamesOfMovies/img/<?php echo $pelicula['imgResource']?>" width="340" alt="">
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
        <br/>
        <br/>

        <form action="ReservarBoleto.php" method="post">

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

        <label >Cantidad Boleto:</label>
        <div class = "col">
        <button class="btn btn-primary" type="submit" name="Menos">-</button>
        <input type="text" value="<?php echo $Contador;?>" name="CantidadBoleto" placeholder=1 size="2" maxlength="5" >
        <button class="btn btn-primary" type="submit" name="Mas">+</button>
        
        </div>
</br>
        Precio Final: <input type="text" value="<?php echo $PrecioFinal;?>" name="PrecioFinal" size="5" maxlength="5" disabled=true> $
  <br/>
  </br>
        <button class="btn btn-primary" type="submit" name="Reserva">Finalizar</button>
        </form>


      </div>
    </div>
  </div>
</div>

<?php
} ?>

