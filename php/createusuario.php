<?php
session_start();
include 'conexion.php';
include 'verificarsession.php';
include 'verificarrol.php';
include 'verificarestado.php';

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$rol = $_POST['rol'];
$estado = 'activo';

// Verificar si el correo ya existe
$sql = "SELECT correo FROM usuarios WHERE correo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo 'el correo ya existe';
    $stmt->close();
    $conexion->close();
    exit;
}
$stmt->close();

// Insertar nuevo usuario
$stmt = $conexion->prepare("INSERT INTO usuarios(nombre, correo, password, rol, estado) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nombre, $correo, $password, $rol, $estado);

if ($stmt->execute()) {
    echo "usuario creado correctamente";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();
