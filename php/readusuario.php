<?php
session_start();

require("verificarsession.php");
include("conexion.php");
include 'verificarestado.php';
include("verificarrol.php");


$sql = "SELECT id,nombre,correo,rol,estado FROM usuarios";

$resultado = $conexion->query($sql);

$arreglo = [];


while ($row = mysqli_fetch_array($resultado)) {
    $arreglo[] = [
        "id" => $row['id'],
        "nombre" => $row['nombre'],
        "correo" => $row['correo'],
        "rol" => $row['rol'],
        "estado" => $row['estado']
    ];
}


$nuevoarreglo = [
    "datos" => $arreglo
];
echo json_encode($nuevoarreglo);
