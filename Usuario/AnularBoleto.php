<?php

require_once "../Include/Conexion.php";
require_once "../Include/Funciones.php";
require_once "../Include/Cabecera.php";



//Variables a utilizar
$NombreUsuario = $_SESSION['Usuario'];
$IdVenta = (isset($_POST['idVenta'])) ? $_POST['idVenta'] : "";

//Lista de Boletos Comprados por el usuario Logeado
$listaVentas = AnularBoleto($db,$NombreUsuario,"Lista");

if (isset($_POST['AnularVenta'])) {
    //Funcion para anular la venta de boleto realizada por el usuario
    AnularBoleto($db,$NombreUsuario,"AnularVenta",$IdVenta);
}

?>
<br />
<div class="container">
    <div class="card">
        <div class="card-header"><em>Lista de Reservas</em></div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Pelicula</th>
                        <th>Fecha Pelicula</th>
                        <th>Hora Pelicula</th>
                        <th>Cant. Boleto</th>
                        <th>Precio Final</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //Sentencia para recorrer las Ventas y ir llenando cada fila con los datos que correspondientes
                    foreach ($listaVentas as $Ventas) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $Ventas['usuario'] ?>
                            </td>
                            <td>
                                <?php echo $Ventas['nombre'] ?>
                            </td>
                            <td>
                                <?php echo $Ventas['apellido'] ?>
                            </td>
                            <td>
                                <?php echo $Ventas['titulo'] ?>
                            </td>
                            <td>
                                <?php echo $Ventas['fechaPelicula'] ?>
                            </td>
                            <td>
                                <?php echo $Ventas['horaPelicula'] ?>
                            </td>
                            <td>
                                <?php echo $Ventas['CantBoleto'] ?>
                            </td>
                            <td>
                                <?php echo $Ventas['precioFinal'] ."$" ?>
                            </td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="idVenta" IdVenta="idVenta"
                                        value="<?php echo $Ventas['IdVenta']; ?>">
                                    <input type="submit" name="AnularVenta" value="Anular" class="btn btn-primary"
                                        onclick="return Anular()">
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
    ?>
    <br />
</div>

<script>
    function Anular() {
        //mensaje de confirmacion de anulacion de reserva
        var respuesta = confirm("¿Deseas Anular esta Reserva?");
        if (respuesta == true) {
            return true;
        } else {
            return false;
        }
    }
</script>
<?php
