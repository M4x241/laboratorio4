<?php 
session_start();
include("conexion.php");

require("../verificarsession.php");
require("../verificarrol.php");
require("../verificarestado.php");

$id = $_GET['id'] ?? null;

if ($id === null) {
    echo "ID no especificado";
    exit;
}

// Usa la variable correcta de conexión:
$stmt = $conexion->prepare('DELETE FROM mensajes WHERE id=?');
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "mensaje eliminado";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
