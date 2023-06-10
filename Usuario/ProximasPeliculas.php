<?php

require_once "../Include/Conexion.php";
require_once "../Include/Funciones.php";
require_once "../Include/Cabecera.php";

//Lista de ProximasPeliculas, recopiladas desde la Base de Datos
$listaProximasPeliculas=ListaProximasPeliculas($db,"Habilitada");


?>
<div class="container">   
  <div class="card-deck mt-3">
  <?php
  //Se recorren los datos solicitados anteriormente y se utilizan en cada columna/fila correspondiente
  foreach($listaProximasPeliculas as $ProximasPeliculas){ 
    ?>
      <div class="card text-center border-info">
      <br/>
      <div class="col">
      <img src="../../../GamesOfMovies/img/<?php echo $ProximasPeliculas['imgResource']?>" width="250" alt=""></a>
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






