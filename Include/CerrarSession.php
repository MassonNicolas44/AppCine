<?php
//Codigo para iniciar la Session y destruirla, luego envia al login
session_start();


unset($_SESSION['IdUsuario']);
unset($_SESSION['NombreUsuario']);
unset($_SESSION['ApellidoUsuario']);
unset($_SESSION['Usuario']);
unset($_SESSION['EmailUsuario']);
unset($_SESSION['Privilegio']);
unset($_SESSION['TipoListaAdministrativo']);
unset($_SESSION['TipoListaInforme']);
unset($_SESSION['url']);

session_destroy();
header("location:../login.php");
?>