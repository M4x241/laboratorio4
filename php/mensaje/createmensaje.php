<?php
session_start();
include '../conexion.php';
include '../verificarsession.php';
include '../verificarrol.php';
include '../verificarestado.php';

$destinatario = $_POST['destinatario'];
$asunto = $_POST['asunto'];
$emisor =$_SESSION["correo"];
$estado = $_POST['estado'];




// Insertar nuevo mensaje
$stmt = $conexion->prepare("INSERT INTO mensaje(destinatario, asunto, emisor, estado) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssss", $destinatario, $asunto, $emisor, $estado);

if ($stmt->execute()) {
    echo "usuario creado correctamente";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();
