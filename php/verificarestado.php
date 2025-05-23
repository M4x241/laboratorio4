<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["estado"]) || $_SESSION["estado"] !== "activo") {
    echo "Usted está suspendido";
    die();
}
?>
