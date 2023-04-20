<?php
include ("CabeceraUsuario.php");
include("Conexion.php");

//Variables a utilizar
$IdPelicula=(isset($_POST['idPelicula']))?$_POST['idPelicula']:"";
$FechaFinal=(isset($_POST['fechaFinal']))?$_POST['fechaFinal']:"".date("Y-m-d");;
$FechaBD=date('d-m-Y', strtotime($FechaFinal));

//Consulta sobre la tabla "Peliculas" que luego es utilizada para ser mostradas en la pagina
$sentenciaSQL = $conexion->prepare("SELECT * FROM peliculas WHERE habilitada like 'Si'");
$sentenciaSQL->execute();
$listaPeliculas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

//Condicionales, en el cual se guarda en la Session las variables de Cartelera-IdPelicula-HoraPelicula-FechaPelicula, que son utilizadas al cambiar de pagina
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
          <?php
          //Variables donde se guarda independientemente el dia,mes y Año actuales, Variables Minimas que son utilizadas para el rango de la fecha
          $DiaMin=(date('d', strtotime(date("Y-m-d"))));
          $MesMin=(date('m', strtotime(date("Y-m-d"))));
          $AñoMin=(date('Y', strtotime(date("Y-m-d"))));

          //Variables donde se guarda independientemente el dia,mes y Año actuales, Variables Maximas que son utilizadas para el rango de la fecha
          $DiaMax=(date('d', strtotime(date("Y-m-d")))+15);
          $MesMax=(date('m', strtotime(date("Y-m-d")."+1 month")));
          $AñoMax=(date('Y', strtotime(date("Y-m-d"))));

          //Dependiende que mes y los dias maximos que tenga el mes correspondiente, se cambia de cambia de mes y se recalculan los dias
          if ($DiaMax>28 && $MesMax==02){
            $DiaMax=(date('d', strtotime($DiaMax))-28);
            $MesMax=(date('m', strtotime($MesMax."+1 month")));
          }elseif ($DiaMax>30 && ($MesMax==04 || $MesMax==06 || $MesMax==09 || $MesMax==11)){
            $DiaMax=(date('d', strtotime($DiaMax))-30);
            $MesMax=(date('m', strtotime($MesMax."+1 month")));
          }elseif ($DiaMax>31 && ($MesMax==01 || $MesMax==03 || $MesMax==05 || $MesMax==07 || $MesMax==08 || $MesMax==10)){
            $DiaMax=(date('d', strtotime($DiaMax))-31);
            $MesMax=(date('m', strtotime($MesMax."+1 month")));
          }elseif ($DiaMax>31 && $MesMax==12){
            $DiaMax=(date('d', strtotime($DiaMax))-31);
            $MesMax=(date('m', strtotime($MesMax."-11 month")));
            $AñoMax=(date('Y', strtotime($AñoMax."+1 year")));
          }

PROBAR LOS FILTROS POR FECHAS
          ?>
          <input type="date" id="start" name="fechaFinal" 
          value="<?php echo $FechaFinal?>" 
          min="<?php echo $AñoMin?>-<?php echo $MesMin?>-<?php echo $DiaMin;?>" 
          max="<?php echo $AñoMax?>-<?php echo $MesMax?>-<?php echo $DiaMax;?>">
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
  <?php} 
  ?>
  </div> 
  <br/>
</div>  






