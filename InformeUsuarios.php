<?php
include "Conexion.php";
include "Cabecera.php";

$txtFechaInicio=(isset($_POST['txtFechaInicio']))?$_POST['txtFechaInicio']:"";
$txtFechaFin=(isset($_POST['txtFechaFin']))?$_POST['txtFechaFin']:"";

    //Sentencia para seleccionar todos los datos de una pelicula de la base de datos (tabla "peliculas") desde la web
    $sentenciaSQL = $conexion->prepare("SELECT * FROM usuarios");
    $sentenciaSQL->execute();
    $listaUsuarios=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['SeleccionarFecha'])){
            $txtFechaInicio=$_POST['txtFechaInicio'];
            $txtFechaFin=$_POST['txtFechaFin'];
    }elseif (isset($_POST['ImprimirInforme'])){
            header("Location:ImprimirInformeUsuarios.php");
    }elseif (isset($_POST['CancelarFecha'])){
        $txtFechaInicio="";
        $txtFechaFin="";
    }else{

    }

?>

<br/>



<div class="container">
<div class="card">
    <div class="card-header"><em>Usuarios</em></div>
    <div class="card-header">
            <form action="InformeUsuarios.php" method="post">    
            <button type="submit" name="ImprimirInforme"  class="btn btn-info">Imprimir Informe</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Usuario</th>
                    <th>contraseña</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Habilitado</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                //Sentencia para recorrer la tabla "Peliculas" y ir llenando cada fila con los datos que corresponda de cada pelicula
                foreach($listaUsuarios as $Usuarios){
                    if ($Usuarios['habilitado']=="Si"){    
                ?>
                <tr>
                    <td><?php echo $Usuarios['IdUsuario']?> </td>
                    <td><?php echo $Usuarios['usuario']?> </td>
                    <td><?php echo $Usuarios['contraseña']?> </td>
                    <td><?php echo $Usuarios['nombre']?> </td>
                    <td><?php echo $Usuarios['telefono']?> </td>
                    <td><?php echo $Usuarios['email']?> </td>
                    <td><?php echo $Usuarios['habilitado']?></td>
                </tr>
                <?php }}         
                    ?>
                </tbody>
                </table>
            </tbody>
        </div>
    </div>
    <br/>
</div>

<?php
