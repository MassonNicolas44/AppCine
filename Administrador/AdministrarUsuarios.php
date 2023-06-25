<?php
require_once "../Include/Conexion.php";
require_once "../Include/Funciones.php";
require_once "../Include/Cabecera.php";

//Variables a utilizar
$IdUsuario = (isset($_POST['idUsuario'])) ? $_POST['idUsuario'] : "";

$listaUsuarios=ListaUsuarios($db);

if (isset($_POST['HabilitarUsuario'])) {

    AccionUsuario($db, 'Si', null, $IdUsuario);

} elseif (isset($_POST['InhabilitarUsuario'])) {

    AccionUsuario($db, null, 'No', $IdUsuario);

}



?>

<br />

<div class="container">
    <div class="card">
        <div class="card-header"><em>Usuarios</em>
    </div>
        
        <div class="card-header">
            <form action="InformeUsuarios.php" method="post">

            <a href="<?php echo $_SESSION['url']; ?>/Imprimir/Usuarios.php" class="btn btn-info" target='_blank'> Imprimir Informe </a>
            
            </form>
        </div>
        
        <div class="card-body">

            <?php echo isset($_SESSION['HabilitarUsuario']) ? $_SESSION['HabilitarUsuario'] : '' ;?>
            <?php echo isset($_SESSION['InhabilitarUsuario']) ? $_SESSION['InhabilitarUsuario'] : '' ;?>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Habilitado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //Sentencia para recorrer la tabla "usuarios" y ir llenando cada fila con los datos que corresponda de cada usuario
                    foreach ($listaUsuarios as $Usuarios) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $Usuarios['IdUsuario'] ?>
                            </td>
                            <td>
                                <?php echo $Usuarios['usuario'] ?>
                            </td>
                            <td>
                                <?php echo $Usuarios['nombre'] ?>
                            </td>
                            <td>
                                <?php echo $Usuarios['apellido'] ?>
                            </td>
                            <td>
                                <?php echo $Usuarios['telefono'] ?>
                            </td>
                            <td>
                                <?php echo $Usuarios['email'] ?>
                            </td>
                            <td>
                                <?php echo $Usuarios['habilitado'] ?>
                            </td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="idUsuario" IdUsuario="idUsuario" value="<?php echo $Usuarios['IdUsuario']; ?>">
                                    <input type="submit" name="HabilitarUsuario" value="Habilitar" class="btn btn-primary"  onclick="return confirmacionHabilitar()">
                                    <input type="submit" name="InhabilitarUsuario" value="Inhabilitar" class="btn btn-danger"  onclick="return confirmacionInhabilitar()">
                                </form>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
            </tbody>
        </div>
    </div>
    <br />
</div>

<script>
    function confirmacionHabilitar() {
        //Mensaje de confirmacion de Habilitar Usuario
        var respuesta = confirm("¿Deseas Habilitar este Usuario?");
        if (respuesta == true) {
            return true;
        } else {
            return false;
        }
    }

    function confirmacionInhabilitar() {
        //Mensaje de confirmacion de Inhabilitar Usuario
        var respuesta = confirm("¿Deseas Inhabilitar este Usuario?");
        if (respuesta == true) {
            return true;
        } else {
            return false;
        }
    }
</script>
