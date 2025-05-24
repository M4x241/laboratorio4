<?php
session_start();

require("../verificarsession.php");
include("../conexion.php");
include '../verificarestado.php';
include("../verificarrol.php");



$correo = $_GET['correo'];

// Preparar y ejecutar la consulta
$sql = "SELECT 
            mensajes.id,
            mensajes.asunto,
            mensajes.estado,
            mensajes.emisor,
            emisor.nombre AS nombre_emisor
        FROM 
            mensajes
        JOIN 
            usuarios AS emisor ON mensajes.emisor = emisor.correo
        WHERE 
            mensajes.destinatario = ?
            AND mensajes.estado = 'enviado'";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

$arreglo = [];
while ($row = $resultado->fetch_assoc()) {
    $arreglo[] = $row;
}

echo json_encode(["datos" => $arreglo]);
