<?php

session_start();

require("../verificarsession.php");
include("../conexion.php");
include '../verificarestado.php';
include("../verificarrol.php");


$sql = "SELECT id,destinatario,asunto,emisor,estado FROM mensajes";

$resultado = $conexion->query($sql);

$arreglo = [];


while ($row = mysqli_fetch_array($resultado)) {
    $arreglo[] = [
        "id" => $row['id'],
        "destinatario" => $row['destinatario'],
        "asunto" => $row['asunto'],
        "emisor" => $row['emisor'],
        "estado" => $row['estado']
    ];
}


$nuevoarreglo = [
    "datos" => $arreglo
];
echo json_encode($nuevoarreglo);
