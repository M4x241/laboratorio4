<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require("verificarsession.php");
include("conexion.php");
include 'verificarestado.php';

// Consulta a la base de datos para obtener los IDs de los usuarios con el rol "usuario"
$query = $conexion->prepare("SELECT id FROM usuarios WHERE rol = ?");
$rol = 'usuario';
$query->bind_param("s", $rol);
$query->execute();
$result = $query->get_result();

$usuarios = [];
if ($result->num_rows > 0) {
    while ($usuario = $result->fetch_assoc()) {
        $usuarios[] = $usuario['id'];
    }

    header('Content-Type: application/json');
    echo json_encode($usuarios);
} else {
    // Si no se encuentran usuarios con el rol "usuario"
    http_response_code(404);
    echo json_encode(["error" => "No se encontraron usuarios con el rol 'usuario'"]);
}

// Cerrar consulta y conexión
$query->close();
$conexion->close();
?>
