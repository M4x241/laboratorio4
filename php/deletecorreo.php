<?php 
session_start();
include("conexion.php");

require("verificarsession.php");
require("verificarestado.php");

$id = $_GET['id'] ?? null;

if ($id === null) {
    echo "ID no especificado";
    exit;
}

$stmt = $conexion->prepare('DELETE FROM correos WHERE id=?');
$stmt->bind_param("i", $id);


if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}


$stmt->close();
$conexion->close();
?>
