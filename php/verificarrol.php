<?php
session_start();
if ($_SESSION["rol"] !== "admin") {
    echo "Usted no está autorizado para realizar esta operación";
  
    die();
}
?>
