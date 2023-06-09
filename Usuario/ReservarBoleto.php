<?php

require_once "../Include/Conexion.php";
require_once "../Include/Funciones.php";
require_once "../Include/Cabecera.php";

//Variables a Utilizar
$CantidadBoleto = (isset($_POST['CantidadBoleto'])) ? $_POST['CantidadBoleto'] : "1";
$Contador = (int) $CantidadBoleto;
$PrecioFinal = (isset($_POST['PrecioFinal'])) ? $_POST['PrecioFinal'] : "0";

//Variables tomadas desde la Session activa
$IdUsuario = $_SESSION['IdUsuario'];
$IdPelicula = $_SESSION['IdPelicula'];
$horaPelicula = $_SESSION['horaPelicula'];
$fechaPelicula = date("Y-m-d", strtotime($_SESSION['fechaPelicula']));
$Disponibilidad = 50;

//Sentencia para la recolecciones de informacion de la tabla Peliculas teniendo en cuenta la pelicula seleccionada antes de pasar a esta pagina
$listaPeliculas = ListaPeliculas($db, $Valor = "Habilitada", $txtID = $IdPelicula);

//Sentencia para la recolecciones de informacion teniendo en cuenta la pelicula, fecha y hora seleccionada antes de pasar a esta pagina
$datosPelicula = DatosReserva($db,$fechaPelicula,$horaPelicula,$IdPelicula);

//Guarda en una variable la suma de todos los boletos de la pelicula seleccionada
foreach ($datosPelicula as $datosPelicula2) {
  $CantBoleto = $datosPelicula2['Disponibilidad'];
}

//Guarda en una variable, el precio de la pelicula seleccionada
foreach ($listaPeliculas as $pelicula) {
  $PrecioUnico = $pelicula['precio'];
}


//En caso de seleccionar Mas, aumenta el contador
//En caso de seleccionar Menos, disminuye el contador
//En caso de seleccionar Reserva, se ingresa la compra del boleto con los datos correspondiente a la base de datos
if (isset($_POST['Mas'])) {
  $Contador = (int) $CantidadBoleto + 1;
} elseif (isset($_POST['Menos'])) {
  if ($Contador != 1) {
    $Contador = (int) $CantidadBoleto - 1;
  }
} elseif (isset($_POST['Reserva'])) {
  $PrecioFinal = $Contador * $PrecioUnico;
  //Sentencia para realizar la carga de una nueva proyeccion a la base de datos
  RegistrarBoleto($db,$IdPelicula,$IdUsuario,$fechaPelicula,$horaPelicula,$CantidadBoleto,$PrecioFinal);
  
}

//Aumenta CantBoleto (Contador que el usuario va incrementando o disminuyendo)
$CantBoleto += $Contador;
//Disminuye la disponibilidad, restando la cantidad de boletos
$Disponibilidad = $Disponibilidad - $CantBoleto;

//En caso que la disponibilidad pase a ser negativa, disminuye el contador y aumenta la disponibilidad. Logrando asi que nunca baje a -1
if ($Disponibilidad < 0) {
  $Contador = $Contador - 1;
  $Disponibilidad = $Disponibilidad + 1;
}

$PrecioFinal = $Contador * $PrecioUnico;

?>
<?php
foreach ($listaPeliculas as $pelicula) {

  ?>
  <div class="card mb-3" style="max-width: 1050px;">


    <div class="row g-0">

      <div class="col-md-4 mt-3">
        <img src="../../../GamesOfMovies/img/<?php echo $pelicula['imgResource'] ?>" width="340" alt="">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title">Titulo:
            <?php echo $pelicula['titulo']; ?>
          </h5>
          <p class="card-text">Descripcion:
            <?php echo $pelicula['descripcion']; ?><br />
            Duracion:
            <?php echo $pelicula['duracion']; ?> Min<br />
            Restriccion Edad:
            <?php echo $pelicula['restriccionEdad']; ?><br />
            Categoria:
            <?php echo $pelicula['categoria']; ?><br />
            Tipo:
            <?php echo $pelicula['tipo']; ?><br />
            Precio:
            <?php echo $pelicula['precio']; ?> $<br />

          </p>
          <br />

          <form action="ReservarBoleto.php" method="post">
            <div class="row">
              <div class="col-md-4"><label>Cantidad Boleto:</label></div>
              <div class="col-md-4"><label>Disponibilidad Boleto:</label></div>

            </div>
            <div class="row">
              <div class="col-md-4">
                <button class="btn btn-primary" type="submit" name="Menos">-</button>
                <input type="text" value="<?php echo $Contador; ?>" name="CantidadBoleto" readonly placeholder=1 size="2"
                  maxlength="5">
                <button class="btn btn-primary" type="submit" name="Mas">+</button>
              </div>
              <div class="col-md-4">
                <input type="text" value="<?php echo $Disponibilidad; ?>" name="DisponibilidadBoleto" disabled
                  placeholder=1 size="2" maxlength="5">
              </div>
            </div>

            <label>Fecha Pelicula:
              <?php echo $fechaPelicula ?>
            </label>
            </br>
            <label>Hora Pelicula:
              <?php echo $horaPelicula ?>
            </label>

            </br>
            Precio Final: <input type="text" value="<?php echo $PrecioFinal; ?>" name="PrecioFinal" size="5" maxlength="5"
              disabled=true> $
            <br />
            </br>
            <button class="btn btn-primary" type="submit" name="Reserva">Finalizar</button>
          </form>


        </div>
      </div>
    </div>
  </div>

  <?php
} ?>