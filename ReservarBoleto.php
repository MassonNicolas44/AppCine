<?php
include ("CabeceraUsuario.php");
include("Conexion.php");



/*
REVISAR LAS FECHAS AL FINAL DE MES Y TAMBIEN LA CANTIDAD DE DIAS
AGREGAR TEXTO DONDE MUESTRE LA CANTIDAD DE BOLETOS DISPONIBLES
AGREGAR VERIFICACION DE CANTIDAD DE BOLETOS Y NO DEJE INGRESAR EN CASO DE SER AFIRMATIVO

*/

$FechaActual=date("Y-m-d");

$CantidadBoleto=(isset($_POST['CantidadBoleto']))?$_POST['CantidadBoleto']:"1";
$PrecioFinal=(isset($_POST['PrecioFinal']))?$_POST['PrecioFinal']:"0";
$FechaFinal=(isset($_POST['fechaFinal']))?$_POST['fechaFinal']:"".$FechaActual;
$Contador=(int)$CantidadBoleto;
$HorarioPelicula=(isset($_POST['horarioPelicula']))?$_POST['horarioPelicula']:"16hs";

$IdUsuario=$_SESSION['IdUsuario'];
$IdPelicula=$_SESSION['IdPelicula'];
$sentenciaSQL = $conexion->prepare("SELECT * FROM peliculas WHERE habilitada like 'Si' And IdPelicula=$IdPelicula");
$sentenciaSQL->execute();
$listaPeliculas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

foreach($listaPeliculas as $pelicula){ 

$PrecioUnico=$pelicula['precio'];
}


if (isset($_POST['Mas'])){
  $Contador=(int)$CantidadBoleto+1;
  }elseif (isset($_POST['Menos'])){
    $Contador=(int)$CantidadBoleto-1;
  }elseif (isset($_POST['Reserva'])){
    $PrecioFinal=$Contador*$PrecioUnico;
  
    $FechaBD = date("d-m-Y", strtotime($FechaFinal));
  
  //Sentencia para realizar la carga de una nueva proyeccion a la base de datos
  $sentencia="INSERT INTO proyecciones (IdPelicula, IdUsuario, fechaPelicula,horaPelicula,CantBoleto,precioFinal,Anulada) 
  VALUES ('$IdPelicula','$IdUsuario','$FechaBD','$HorarioPelicula','$CantidadBoleto','$PrecioFinal','No')";
  $accion = $conexion->query($sentencia); 
  header("location:Cartelera.php"); 
  }
  
  $PrecioFinal=$Contador*$PrecioUnico;
  if ($Contador==0){
    $Contador=1;
    $PrecioFinal=$Contador*$PrecioUnico;
  }

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
        <p class="card-text">Descripcion: <?php  echo $pelicula['descripcion'];?><br/>
        Duracion: <?php echo $pelicula['duracion'];?> Min<br/>
        Restriccion Edad: <?php echo $pelicula['restriccionEdad'];?><br/>
        Categoria: <?php echo $pelicula['categoria'];?><br/>
        Tipo: <?php echo $pelicula['tipo'];?><br/>
        Precio: <?php echo $pelicula['precio'];?> $<br/>

        </p>
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

       <label >Horario Pelicula:</label>
<br/> 16 Hs <input type="radio" <?php echo ($HorarioPelicula=="16hs")?"checked":""; ?> name="horarioPelicula" value="16hs">
<br/> 19 Hs <input type="radio" <?php echo ($HorarioPelicula=="19hs")?"checked":""; ?> name="horarioPelicula" value="19hs">
<br/> 22 Hs <input type="radio" <?php echo ($HorarioPelicula=="22hs")?"checked":""; ?> name="horarioPelicula" value="22hs">
<br/>
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

