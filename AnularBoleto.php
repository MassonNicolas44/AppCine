<?php
include "Conexion.php";
include "CabeceraUsuario.php";

//Variables a utilizar
$Anular = "Si";
$NombreUsuario = $_SESSION['Usuario'];
$IdVenta = (isset($_POST['idVenta'])) ? $_POST['idVenta'] : "";
//Consulta a la Base de Datos para Luego en caso de anular un boleto, realice un update y modifique la columna correspondiente
$sentenciaSQL = $conexion->prepare("SELECT pr.IdVenta,us.IdUsuario,us.usuario,pe.titulo,pr.fechaPelicula,pr.horaPelicula,pr.CantBoleto, pr.precioFinal, pr.Anulada
    FROM proyecciones AS pr 
    INNER JOIN peliculas AS pe ON pe.IdPelicula=pr.IdPelicula
    INNER JOIN usuarios AS us ON pr.IdUsuario =us.IdUsuario
    WHERE us.usuario like $NombreUsuario and
          pr.Anulada like 'No'
    ORDER BY pr.fechaPelicula");
$sentenciaSQL->execute();
$listaVentas = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['AnularVenta'])) {
    $sentenciaSQL = $conexion->prepare("UPDATE proyecciones SET Anulada=:Anulada WHERE IdVenta=:IdVenta");
    $sentenciaSQL->bindParam(':IdVenta', $IdVenta);
    $sentenciaSQL->bindParam(':Anulada', $Anular);
    $sentenciaSQL->execute();
    header("Location:AnularBoleto.php");
}

?>
<br />
<div class="container">
    <div class="card">
        <div class="card-header"><em>Ventas</em></div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Titulo</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Cantidad Boleto</th>
                        <th>Precio Final [$]</th>
                        <th>Acciones</th>
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
                                <?php echo $Ventas['precioFinal'] ?>
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
