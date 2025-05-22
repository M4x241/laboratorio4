<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    echo "Usted no está autorizado para realizar esta operación";
    die();
}
?>
