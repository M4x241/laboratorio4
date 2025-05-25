<?php
session_start();

require("verificarsession.php");
include("conexion.php");
include 'verificarestado.php';

$correoSesion = $_SESSION['correo'];

// Consulta para recuperar los datos de la tabla con la condición de estado enviado
$sql = "SELECT c.id, c.remitente_id, c.destinatario_id, c.asunto, c.mensaje, c.estado, c.fecha, u.correo AS destinatario_correo
    FROM correos c
    JOIN usuarios u ON c.destinatario_id = u.id
    WHERE c.remitente_id = (SELECT id FROM usuarios WHERE correo = ?) 
    AND c.estado = 'enviado'";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $correoSesion);
$stmt->execute();
$resultado = $stmt->get_result();

$arreglo = [];

while ($row = $resultado->fetch_assoc()) {
    $arreglo[] = [
        "id" => $row['id'],
        "remitente_id" => $row['remitente_id'],
        "destinatario_id" => $row['destinatario_id'],
        "correo" => $row['destinatario_correo'],
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
