<?php 
session_start();
include "conexion.php";

require "verificarsession.php";
require "verificarestado.php";

$para = $_POST['para'] ?? null;
$asunto = $_POST['asunto'] ?? null;
$mensaje = $_POST['mensaje'] ?? null;
$estado = $_POST['estado'] ?? null;

if (!$para || !$asunto || !$mensaje || !$estado) {
    echo json_encode(["success" => false, "error" => "Todos los campos son obligatorios"]);
    exit;
}

// Obtener el ID del remitente desde la sesión
$remitente_id = $_SESSION['id'] ?? null;

if (!$remitente_id) {
    echo json_encode(["success" => false, "error" => "Usuario no autenticado"]);
    exit;
}

$stmt = $conexion->prepare('SELECT id FROM correos WHERE correo = ?');
$stmt->bind_param("s", $para);
$stmt->execute();
$result = $stmt->get_result();
$recipient = $result->fetch_assoc();

if (!$recipient) {
    echo json_encode(["success" => false, "error" => "El correo especificado no existe"]);
    $stmt->close();
    $conexion->close();
    exit;
}

$para_id = $recipient['id'];
$stmt->close();

$stmt = $conexion->prepare('INSERT INTO correos (remitente_id, destinatario_id, asunto, mensaje, estado) VALUES (?, ?, ?, ?, ?)');
$stmt->bind_param("iisss", $remitente_id, $para_id, $asunto, $mensaje, $estado);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conexion->close();
