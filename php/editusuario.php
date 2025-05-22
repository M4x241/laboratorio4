<?php

session_start();
include("conexion.php");
require("verificarsession.php");
require("verificarrol.php");
require 'verificarestado.php';

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$rol = $_POST['rol'];
$estado = $_POST['estado'];
$id=$_POST['id'];


$stmt = $conexion->prepare('UPDATE usuarios SET nombre=?,correo=?, password=?,rol=?,estado =? where id=?');

$stmt->bind_param('sssssi',$nombre,$correo,$password,$rol,$estado,$id);


if ($stmt->execute()) {
    echo "usuario Actualizado";
} else {
    echo "Error: " . $stmt->error;
}

$conexion->close();
