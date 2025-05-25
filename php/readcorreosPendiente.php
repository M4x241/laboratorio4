<?php
session_start();

require("verificarsession.php");
include("conexion.php");
include 'verificarestado.php';

$correoSesion = $_SESSION['correo'];

// Consulta para recuperar los datos de la tabla con la condición de estado pendiente
$sql = "SELECT id, remitente_id, destinatario_id, asunto, mensaje, estado, fecha 
    FROM correos 
    WHERE remitente_id = (SELECT id FROM usuarios WHERE correo = ?) 
    AND estado = 'borrador'";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $correoSesion);
$stmt->execute();
$resultado = $stmt->get_result();

$arreglo = [];

while ($row = $resultado->fetch_assoc()) {
    // Obtener el correo del destinatario
    $sqlCorreoDestinatario = "SELECT correo FROM usuarios WHERE id = ?";
    $stmtCorreo = $conexion->prepare($sqlCorreoDestinatario);
    $stmtCorreo->bind_param("i", $row['destinatario_id']);
    $stmtCorreo->execute();
    $resultadoCorreo = $stmtCorreo->get_result();
    $correoDestinatario = $resultadoCorreo->fetch_assoc()['correo'] ?? null;

    $arreglo[] = [
        "id" => $row['id'],
        "remitente_id" => $row['remitente_id'],
        "destinatario_id" => $row['destinatario_id'],
        "correo" => $correoDestinatario,
        "asunto" => $row['asunto'],
        "mensaje" => $row['mensaje'],
        "estado" => $row['estado'],
        "fecha" => $row['fecha']
    ];
}

$nuevoarreglo = [
    "datos" => $arreglo
];
echo json_encode($nuevoarreglo);
