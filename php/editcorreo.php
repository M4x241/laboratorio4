<?php
// Ensure no output before headers
ob_start();
session_start();
header('Content-Type: application/json');
include "conexion.php";

require "verificarsession.php";
require "verificarestado.php";

$id = $_GET['id'] ?? null;
$estado = 'enviado';

if (!$id) {
    echo json_encode([
        "success" => false, 
        "error" => "El ID del correo es obligatorio"
    ]);
    exit;
}

$remitente_id = $_SESSION['id'] ?? null;

if (!$remitente_id) {
    echo json_encode(["success" => false, "error" => "Usuario no autenticado"]);
    exit;
}

$stmt = $conexion->prepare('UPDATE correos SET estado = ? WHERE id = ? AND remitente_id = ?');
$stmt->bind_param("sii", $estado, $id, $remitente_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "No se encontró el correo o no se realizaron cambios"]);
    }
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conexion->close();

ob_end_flush();
