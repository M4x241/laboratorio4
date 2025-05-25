<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require("verificarsession.php");
include("conexion.php");
include 'verificarestado.php';
$id = $_GET['id'] ?? null;

// Consulta a la base de datos para obtener el correo
$query = $conexion->prepare("SELECT * FROM correos WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $correo = $result->fetch_assoc();

    // Obtener el correo del remitente
    $remitente_id = $correo['remitente_id'];
    $query_remitente = $conexion->prepare("SELECT correo FROM usuarios WHERE id = ?");
    $query_remitente->bind_param("i", $remitente_id);
    $query_remitente->execute();
    $result_remitente = $query_remitente->get_result();
    $remitente_correo = $result_remitente->fetch_assoc()['correo'] ?? null;

    // Obtener el correo del destinatario
    $destinatario_id = $correo['destinatario_id'];
    $query_destinatario = $conexion->prepare("SELECT correo FROM usuarios WHERE id = ?");
    $query_destinatario->bind_param("i", $destinatario_id);
    $query_destinatario->execute();
    $result_destinatario = $query_destinatario->get_result();
    $destinatario_correo = $result_destinatario->fetch_assoc()['correo'] ?? null;

    // Agregar los correos al resultado
    $correo['remitente_correo'] = $remitente_correo;
    $correo['destinatario_correo'] = $destinatario_correo;

    header('Content-Type: application/json');
    echo json_encode($correo);
} else {
    // Si no se encuentra el correo
    http_response_code(404);
    echo json_encode(["error" => "Correo no encontrado"]);
}

// Cerrar consultas y conexión
$query->close();
if (isset($query_remitente)) $query_remitente->close();
if (isset($query_destinatario)) $query_destinatario->close();
$conexion->close();

?>