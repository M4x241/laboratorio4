<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require("verificarsession.php");
include("conexion.php");
include 'verificarestado.php';
$emisor_id = $_GET['id'] ?? null;

if (!$emisor_id) {
    http_response_code(400);
    echo json_encode(["error" => "El parámetro emisor_id es requerido"]);
    exit;
}

// Consulta a la base de datos para obtener los correos del emisor
$query = $conexion->prepare("SELECT * FROM correos WHERE remitente_id = ?");
$query->bind_param("i", $emisor_id);
$query->execute();
$result = $query->get_result();

$correos = [];
if ($result->num_rows > 0) {
    while ($correo = $result->fetch_assoc()) {
        // Obtener el correo del destinatario
        $destinatario_id = $correo['destinatario_id'];
        $query_destinatario = $conexion->prepare("SELECT correo FROM usuarios WHERE id = ?");
        $query_destinatario->bind_param("i", $destinatario_id);
        $query_destinatario->execute();
        $result_destinatario = $query_destinatario->get_result();
        $destinatario_correo = $result_destinatario->fetch_assoc()['correo'] ?? null;

        // Agregar el correo del destinatario al resultado
        $correo['destinatario_correo'] = $destinatario_correo;

        $correos[] = $correo;

        $query_destinatario->close();
    }

    header('Content-Type: application/json');
    echo json_encode($correos);
} else {
    // Si no se encuentran correos
    http_response_code(404);
    echo json_encode(["error" => "No se encontraron correos para el emisor_id proporcionado"]);
}

// Cerrar consultas y conexión
$query->close();
$conexion->close();

?>
