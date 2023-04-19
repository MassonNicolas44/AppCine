<?php
//Codigo para iniciar la Session y destruirla, luego envia al login
session_start();
session_destroy();
header("location:login.php");
?>
