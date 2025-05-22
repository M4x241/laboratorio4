<?php
session_start();
if ($_SESSION["estado"] !== "activo") {
    echo "Usted esta suspendido";
  
    die();
}
?>
