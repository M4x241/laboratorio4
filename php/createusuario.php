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


//verificamos si ya existe el correo
$sql = "SELECT correo from usuarios";
$existeCorreo = $conexion->query($sql);

if($existeCorreo->num_rows > 0) {
    echo 'el correo ya existe';
}

$stmt = $conexion->prepare('INSERT INTO usuarios(nombre,correo,password,rol,estado) VALUES (?,?,?,?,?) ');

$stmt ->bind_params("sssss",$nombre,$correo,$password,$rol,$estado);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "usuario creado correctamente";
} else {
    echo "Error: " . $stmt->error;
}

$con->close();



